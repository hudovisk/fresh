<?php

namespace App\Services;


use App\Models\Advertisement;
use App\Repositories\PictureRepository;
use Illuminate\Support\Facades\Storage;

class PictureService
{

    private $picturesRepository;

    public function __construct(PictureRepository $picturesRepository)
    {
        $this->picturesRepository = $picturesRepository;
    }

    public function create(Advertisement $advertisement, $file) {
        $data['advertisement_id'] = $advertisement->id;
        $data['path'] = Storage::putFile($advertisement->getPicturesFolder(), $file);

        $picture = $this->picturesRepository->create($data);

        return $picture;
    }

}