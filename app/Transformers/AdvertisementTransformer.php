<?php

namespace App\Transformers;

use App\Models\Advertisement;
use League\Fractal\TransformerAbstract;

class AdvertisementTransformer extends TransformerAbstract
{
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
            'cover' => null, //TODO(Hudo): Add cover after finished with images
            'price' => $advertisement->price,
            'published' => $advertisement->published_at ? $advertisement->published_at->toDateTimeString() : null,
            'description' => $advertisement->description,
        ];
    }
}
