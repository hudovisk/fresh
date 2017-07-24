<?php

namespace App\Services;


use App\Exceptions\ModelNotFoundException;
use App\Models\Advertisement;
use App\Models\Picture;
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
        //TODO(Hudo): resize images
        $data['advertisement_id'] = $advertisement->id;
        $data['path'] = Storage::putFile($advertisement->getPicturesFolder(), $file);

        $picture = $this->picturesRepository->create($data);

        return $picture;
    }

    public function findByFileName(Advertisement $advertisement, $fileName) {
        $path = $advertisement->getPicturesFolder() . $fileName;

        $picture = $this->picturesRepository->findByPath($path);

        if(!$picture || $picture->advertisement_id != $advertisement->id) throw new ModelNotFoundException();

        return $picture;
    }

    public function delete(Picture $picture) {
        Storage::delete($picture->path);

        $this->picturesRepository->delete($picture);
    }

}