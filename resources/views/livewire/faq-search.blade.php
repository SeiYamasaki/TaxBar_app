<div>
    <input type="text" wire:model="search" class="form-control" placeholder="キーワードで検索...">

    <div class="list-group mt-3">
        @foreach ($faqs as $faq)
            <div class="list-group-item">
                <h5>{{ $faq->question }}</h5>
                <p>{{ $faq->answer }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $faqs->links() }}
    </div>
</div>
