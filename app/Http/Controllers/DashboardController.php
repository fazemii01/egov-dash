<?php

namespace App\Http\Controllers;

use App\Models\NewsModel;
use App\Models\AnnouncementsModel;
use App\Models\VisitModel;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // Track homepage visit
        VisitModel::trackHomepage();

        $metrics = [
            // Basic counts
            'total_news' => NewsModel::count(),
            'total_announcements' => AnnouncementsModel::count(),
            
            // News views - dari kolom count_view di tabel news
            'total_news_views' => NewsModel::sum('count_view'),
            
            // Website visitors - dari tabel visit
            'total_visitors' => VisitModel::getUniqueVisitors(),
            
            // Popular news - berdasarkan count_view tertinggi
            'popular_news' => NewsModel::orderByDesc('count_view')
                ->limit(5)
                ->get()
                ->map(function($news) {
                    return [
                        'news' => $news,
                        'views' => $news->count_view
                    ];
                }),
            
            // Recent announcements - 3 terbaru
            'recent_announcements' => AnnouncementsModel::orderByDesc('created_at')
                ->limit(3)
                ->get(),
            
            // 🔥 DATA UNTUK CHARTS - TAMBAH INI ↓↓↓
            
            // Data untuk chart popular news (format yang dibutuhkan JS)
            'popular_news_chart_data' => NewsModel::orderByDesc('count_view')
                ->limit(5)
                ->get()
                ->map(function($news, $index) {
                    return [
                        'country' => \Illuminate\Support\Str::limit($news->headline, 20),
                        'visits' => $news->count_view,
                        'index' => $index
                    ];
                }),
            
            // Data untuk website visitors (daily/weekly/monthly)
            'visitors_data' => [
                'daily' => $this->getDailyVisitors(),
                'weekly' => $this->getWeeklyVisitors(), 
                'monthly' => $this->getMonthlyVisitors()
            ]
        ];

        return view('pages.dashboards.index', compact('metrics'));
    }

    // 🔧 METHOD BARU UNTUK VISITORS DATA
    protected function getDailyVisitors()
    {
        // Visitors 7 hari terakhir
        return VisitModel::where('date', '>=', now()->subDays(7)->format('Y-m-d'))
            ->selectRaw('date, COUNT(DISTINCT ip) as visitors')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) {
                return [
                    'date' => $item->date,
                    'visitors' => $item->visitors
                ];
            });
    }

    protected function getWeeklyVisitors()
    {
        // Visitors 4 minggu terakhir  
        return VisitModel::where('date', '>=', now()->subWeeks(4)->format('Y-m-d'))
            ->selectRaw('YEAR(date) as year, WEEK(date) as week, COUNT(DISTINCT ip) as visitors')
            ->groupBy('year', 'week')
            ->orderBy('year')
            ->orderBy('week')
            ->get()
            ->map(function($item) {
                return [
                    'period' => 'Week ' . $item->week,
                    'visitors' => $item->visitors
                ];
            });
    }

    protected function getMonthlyVisitors()
    {
        // Visitors 6 bulan terakhir
        return VisitModel::where('date', '>=', now()->subMonths(6)->format('Y-m-d'))
            ->selectRaw('YEAR(date) as year, MONTH(date) as month, COUNT(DISTINCT ip) as visitors')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'period' => date('M Y', strtotime($item->year . '-' . $item->month . '-01')),
                    'visitors' => $item->visitors
                ];
            });
    }
}