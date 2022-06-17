<?php

namespace App\Models\FantasyData;

use App\Traits\UserTimezoneAware;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use UserTimezoneAware;
    use SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'news_id',
        'source',
        'updated',
        'time_ago',
        'title',
        'content',
        'url',
        'terms_of_use',
        'author',
        'categories',
        'player_id',
        'team_id',
        'team',
        'player_id2',
        'team_id2',
        'team2',
    ];

    protected $casts = [
        'news_id' => 'integer',
        'source' => 'string',
        'updated' => 'string',
        'time_ago' => 'string',
        'title' => 'string',
        'content' => 'string',
        'url' => 'string',
        'terms_of_use' => 'string',
        'author' => 'string',
        'categories' => 'string',
        'player_id' => 'integer',
        'team_id' => 'integer',
        'team' => 'string',
        'player_id2' => 'integer',
        'team_id2' => 'integer',
        'team2' => 'string',
    ];

    protected $appends = [

        'formated_updated',

    ];

    /*public function getUpdatedAttribute( $value ) {

      return   date('F d D, Y  h:i:A T',strtotime($value));

    }
    */
    public function getFormatedUpdatedAttribute()
    {
        $createdAt = Carbon::parse($this->getDateToUserTimezone($this->attributes['updated']));

        return $createdAt = $createdAt->format('M d Y h:i:A');
        // return   date('F d D, Y  h:i:A T',strtotime($this->getDateToUserTimezone($this->attributes['updated'])));
    }
}
