<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;
    protected $table = 'sections';

    protected $fillable = [ 'courses_id','title_ar', 'title_en', 'status','is_paid'];

    public function courses()
    {
        return $this->belongsTo(Courses::class);
    }
    public function videos()
    {
        return $this->hasMany(Videos::class, 'section_id', 'id');
    }
}
