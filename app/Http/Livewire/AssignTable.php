<?php

namespace App\Http\Livewire;

use Excel;
use App\Models\Assign;
use App\Exports\CustomExport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class AssignTable extends DataTableComponent
{
    
    protected $model = Assign::class;
    public $counter  = 1;
    public function mount()
    {
        $this->dispatchBrowserEvent('table-refreshed');
    }

    public function configure(): void
    {
        $this->counter = 1;
        $this->setFilterPillsStatus(false);

        $this->setFiltersDisabled();
        $this->setBulkActionsDisabled();
        $this->setColumnSelectDisabled();

        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc')
            ->setEmptyMessage('No Result Found')
            ->setTableAttributes([
                'id' => 'assign-table',
            ])
            ->setBulkActions([
                'exportSelected' => 'Export',
            ])
            ->setConfigurableAreas([
                'toolbar-right-end' => 'content.rapasoft.add-button',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Action')
                ->label(function ($row, Column $column) {
                    $delete_route  = route('admin.assigns.destroy', $row->id);
                    $edit_route    = route('admin.assigns.edit', $row->id);
                    $edit_callback = 'setValue';
                    $modal         = '#edit-assign-modal';

                    return view('content.table-component.action', compact('edit_route', 'delete_route', 'edit_callback', 'modal'));
                }),
            Column::make('SrNo.', 'id')
                ->sortable()
                ->format(function () {
                     return (($this->page - 1) * $this->getPerPage()) + ($this->counter++);
                })
                ->html(),
            Column::make("Assigned To", 'employee.name'),                
            Column::make("Project Title", 'project.title'),
            Column::make("Start Date", 'project.start_date'),
            Column::make("End Date", 'project.end_date'),
        ];
    }

    public function builder(): Builder
    {
        $modal = Assign::query();
        $modal->with(['employee', 'project'])
                ->whereNotNull('employee_id')
                ->whereNotNull('project_id')
                ->get();
        return $modal;
    }

    public function refresh(): void
    {
    }

    public function exportSelected()
    {
        $modelData = new Assign();
        return Excel::download(new CustomExport($this->getSelected(), $modelData), 'contactus.xlsx');
    }

}
