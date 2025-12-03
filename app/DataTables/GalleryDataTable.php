<?php

namespace App\DataTables;

use App\Models\GalleryModel as Gallery;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GalleryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['activity', 'photos_preview', 'time', 'place', 'status', 'action'])
            ->editColumn('activity', function (Gallery $gallery) {
                return view('pages.apps.gallery.columns._activity', compact('gallery'));
            })
            ->editColumn('photos_preview', function (Gallery $gallery) {
                return view('pages.apps.gallery.columns._photos_preview', compact('gallery'));
            })
            ->editColumn('time', function (Gallery $gallery) {
                if ($gallery->time) {
                    try {
                        $time = Carbon::parse($gallery->time);
                        return sprintf(
                            '<div class="d-flex flex-column">
                                            <span class="text-muted">%s</span>
                                            <span class="text-muted fs-7">%s</span>
                                        </div>',
                            $time->format('d M Y'),
                            $time->format('h:i A')
                        );
                    } catch (\Exception $e) {
                        return sprintf(
                            '<div class="badge badge-light fw-bold">%s</div>',
                            $gallery->time
                        );
                    }
                }
                return '<div class="badge badge-secondary fw-bold">-</div>';
            })
            ->editColumn('place', function (Gallery $gallery) {
                return Str::limit($gallery->place, 40) ?? '-';
            })
            ->addColumn('status', function (Gallery $gallery) {
                $photoCount = $gallery->photos_count ?? 0;
                if ($photoCount > 0) {
                    return '<span class="badge badge-light-success">Aktif</span>';
                }
                return '<span class="badge badge-light-warning">Kosong</span>';
            })
            ->editColumn('created_at', function (Gallery $gallery) {
                try {
                    $createdDate = Carbon::parse($gallery->created_at);
                    return $createdDate->format('d M Y, h:i a');
                } catch (\Exception $e) {
                    return $gallery->created_at;
                }
            })
            ->addColumn('action', function (Gallery $gallery) {
                return view('pages.apps.gallery.columns._actions', compact('gallery'));
            })
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Gallery $model): QueryBuilder
    {
        return $model->newQuery()
            ->withCount('photos as photos_count')
            ->with(['photos' => function ($query) {
                $query->latest()->take(100);
            }]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('gallery-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(5, 'desc')
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/gallery/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->width(30)
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),
            Column::make('activity')->title('Nama Kegiatan')->name('activity')->width(120),
            Column::computed('photos_preview')
                ->title('Foto')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),
            Column::make('time')->title('Waktu')->width(150),
            Column::make('place')->title('Tempat')->width(150),
            Column::computed('status')
                ->title('Status')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),
            Column::make('created_at')->title('Dibuat')->width(150),
            Column::computed('action')
                ->title('Aksi')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Gallery_' . date('YmdHis');
    }
}
