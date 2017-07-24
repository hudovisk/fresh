<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFoundException;
use App\Helpers\JsonResponseHelper;
use App\Http\Requests\AdvertisementCreateRequest;
use App\Models\Advertisement;
use App\Services\AdvertisementService;
use App\Transformers\AdvertisementTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvertisementController extends Controller
{

    private $advertisementService;

    public function __construct(AdvertisementService $advertisementService)
    {
        $this->advertisementService = $advertisementService;
    }

    public function create(AdvertisementCreateRequest $request) {
        return DB::transaction(function () use ($request) {
            $data = $request->all();

            $advertisement = $this->advertisementService->create($data);

            return JsonResponseHelper::successResponse('Anúncio criado com sucesso',
                fractal($advertisement, new AdvertisementTransformer())->toArray(), 201);
        });
    }

    public function edit(AdvertisementCreateRequest $request, $uuid) {
        try {
            $advertisement = $this->advertisementService->findByUuid($uuid);

            return DB::transaction(function () use ($request, $advertisement) {
                $data = $request->all();

                $advertisement = $this->advertisementService->edit($advertisement, $data);

                return JsonResponseHelper::successResponse('Anúncio editado com sucesso',
                    fractal($advertisement, new AdvertisementTransformer())->toArray(), 200);
            });
        } catch (ModelNotFoundException $e) {
            return JsonResponseHelper::errorResponse($e->getMessage(), $e->getError(), $e->getCode());
        }
    }

}
