<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Support\Facades\DB;

class Tweet extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'text'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function getUserTimeLine(Int $id)
    {
        return $this->orderBy('created_at', 'DESC')->paginate(50);
    }
    public function getTimeLine(Int $user_id)
    {
        $items = DB::select("select tweet_id from favorites where user_id = '$user_id'");;
        $id_list = array();
        foreach ($items as $id) {
            array_push($id_list,$id->tweet_id);
        }
        return $this->whereIn('id', $id_list)->orderBy('created_at', 'DESC')->paginate(50);
    }
    public function getTweetCount(Int $user_id)
    {
        return $this->where('user_id', $user_id)->count();
    }
    public function tweetStore(Int $user_id, Array $data)
    {
        $this->user_id = $user_id;
        $this->text = $data['text'];
        $this->save();

        return;
    }
    public function getTweet(Int $tweet_id)
    {
        return $this->with('user')->where('id', $tweet_id)->first();
    }
    public function tweetDestroy(Int $user_id, Int $tweet_id)
    {
        return $this->where('user_id', $user_id)->where('id', $tweet_id)->delete();
    }
    public function test(Int $user_id){
        return DB::select('select tweet_id from favorites where user_id = "$user_id"');
    }
}
