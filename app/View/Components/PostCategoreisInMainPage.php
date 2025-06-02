<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\PostCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostCategoreisInMainPage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = PostCategory::has('Posts')->get();//اگر تعداد 0 نبود نشانه بده
        return view('components.post-categoreis-in-main-page',compact('categories'));
    }
}
