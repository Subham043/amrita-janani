<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use Carbon\Carbon;
use File;
use Auth;

class FAQModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="faqs";


    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

}
