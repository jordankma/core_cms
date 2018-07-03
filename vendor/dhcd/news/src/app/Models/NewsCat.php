<?php

namespace Dhcd\News\App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_news_cat';

    protected $primaryKey = 'news_cat_id';

    protected $guarded = ['news_cat_id'];
}
