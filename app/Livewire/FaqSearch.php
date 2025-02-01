<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Faq;

class FaqSearch extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage(); // 検索時にページネーションをリセット
    }

    public function render()
    {
        $faqs = Faq::where('question', 'like', "%{$this->search}%")
            ->orWhere('answer', 'like', "%{$this->search}%")
            ->paginate(10);

        return view('livewire.faq-search', compact('faqs'));
    }
}
