<?php

namespace App\Transformers;

use App\Models\Picture;
use League\Fractal\TransformerAbstract;

class PictureTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Picture $picture)
    {
        return [
            'url' => $picture->full_url
        ];
    }
}
