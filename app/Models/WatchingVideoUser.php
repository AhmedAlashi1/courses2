<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchingVideoUser extends Model
{
    use HasFactory;
    protected $table = 'watching_video_user';

    protected $fillable = [ 'video_id' , 'user_id'];

    public function videos()
    {
        return $this->belongsTo(Videos::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
