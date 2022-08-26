<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use Carbon\Carbon;
use File;
use Auth;

class PageContentModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="page_contents";


    public function PageModel()
    {
        return $this->belongsTo('App\Models\PageModel', 'page_id');
    }

}
