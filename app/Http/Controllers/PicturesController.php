<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFoundException;
use App\Helpers\JsonResponseHelper;
use App\Http\Requests\PictureCreateRequest;
use App\Services\AdvertisementService;
use App\Services\PictureService;
use App\Transformers\PictureTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            return DB::transaction(function () use ($request, $advertisement) {
                $picture = $this->pictureService->create($advertisement, $request->file('file'));

                return JsonResponseHelper::successResponse('Imagem criada com sucesso',
                    fractal($picture, new PictureTransformer())->toArray(), 201);
            });
        } catch (ModelNotFoundException $e) {
            return JsonResponseHelper::errorResponse($e->getMessage(), $e->getError(), $e->getCode());
        }
    }

    public function delete(Request $request, $uuid, $fileName) {
        try {
            $advertisement = $this->advertisementService->findByUuid($uuid);

            return DB::transaction(function () use ($advertisement, $fileName) {
                $picture = $this->pictureService->findByFileName($advertisement, $fileName);

                $this->pictureService->delete($picture);

                return JsonResponseHelper::successResponse('Imagem deletada com sucesso',
                    false, 200);
            });
        } catch (ModelNotFoundException $e) {
            return JsonResponseHelper::errorResponse($e->getMessage(), $e->getError(), $e->getCode());
        }
    }

}
