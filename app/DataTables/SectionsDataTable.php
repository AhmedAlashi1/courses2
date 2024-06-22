<?php

namespace App\DataTables;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Courses;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class SectionsDataTable extends DataTable
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
            ->addColumn('action', function ($sections) {
               $title =  App::getLocale() == 'en' ? $sections->title_ar : $sections->title_en;
                return view('dashboard.sections.actions', ['id' => $sections->id,'name' => $title, 'courses_id' => $sections->courses->id]);
            })
            ->addColumn('status', function ($sections) {
                return view('dashboard.sections.status', ['sections' => $sections]);
            })
            ->addColumn('name', function ($sections) {
                return App::getLocale() == 'en'  ? $sections->title_ar : $sections->title_en;
            })
            ->addColumn('courses', function ($sections) {
                return $sections->courses ? $sections->courses->title_ar : '';
            })
            ->addColumn('is_paid', function ($sections) {
                return $sections->is_paid == 1 ? __('Paid') : __('Free');
            })

            ->addColumn('created_at', function ($sections) {
                return $sections->crecreated_at ?  $sections->created_at->format('Y-m-d H:i') : $sections->created_at ;
            })
            ->rawColumns(['action'])


            ->filterColumn('name', function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('title_ar', 'like', '%' . $keyword . '%')
                        ->orWhere('title_en', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('created_at', 'like', '%' . $keyword . '%');
                });
            })
            ->orderColumn('status', function ($query, $order) {
                $query->orderBy('status', $order);
            })
            ->orderColumn('name', function ($query, $order) {
                $column = App::getLocale() == 'ar' ? 'title_ar' : 'title_en';
                $query->orderBy($column, $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\sections $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
//    public function query(Sections $model): QueryBuilder
//    {
//        return $model->newQuery()->latest();
//    }

    public function query(Sections $model, Request $request): QueryBuilder
    {
        $id = $request->route('courses_id');

        $query = $id ? $model->newQuery()->where('courses_id', $id)->with('courses') : $model->newQuery();

        return $query->latest();
    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
{
    return $this->builder()
        ->setTableId('sections-table')
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
//            Column::make('image')
//                ->title(__('messages.photo'))
//                ->addClass('text-center pt-3'),
            Column::make('name')
                ->title(__('messages.Name'))
                ->addClass('text-center pt-3'),
            Column::make('courses')
                ->title(__('messages.courses'))
                ->addClass('text-center pt-3'),
            Column::make('is_paid')
                ->title(__('messages.payment_status'))
                ->addClass('text-center pt-3'),
            Column::make('status')
                ->title(__('messages.Status'))
                ->addClass('text-center'),
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

}
