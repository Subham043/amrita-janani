<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use Carbon\Carbon;
use Auth;
use App\Models\VideoAccess;
use App\Models\VideoFavourite;
use App\Models\LanguageModel;

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

    public function getAdminName(){
        if(!empty($this->User) && $this->User->count()>0){
            return $this->User->name;
        }
        return "";
    }

    public function Languages()
    {
        return $this->belongsToMany(LanguageModel::class, 'video_languages', 'video_id', 'language_id');
    }

    public function GetLanguagesId(){
        return $this->Languages()->pluck('languages.id')->toArray();
    }

    public function GetLanguagesName(){
        return $this->Languages()->pluck('languages.name');
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

    public function contentVisible(){
        try {
            $videoAccess = VideoAccess::where('video_id', $this->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $videoAccess = null;
        }

        if($this->restricted==0 || Auth::user()->userType!=2){
            return true;
        }else{
            if(empty($videoAccess) || $videoAccess->status==0){
                return false;
            }else{
                return true;
            }
        }
    }

    public function markedFavorite(){
        try {
            $videoFav = VideoFavourite::where('video_id', $this->id)->where('user_id', Auth::user()->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            $videoFav = null;
        }
        if(!empty($videoFav)){
            if($videoFav->status == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    public function getTagsArray() {
        if($this->tags){
            $arr = explode(",",$this->tags);
            return $arr;
        }
        return array();
    }

    public function getVideoId(){
        if(strpos($this->video,'vimeo') !== false){
            if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/?(showcase\/)*([0-9))([a-z]*\/)*([0-9]{6,11})[?]?.*/", $this->video, $output_array)) {
                return $output_array[6];
            }
        }else{
            $video_id = explode("/embed/", $this->video);
            $video_id = $video_id[1];
            return $video_id;
        }
    }
}
