<?php

namespace App\View\Components;

use App\Models\Posts;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class showposts extends Component
{
    /**
     * Create a new component instance.
     */
    public $posts;
    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
//        $Posts=Posts::where('is_published',true)->paginate(3);
        return view('components.showposts');
    }
}
