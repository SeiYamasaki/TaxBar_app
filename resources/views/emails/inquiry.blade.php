<p class="text-lg font-semibold">新しいお問い合わせがあります。</p>

<p class="mt-4"><strong>お名前:</strong> <span class="font-medium">{{ $name }}</span></p>
<p class="mt-2"><strong>メールアドレス:</strong> <span class="font-medium">{{ $email }}</span></p>
<p class="mt-2"><strong>お問い合わせ内容:</strong><br><span class="font-medium">{{ nl2br(e($inquiry_message)) }}</span></p>
