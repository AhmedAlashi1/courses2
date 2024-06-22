<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
        protected $fillable = [
        'key_id',
        'title_en',
        'title_ar',
        'value',
        'set_group',
        'is_object',
        ];
        public $timestamps = false;

}
