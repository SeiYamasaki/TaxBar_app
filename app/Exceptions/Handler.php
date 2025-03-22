<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // ZoomAPI関連の出力をキャプチャしてログにリダイレクト
        if (!app()->runningInConsole()) {
            ob_start(function ($buffer) {
                // APIのデバッグ出力を検出
                if (str_contains($buffer, 'zoom.us') && str_contains($buffer, '* Connected to')) {
                    // ログに記録
                    \Illuminate\Support\Facades\Log::debug('Captured Zoom API Debug Output', [
                        'length' => strlen($buffer)
                    ]);
                    // 空文字列を返して出力をスキップ
                    return '';
                }
                // その他の通常の出力はそのまま
                return $buffer;
            });
        }
    }
}
