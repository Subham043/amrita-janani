<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoFavourite extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "video_favourites";

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function VideoModel()
    {
        return $this->belongsTo('App\Models\VideoModel', 'video_id');
    }
}
