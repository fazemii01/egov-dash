<?php

namespace App\DataTables;

use App\Models\AnnouncementsModel as Announcements;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AnnouncementsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['title', 'file_path', 'published_at', 'action'])
            ->editColumn('title', function (Announcements $announcement) {
                return view('pages.apps.announcements.columns._title', compact('announcement'));
            })
            ->editColumn('file_path', function (Announcements $announcement) {
                return view('pages.apps.announcements.columns._file', compact('announcement'));
            })
            ->editColumn('published_at', function (Announcements $announcement) {
                if ($announcement->published_at) {
                    try {
                        $publishedDate = Carbon::parse($announcement->published_at);
                        return sprintf('<div class="badge badge-light fw-bold">%s</div>',
                            $publishedDate->format('d M Y'));
                    } catch (\Exception $e) {
                        return sprintf('<div class="badge badge-light fw-bold">%s</div>',
                            $announcement->published_at);
                    }
                }
                return '<div class="badge badge-secondary fw-bold">Belum Dipublikasi</div>';
            })
            ->editColumn('created_at', function (Announcements $announcement) {
                try {
                    $createdDate = Carbon::parse($announcement->created_at);
                    return $createdDate->format('d M Y, h:i a');
                } catch (\Exception $e) {
                    return $announcement->created_at;
                }
            })
            ->addColumn('action', function (Announcements $announcement) {
                return view('pages.apps.announcements.columns._actions', compact('announcement'));
            })
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Announcements $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('announcements-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(4, 'desc') // Urutkan berdasarkan created_at descending (kolom ke-5, index 4)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/announcements/columns/_draw-scripts.js')) . "}");
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
            Column::make('title')->title('Judul Pengumuman')->name('title'),
            Column::make('file_path')->title('File')->searchable(false)->orderable(false),
            Column::make('published_at')->title('Tanggal Publikasi'),
            Column::make('created_at')->title('Tanggal Dibuat')->addClass('text-nowrap'),
            Column::computed('action')
                ->title('Aksi')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(120)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pengumuman_' . date('YmdHis');
    }
}
