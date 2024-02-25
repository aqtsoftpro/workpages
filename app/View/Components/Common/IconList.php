<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IconList extends Component
{
    public $name;
    public $id;
    public $value;
    public $label;
    
    public function __construct($name, $id, $label, $value = null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.icon-list');
    }
}
