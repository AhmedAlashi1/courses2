<?php

namespace App\DataTables;

use App\Models\admin;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($admin) {
                return view('dashboard.admins.actions', ['id' => $admin->id,'name' => $admin->name]);
            })
            ->addColumn('created_at', function ($admin) {
                return $admin->created_at->format('Y-m-d H:i');
            })
            ->rawColumns(['action'])
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('created_at', 'like', '%' . $keyword . '%');
                });
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\admin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(admin $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('admins-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->language([
                'search' => __('messages.Search'),
                'lengthMenu' => __('messages.Show').' _MENU_ '.__('messages.Entries'),
                'zeroRecords' => __('messages.No matching records found'),
                'info' => __('messages.Showing').' _START_ '.__('messages.to').' _END_ '.__('messages.of').' _TOTAL_ '.__('messages.entries'),
                'infoEmpty' => __('messages.No records available'),
                'infoFiltered' => __('messages.filtered from').' _MAX_ '.__('messages.total records'),
                'paginate' => [
                    'first' => __('messages.First'),
                    'last' => __('messages.Last'),
                    'next' => __('messages.Next'),
                    'previous' => __('messages.Previous'),
                ],
            ])
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->title('#')
                ->addClass('text-center pt-3'),
            Column::make('email')
                ->title(__('messages.email'))
                ->addClass('text-center pt-3'),
            Column::make('name')
                ->title(__('messages.Name'))
                ->addClass('text-center pt-3'),
            Column::make('roles_name')
                ->addClass('text-center pt-3')
                ->title(__('messages.Roles')),
            Column::make('created_at')
                ->title(__('messages.created at'))
                ->addClass('text-center pt-3'),
            Column::computed('action')
                ->title(__('messages.Actions'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center pt-3')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'admins_' . date('YmdHis');
    }
}
