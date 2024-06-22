<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
class UsersDataTable extends DataTable
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
                ->addColumn('action', function ($user) {
                    return view('dashboard.users.actions', ['id' => $user->id,'name' => $user->name]);
                })
                ->addColumn('status', function ($user) {
                    return __('messages.'.$user->status);
                })
                ->addColumn('image', function ($user) {
                    return view('dashboard.users.image', ['photo' => $user->image]);
                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at->format('Y-m-d H:i');
                })
                ->addColumn('name', function ($user) {
//                        return '<a href="' . route('users.show', $user->id) . '">' . $user->name . '</a>';
                        return '<a href="#">' . $user->name . '</a>';
                })
                ->rawColumns(['action','name'])
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where(function ($query) use ($keyword) {
                        $query->where('created_at', 'like', '%' . $keyword . '%');
                    });
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where(function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                })
                ->orderColumn('status', function ($query, $order) {
                    $query->orderBy('status', $order);
                })
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('name', $order);
                })
                ->orderColumn('created_at', function ($query, $order) {
                    $query->orderBy('created_at', $order);
                });
        }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
//            ->dom('Bfrtip')
            ->orderBy(0)
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
//                        Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

            Column::make('id')
                ->title('#')
                ->addClass('text-center pt-3'),
            Column::make('image')
                ->title(__('messages.photo'))
                ->addClass('text-center pt-3'),
            Column::make('name')
                ->title(__('messages.Name'))
                ->addClass('text-center pt-3'),
            Column::make('phone')
                ->title(__('messages.phone'))
                ->addClass('text-center pt-3'),
            Column::make('status')
                ->title(__('messages.Status'))
                ->addClass('text-center'),
            Column::make('activation_code')
                ->title(__('messages.activation code'))
                ->addClass('text-center pt-3'),
            Column::make('created_at')
                ->title(__('messages.date of join'))
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

}
