<?php

namespace App\Repositories;


use App\Models\Advertisement;
use App\Models\Picture;

class PictureRepository
{

    public function create($data) {
        $picture = (new Picture())->fill($data);
        $picture->save();

        return $picture;
    }

}