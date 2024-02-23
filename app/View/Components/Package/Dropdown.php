<?php

namespace App\View\Components\Package;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public $name;
    public $id;
    public $value;
    public $label;
    public $boolean;
    
    public function __construct($name, $id, $label, $value = null, $boolean=false)
    {
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->label = $label;
        $this->boolean = $boolean;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.package.dropdown');
    }
}
