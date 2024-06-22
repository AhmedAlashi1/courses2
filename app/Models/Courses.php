<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;
    protected $table = 'courses';

    protected $fillable = [ 'title_ar', 'title_en','description_ar', 'description_en', 'image', 'status','is_paid'];

    protected $appends = ['is_paid_user'];


    public function videos()
    {
        return $this->hasMany(Videos::class, 'courses_id', 'id');
    }
    public function section()
    {
        return $this->hasMany(Sections::class, 'courses_id', 'id');
    }
    public function BuyCourse(){
        return $this->hasMany(BuyCourseUser::class,'course_id', 'id');
    }
    public function getIsPaidUserAttribute()
    {
        $userId = auth('api')->user()->id ?? null;
        $buyCourse = $this->BuyCourse->where('user_id', $userId)->where('course_id',$this->id)->first();
        return $buyCourse ? true : false;

    }



}
