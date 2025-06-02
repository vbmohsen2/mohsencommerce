<?php

namespace App\View\Components;

use App\Models\Posts;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MostsPost extends Component
{
    /**
     * Create a new component instance.
     */
     public $posts;
    public $type;

    public function __construct($posts,$type)
    {
        $this->posts = $posts;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->type === 'comments') {
            // پست‌هایی که بیشترین کامنت‌ها را دارند
            $this->posts = Posts::withCount('PostComments as total_comments')->orderByDesc('total_comments')->
            limit(4)->get();
        }
        if ($this->type === 'viewed') {
            // پست‌هایی که بیشترین کامنت‌ها را دارند
            $this->posts = Posts::orderByDesc('views_count')  // مرتب‌سازی بر اساس تعداد بازدید به صورت نزولی
            ->limit(4)  // محدود کردن به 5 پست
            ->get();

        }

        return view('components.mosts-post');
    }
}
