<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFoundException;
use App\Helpers\JsonResponseHelper;
use App\Http\Requests\PictureCreateRequest;
use App\Services\AdvertisementService;
use App\Services\PictureService;
use App\Transformers\PictureTransformer;
use Illuminate\Http\Request;

class PicturesController extends Controller
{

    private $pictureService;
    private $advertisementService;

    public function __construct(PictureService $pictureService, AdvertisementService $advertisementService)
    {
        $this->pictureService = $pictureService;
        $this->advertisementService = $advertisementService;
    }

    public function create(PictureCreateRequest $request, $uuid) {
        try {
            $advertisement = $this->advertisementService->findByUuid($uuid);

            $picture = $this->pictureService->create($advertisement, $request->file('file'));

            return JsonResponseHelper::successResponse('Imagem criada com sucesso',
                fractal($picture, new PictureTransformer())->toArray());
        } catch (ModelNotFoundException $e) {
            return JsonResponseHelper::errorResponse($e->getMessage(), $e->getError(), $e->getCode());
        }
    }

}
