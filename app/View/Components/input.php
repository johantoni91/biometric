<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component
{
    /**
     * Create a new component instance.
     */
    public $id;
    public $type;
    public $placeholder;
    public $required;
    public $value;
    public function __construct($id, $value = '', $type = 'text', $placeholder = '', $required = true)
    {
        $this->id = $id;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
