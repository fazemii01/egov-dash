<?php

namespace App\DataTables;

use App\Models\BannerModel as Banner;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BannerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['title', 'file', 'link', 'active', 'order', 'action'])
            ->editColumn('title', function (Banner $banner) {
                return view('pages.apps.banner.columns._title', compact('banner'));
            })
            ->editColumn('file', function (Banner $banner) {
                return view('pages.apps.banner.columns._file', compact('banner'));
            })
            ->editColumn('link', function (Banner $banner) {
                if ($banner->link) {
                    return sprintf('<a href="%s" target="_blank" class="text-primary text-hover-primary d-inline-block text-truncate" style="max-width: 200px;" title="%s">%s</a>',
                        $banner->link,
                        $banner->link,
                        Str::limit($banner->link, 30)
                    );
                }
                return '<span class="text-muted">-</span>';
            })
            ->editColumn('active', function (Banner $banner) {
                $status = $banner->active == 'y' ? 'Aktif' : 'Nonaktif';
                $badgeClass = $banner->active == 'y' ? 'badge-light-success' : 'badge-light-danger';

                return sprintf('<div class="badge %s fw-bold">%s</div>', $badgeClass, $status);
            })
            ->editColumn('order', function (Banner $banner) {
                if ($banner->order) {
                    $badgeClass = 'badge-light';
                    if ($banner->order == 1) $badgeClass = 'badge-light-warning';
                    elseif ($banner->order == 2) $badgeClass = 'badge-light-info';
                    elseif ($banner->order == 3) $badgeClass = 'badge-light-primary';

                    return sprintf('<div class="text-center"><span class="badge %s fs-7 px-3 py-2">%s</span></div>', $badgeClass, $banner->order);
                }
                return '<div class="text-center"><span class="badge badge-secondary">-</span></div>';
            })
            ->editColumn('created_at', function (Banner $banner) {
                try {
                    $createdDate = Carbon::parse($banner->created_at);
                    return $createdDate->format('d M Y, h:i a');
                } catch (\Exception $e) {
                    return $banner->created_at;
                }
            })
            ->addColumn('action', function (Banner $banner) {
                return view('pages.apps.banner.columns._actions', compact('banner'));
            })
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Banner $model): QueryBuilder
    {
        // HAPUS orderBy dari sini, biarkan DataTable yang handle sorting
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('banners-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(4, 'asc') // Urutkan berdasarkan order (kolom ke-5, index 4) ascending
            ->orderBy(5, 'desc') // Kemudian urutkan berdasarkan status (kolom ke-6, index 5) descending
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/banner/columns/_draw-scripts.js')) . "}");
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
            Column::make('title')->title('Judul Banner')->name('title'),
            Column::make('file')->title('Gambar')->searchable(false)->orderable(false),
            Column::make('link')->title('Link'),
            Column::make('order')->title('Urutan')->addClass('text-center'),
            Column::make('active')->title('Status'),
            Column::make('created_at')->title('Dibuat Pada')->addClass('text-nowrap'),
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
        return 'Banner_' . date('YmdHis');
    }
}
