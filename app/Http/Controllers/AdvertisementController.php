<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponseHelper;
use App\Http\Requests\AdvertisementCreateRequest;
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

}
