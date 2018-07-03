<?php

namespace Dhcd\News\App\Models;

use Illuminate\Database\Eloquent\Model;
use Dhcd\News\App\Models\NewsCat;
class News extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_news';

    protected $primaryKey = 'news_id';
    protected static $cat;
    protected $guarded = ['news_id'];

    public static function getListNews($params) {
        $q = self::orderBy('news_id', 'desc');
        if (!empty($params['name']) && $params['name'] != null) {
            $q->where('title', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['news_time']) && $params['news_time'] != null) {
            $fromDate = date($params['news_time'] . ' 00:00:00', time());
            $toDate = date($params['news_time'] . ' 23:59:59', time());
            $q->whereBetween('created_at', array($fromDate, $toDate));
        }
        if (!empty($params['is_hot']) && $params['is_hot'] != null) {
            $q->where('is_hot', $params['is_hot']);
        }
        if (!empty($params['news_cat']) && $params['news_cat'] != null) {
            $q->with('getCats')
            ->whereHas('getCats', function ($query) use ($params) {
                $query->where('dhcd_news_cat.news_cat_id', $params['news_cat']);
            });
        }
        $data = $q->get(); 
        return $data;
    }
    public function getCats() {
        return $this->belongsToMany('Dhcd\News\App\Models\NewsCat', 'dhcd_news_has_cat', 'news_id', 'news_cat_id');
    }
}
