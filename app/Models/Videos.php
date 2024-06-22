<?php

namespace App\Models;

use App\Traits\VideoFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;
    use VideoFilters;

    protected $table = 'videos';

    protected $fillable = [ 'courses_id','section_id','title_ar', 'title_en','description_ar', 'description_en',
        'image', 'path','type','size','duration','status'];

    const PAGINATE_NUMBER = 40;
    protected $appends = ['watching'];


    public function courses()
    {
        return $this->belongsTo(Courses::class);
    }
    public function section()
    {
        return $this->belongsTo(Sections::class);
    }
    public function watching_user()
    {
        return $this->hasMany(WatchingVideoUser::class, 'video_id', 'id');
    }
    public function getWatchingAttribute()
    {
        $userId = auth('api')->user()->id ?? null;
        $watching = $this->watching_user->where('user_id', $userId)->where('video_id',$this->id)->first();
        return $watching ? true : false;

    }


}
