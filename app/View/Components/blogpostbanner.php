<?php

namespace App\View\Components;

use App\Models\Posts;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class blogpostbanner extends Component
{
    /**
     * Create a new component instance.
     */
    public $bannerwitdth;
    public $bannerPostId;
    public function __construct($bannerPostId,$bannerwitdth)
    {
        $this->bannerwitdth = $bannerwitdth;
        $this->bannerPostId =$bannerPostId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.blogpostbanner');
    }
}
