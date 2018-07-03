<?php

namespace Dhcd\News\App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTag extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_news_tag';

    protected $primaryKey = 'news_tag_id';

    protected $guarded = ['tag_id'];
    protected $fillable = ['name'];
}
