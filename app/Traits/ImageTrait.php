<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImageTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */

    public function getImageAttribute($value){
        if ($value) {
            return getimg($value);
        } elseif(filter_var($value, FILTER_VALIDATE_URL)){
            return  $value;
        } else
            return  asset('storage/images/default.jpg');
    }

    public function setImageAttribute($value,$directory = 'images'){
        if (is_file($value))
            $this->attributes['image'] = uploader($value,$directory);
        else
            $this->attributes['image'] = $value;
    }

    public function uploadImage($folder,$image){
        $image->store('/',$folder);
        $filename = $image->hashName();
        $path = 'images/' . $filename;
        return $path;
    }

}
