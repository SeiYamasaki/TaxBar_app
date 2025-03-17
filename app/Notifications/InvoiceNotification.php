<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Invoice
     */
    protected $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->from(config('mail.addresses.billing'), 'TaxBar 請求担当')
            ->subject('TaxBar - お支払い完了のお知らせ')
            ->greeting('お支払いありがとうございます')
            ->line('TaxBarのサービスをご利用いただきありがとうございます。')
            ->line('お支払いが正常に完了しました。')
            ->line('請求書番号: ' . $this->invoice->invoice_number)
            ->line('金額: ' . number_format($this->invoice->amount) . '円')
            ->line('支払日: ' . $this->invoice->paid_at->format('Y年m月d日'))
            ->action('インボイスの詳細を確認', url('/dashboard/invoices/' . $this->invoice->id))
            ->line('今後ともTaxBarをよろしくお願いいたします。');

        // PDFが存在する場合は添付
        if ($this->invoice->pdf_path && file_exists(storage_path('app/' . $this->invoice->pdf_path))) {
            $message->attach(storage_path('app/' . $this->invoice->pdf_path), [
                'as' => 'invoice-' . $this->invoice->invoice_number . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'invoice_number' => $this->invoice->invoice_number,
            'amount' => $this->invoice->amount,
            'status' => $this->invoice->status,
            'paid_at' => $this->invoice->paid_at,
            'message' => 'お支払いが完了しました。請求書番号: ' . $this->invoice->invoice_number,
        ];
    }
}
