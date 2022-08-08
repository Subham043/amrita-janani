<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageAccess extends Model
{
    use HasFactory;

    protected $table = "image_access";

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function Admin()
    {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }
    
    public function ImageModel()
    {
        return $this->belongsTo('App\Models\ImageModel', 'image_id');
    }
}
