<?php
namespace App\Http\Livewire;

use App\Exports\CustomExport;
use App\Models\Employee;
use Excel;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class EmployeeTable extends DataTableComponent
{

    protected $model = Employee::class;
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
                'id' => 'employee-table',
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
                    $delete_route  = route('admin.employees.destroy', $row->id);
                    $edit_route    = route('admin.employees.edit', $row->id);
                    $edit_callback = 'setValue';
                    $modal         = '#edit-employee-modal';

                    return view('content.table-component.action', compact('edit_route', 'delete_route', 'edit_callback', 'modal'));
                }),
            Column::make('SrNo.', 'id')
                ->sortable()
                ->format(function ($value, $row, Column $column) {
                     return (($this->page - 1) * $this->getPerPage()) + ($this->counter++);
                })
                ->html(),
            Column::make("Name")
                ->format(function ($value) {
                    return '<span style="display:block;width:200px !important;white-space:normal">' . $value . '</span>';
                })
                ->collapseOnTablet()
                ->sortable()
                ->searchable()
                ->html(),
            Column::make("Email")
                ->format(function ($value) {
                    return '<span style="display:block;width:200px !important;white-space:normal">' . $value . '</span>';
                })
                ->collapseOnTablet()
                ->sortable()
                ->searchable()
                ->html(),
            Column::make("Phone")
                ->format(function ($value) {
                    return '<span style="display:block;width:200px !important;white-space:normal">' . $value . '</span>';
                })
                ->collapseOnTablet()
                ->sortable()
                ->searchable()
                ->html(),
            Column::make('Profile_pic')
                ->format(function ($row) {
                    if ($row) {
                        return '<img src="' . asset($row) . '" alt="" srcset="" class="view-on-click  rounded-circle">';
                    } else {
                        return '<img src="' . asset('images/placeholder.jpg') . '" alt="" srcset="" class="view-on-click  rounded-circle">';
                    }
                })
                ->html(),
        ];
    }

    // public function filters(): array
    // {
    //     return [
    //         SelectFilter::make('Status')
    //             ->options([
    //                 ''        => 'All',
    //                 'active'  => 'Active',
    //                 'blocked' => 'Blocked',
    //             ])
    //             ->filter(function (Builder $builder, string $value) {
    //                 $builder->where('status', $value);
    //             }),
    //     ];
    // }

    // public function builder(): Builder
    // {
    //     $modal = Employee::query();
    //     return $modal;
    // }

    public function refresh(): void
    {
    }

    public function exportSelected()
    {
        $modelData = new Employee;
        return Excel::download(new CustomExport($this->getSelected(), $modelData), 'contactus.xlsx');
    }
}
