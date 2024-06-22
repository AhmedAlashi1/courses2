<?php

namespace App\DataTables;

use App;
use App\Models\Videos;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class videosDataTable extends DataTable
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
                ->addColumn('action', function ($video) {
                    return view('dashboard.videosFile.actions', ['id' => $video->id,'name' => $video->name]);
                })
               ->addColumn('image', function ($video) {
                   return view('dashboard.videosFile.image', ['photo' => $video->image]);
               })
                ->addColumn('muscle', function ($video) {
                    // Extract the muscle IDs from the 'muscles_id' column
                    $muscleIds = explode(',', $video->muscles_id);

                    // Filter out any non-numeric values to avoid errors
                    $muscleIds = array_filter($muscleIds, 'is_numeric');

                    // Use the 'whereIn' method to fetch the muscles with the IDs from the 'Muscles' table
                    $muscles = Muscles::whereIn('id', $muscleIds)->get();

                    $muscleNames = [];

                    // Determine the local language (English or Arabic)
                    $locale = App::getLocale();

                    // Loop through the fetched muscles and collect their names based on the local language
                    foreach ($muscles as $muscle) {
                        if ($locale === 'en') {
                            $muscleNames[] = $muscle->name_en;
                        } else {
                            $muscleNames[] = $muscle->name_ar;
                        }
                    }

                    // Return a comma-separated string of muscle names
                    return implode(', ', $muscleNames);
                })
                ->rawColumns(['image', 'muscle'])
               ->addColumn('created_at', function ($muscle) {
                   return $muscle->created_at->format('Y-m-d H:i');
               })
               ->filterColumn('muscle', function ($query, $keyword) {
                   $query->whereHas('muscles', function ($q) use ($keyword) {
                       $q->where('name_en', 'like', '%' . $keyword . '%')
                           ->orWhere('name_ar', 'like', '%' . $keyword . '%');
                   });
               })
               ->filterColumn('created_at', function ($query, $keyword) {
                   $query->where(function ($query) use ($keyword) {
                       $query->where('created_at', 'like', '%' . $keyword . '%');
                   });
               })
               ->rawColumns(['muscle'])
               ->orderColumn('muscle', function ($query, $order) {
                   $column = App::getLocale() == 'ar' ? 'name_ar' : 'name_en';
                   $query->orderBy($column, $order);
               })
               ->orderColumn('created_at', function ($query, $order) {
                   $query->orderBy('created_at', $order);
               });

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\VideosFile $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VideosFile $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('videos-table')
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
            Column::make('image')
                ->title(__('messages.photo'))
                ->addClass('text-center pt-3'),
            Column::make('name')
                ->title(__('messages.Name'))
                ->addClass('text-center pt-3')
                ->width('4rem'),
            Column::make('muscle')
                ->title(__('messages.muscles'))
                ->addClass('text-center pt-3'),
            Column::make('place')
                ->title(__('messages.place'))
                ->addClass('text-center pt-3'),
            Column::make('age')
                ->title(__('messages.age'))
                ->addClass('text-center pt-3'),
            Column::make('gender')
                ->title(__('messages.sex'))
                ->addClass('text-center pt-3'),
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
        return 'videos_' . date('YmdHis');
    }
}
