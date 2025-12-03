<?php
// app/Models/NewsViewModel.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsViewModel extends Model
{
    protected $table = 'news_view';
    protected $fillable = ['news_id', 'session_id'];
    public $timestamps = false;

    // METHOD TRACKER
    public static function track($newsId)
    {
        if (!self::hasViewed($newsId)) {
            self::create([
                'news_id' => $newsId,
                'session_id' => session()->getId()
            ]);
            session()->put("news_viewed_{$newsId}", true);
        }
    }

    public static function hasViewed($newsId)
    {
        return session()->has("news_viewed_{$newsId}") || 
               self::where(['news_id' => $newsId, 'session_id' => session()->getId()])->exists();
    }

    public function news()
    {
        return $this->belongsTo(NewsModel::class, 'news_id');
    }
}