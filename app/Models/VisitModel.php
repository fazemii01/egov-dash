<?php
// app/Models/VisitModel.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitModel extends Model
{
     protected $table = 'visit';
    protected $fillable = ['ip', 'time', 'link', 'date'];
    public $timestamps = false;

    // METHOD TRACKER
    public static function trackHomepage()
    {
        $today = now()->format('Y-m-d');
        $ip = request()->ip();

        if (!self::where(['ip' => $ip, 'link' => '/', 'date' => $today])->exists()) {
            self::create([
                'ip' => $ip,
                'link' => '/',
                'date' => $today,
                'time' => now()
            ]);
        }
    }

    public static function getUniqueVisitors()
    {
        return self::distinct('ip')->count('ip');
    }

 
    public static function getTodayVisitors()
    {
        return self::where('date', now()->format('Y-m-d'))
            ->distinct('ip')
            ->count('ip');
    }

    public static function getThisWeekVisitors()
    {
        return self::where('date', '>=', now()->subDays(7)->format('Y-m-d'))
            ->distinct('ip')
            ->count('ip');
    }

    public static function getThisMonthVisitors()
    {
        return self::where('date', '>=', now()->subDays(30)->format('Y-m-d'))
            ->distinct('ip')
            ->count('ip');
    }
}