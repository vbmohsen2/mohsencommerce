<?php

namespace App\Livewire;

use Livewire\Component;

class Carousel extends Component
{
    public $images = [
        'images/slides/shal.png',
        'images/slides/romanoscarf2.png',
        'images/slides/gemini shal.png',
//        'images/slides/Accessories pc v1 copy-1600x400.jpg',
//        'images/slides/Gaming Consoles slider pc v1 copy-1600x400.jpg',
//        'images/slides/Gaming System slider pc v1 copy-1600x400.jpg',
//        'images/slides/Gpus slider pc v1 copy (2)-1600x400.jpg'

    ];

    public $currentSlide = 0;

    public function nextSlide()
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->images);
    }

    public function prevSlide()
    {
        $this->currentSlide = ($this->currentSlide - 1 + count($this->images)) % count($this->images);
    }

    public function render()
    {
        return view('livewire.carousel');
    }
}
