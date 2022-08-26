<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use Carbon\Carbon;
use File;
use Auth;

class PageModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="pages";


    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function PageContentModel()
    {
        return $this->hasMany('App\Models\PageContentModel', 'page_id');
    }

}
