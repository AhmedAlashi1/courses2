<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyCourseUser extends Model
{
    use HasFactory;
    protected $table = 'buy_course_user';

    protected $fillable = [ 'course_id' , 'user_id','status'];

    public function courses()
    {
        return $this->belongsTo(Courses::class,'course_id','id');
    }
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
