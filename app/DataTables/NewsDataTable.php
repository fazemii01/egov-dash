<?php

namespace App\DataTables;

use App\Models\NewsModel as News;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['headline', 'images', 'published_at', 'action'])
            ->editColumn('headline', function (News $news) {
                return view('pages.apps.news.columns._headline', compact('news'));
            })
            ->editColumn('images', function (News $news) {
                return view('pages.apps.news.columns._images', compact('news'));
            })
            ->editColumn('content', function (News $news) {
                return Str::limit(strip_tags($news->content), 100);
            })
            ->editColumn('published_at', function (News $news) {
                if ($news->published_at) {
                    try {
                        $publishedDate = Carbon::parse($news->published_at);
                        return sprintf('<div class="badge badge-light fw-bold">%s</div>',
                            $publishedDate->format('d M Y'));
                    } catch (\Exception $e) {
                        return sprintf('<div class="badge badge-light fw-bold">%s</div>',
                            $news->published_at);
                    }
                }
                return '<div class="badge badge-secondary fw-bold">Belum Dipublikasi</div>';
            })
            ->editColumn('created_at', function (News $news) {
                try {
                    $createdDate = Carbon::parse($news->created_at);
                    return $createdDate->format('d M Y, h:i a');
                } catch (\Exception $e) {
                    return $news->created_at;
                }
            })
            ->addColumn('action', function (News $news) {
                return view('pages.apps.news.columns._actions', compact('news'));
            })
            ->setRowId('id')
            ->addIndexColumn(); // Tambahkan ini untuk nomor urut
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(News $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('news-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(5, 'desc') // Urutkan berdasarkan created_at descending (kolom ke-6, index 5)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/news/columns/_draw-scripts.js')) . "}");
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
            Column::make('headline')->title('Judul Berita')->name('headline'),
            Column::make('images')->title('Gambar')->searchable(false)->orderable(false),
            Column::make('content')->title('Konten')->searchable(true),
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
        return 'Berita_' . date('YmdHis');
    }
}
