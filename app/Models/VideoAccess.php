<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoAccess extends Model
{
    use HasFactory;

    protected $table = "video_access";

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function Admin()
    {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }
    
    public function VideoModel()
    {
        return $this->belongsTo('App\Models\VideoModel', 'video_id');
    }
}
