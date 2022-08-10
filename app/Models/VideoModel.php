<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use Carbon\Carbon;

class VideoModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="videos";

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function LanguageModel()
    {
        return $this->belongsTo('App\Models\LanguageModel', 'language_id');
    }

    public function VideoFavourite()
    {
        return $this->hasMany('App\Models\VideoFavourite', 'video_id');
    }
    
    public function VideoAccess()
    {
        return $this->hasMany('App\Models\VideoAccess', 'video_id');
    }
    
    public function VideoReport()
    {
        return $this->hasMany('App\Models\VideoReport', 'video_id');
    }

    public function time_elapsed(){

        $dt = Carbon::parse($this->created_at);
        return $dt->diffForHumans();

    }
}
