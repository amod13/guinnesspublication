<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DataTable extends Component
{
    public $title;
    public $createRoute;
    public $createLabel;
    public $bulkDeleteUrl;
    public $filterAction;
    public $filterPlaceholder;
    public $records;
    public $columns;
    public $sortUrl;
    public $editRoute;
    public $deleteRoute;
    public $sortable;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $title = null,
        $createRoute = null,
        $createLabel = 'Add New',
        $bulkDeleteUrl = null,
        $filterAction = null,
        $filterPlaceholder = 'Search...',
        $records = [],
        $columns = [],
        $sortUrl = null,
        $editRoute = null,
        $deleteRoute = null,
        $sortable = true
    ) {
        $this->title = $title;
        $this->createRoute = $createRoute;
        $this->createLabel = $createLabel;
        $this->bulkDeleteUrl = $bulkDeleteUrl;
        $this->filterAction = $filterAction;
        $this->filterPlaceholder = $filterPlaceholder;
        $this->records = $records;
        $this->columns = $columns;
        $this->sortUrl = $sortUrl;
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
        $this->sortable = filter_var($sortable, FILTER_VALIDATE_BOOLEAN); // string "false" case handle garna
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.data-table');
    }
}
