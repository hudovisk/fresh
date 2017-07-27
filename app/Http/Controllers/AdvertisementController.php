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

    public function index(Request $request) {
        $advertisements = $this->advertisementService->fetchAll(['pictures']);

        return JsonResponseHelper::successResponse('Anúncios encontrados com sucesso',
            fractal($advertisements, new AdvertisementTransformer())
                ->parseIncludes('cover')
                ->toArray());
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
                    fractal($advertisement, new AdvertisementTransformer())->toArray());
            });
        } catch (ModelNotFoundException $e) {
            return JsonResponseHelper::errorResponse($e->getMessage(), $e->getError(), $e->getCode());
        }
    }

    public function show(Request $request, $uuid) {
        try {
            $advertisement = $this->advertisementService->findByUuid($uuid);

            return JsonResponseHelper::successResponse('Anúncio encontrado com sucesso',
                fractal($advertisement, new AdvertisementTransformer())
                    ->parseIncludes(['cover', 'pictures'])
                    ->toArray());
        } catch (ModelNotFoundException $e) {
            return JsonResponseHelper::errorResponse($e->getMessage(), $e->getError(), $e->getCode());
        }
    }

    public function delete(Request $request, $uuid) {
        try {
            $advertisement = $this->advertisementService->findByUuid($uuid);

            $this->advertisementService->delete($advertisement);

            return JsonResponseHelper::successResponse('Anúncio deletado com sucesso');
        } catch (ModelNotFoundException $e) {
            return JsonResponseHelper::errorResponse($e->getMessage(), $e->getError(), $e->getCode());
        }
    }

    public function togglePublished(Request $request, $uuid) {
        try {
            $advertisement = $this->advertisementService->findByUuid($uuid);

            return DB::transaction(function () use ($advertisement) {

                $advertisement = $this->advertisementService->togglePublished($advertisement);

                return JsonResponseHelper::successResponse('Anúncio editado com sucesso',
                    fractal($advertisement, new AdvertisementTransformer())->toArray());
            });
        } catch (ModelNotFoundException $e) {
            return JsonResponseHelper::errorResponse($e->getMessage(), $e->getError(), $e->getCode());
        }
    }

    public function search(Request $request) {
        $filters = $request->only('q');
        $advertisements = $this->advertisementService->search($filters, ['pictures']);

        return JsonResponseHelper::successResponse('Anúncios encontrados com sucesso',
            fractal($advertisements, new AdvertisementTransformer())
                ->parseIncludes('cover')
                ->toArray());
    }

}
