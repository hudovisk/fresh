<?php

namespace App\Transformers;

use App\Models\Advertisement;
use App\Models\Picture;
use League\Fractal\TransformerAbstract;

class AdvertisementTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'pictures', 'cover'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Advertisement $advertisement)
    {
        return [
            'uuid' => $advertisement->uuid,
            'tags' => $advertisement->tags,
            'title' => $advertisement->title,
            'price' => $advertisement->price,
            'published' => $advertisement->published_at ? $advertisement->published_at->toDateTimeString() : null,
            'description' => $advertisement->description,
        ];
    }

    public function includePictures(Advertisement $advertisement)
    {
        $pictures = $advertisement->pictures;

        return $this->collection($pictures, new PictureTransformer());
    }

    public function includeCover(Advertisement $advertisement)
    {
        $cover = $advertisement->cover ?: new Picture();

        return $this->item($cover, new PictureTransformer());
    }

}
