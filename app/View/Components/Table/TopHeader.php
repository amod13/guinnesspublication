<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class TopHeader extends Component
{
    public string $title;
    public ?string $createRoute;
    public ?string $createLabel;
    public ?string $class;
    public bool $column;
    public string $columnLabel;
    public ?string $tableId;
    public bool $isSearch;       // 👈 new property
    public bool $isDashboard;    // 👈 new property

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title,
        ?string $createRoute = null,
        ?string $createLabel = 'Add New',
        ?string $class = '',
        bool $column = false,
        string $columnLabel = 'Columns',
        ?string $tableId = null,
        bool $isSearch = false,       // 👈 default false
        bool $isDashboard = false     // 👈 default false
    ) {
        $this->title = $title;
        $this->createRoute = $createRoute;
        $this->createLabel = $createLabel;
        $this->class = $class;
        $this->column = $column;
        $this->columnLabel = $columnLabel;
        $this->tableId = $tableId;
        $this->isSearch = $isSearch;
        $this->isDashboard = $isDashboard;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.top-header');
    }
}
