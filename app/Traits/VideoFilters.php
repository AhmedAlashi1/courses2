<?php

namespace App\Traits;

trait VideoFilters
{

    public function scopeCourse($q, $course)
    {
        return $q->where('courses_id', $course);
    }

    public function scopeKeyword($q, $word)
    {
        return $q->where(fn($q) => $q->where('title_en', 'like', "%{$word}%")->orWhere('title_ar', 'like', "%{$word}%"));
    }

    public function scopeFilter($q, $data)
    {


        if (isset($data['keyword'])) {
            $q->keyword($data['keyword']);
        }

        if (isset($data['courses_id'])) {
            $q->course($data['courses_id']);
        }
    }
}
