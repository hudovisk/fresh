<?php
/**
 * Created by PhpStorm.
 * User: hudoassenco
 * Date: 7/23/17
 * Time: 11:49 PM
 */

namespace App\Services;


use App\Exceptions\ModelNotFoundException;
use App\Models\Advertisement;
use App\Repositories\AdvertisementRepository;
use Carbon\Carbon;

class AdvertisementService
{

    private $advertisementRepository;

    public function __construct(AdvertisementRepository $advertisementRepository)
    {
        $this->advertisementRepository = $advertisementRepository;
    }

    public function fetchAll() {
        return $this->advertisementRepository->fetchAll();
    }

    public function search(array $filters) {
        return $this->advertisementRepository->search($filters);
    }

    public function findByUuid($uuid) {
        $advertisement = $this->advertisementRepository->findByUuid($uuid);

        if(!$advertisement) throw new ModelNotFoundException('Anúncio não encontrado');

        return $advertisement;
    }

    public function create(array $data) {
        $advertisement = $this->advertisementRepository->create($data);

        return $advertisement;
    }

    public function edit(Advertisement $advertisement, array $data) {
        $advertisement = $this->advertisementRepository->edit($advertisement, $data);

        return $advertisement;
    }

    public function delete(Advertisement $advertisement) {
        $this->advertisementRepository->delete($advertisement);
    }

    public function togglePublished(Advertisement $advertisement) {
        $advertisement->published_at = $advertisement->published_at ? null : Carbon::now();
        $advertisement = $this->advertisementRepository->edit($advertisement, []);

        return $advertisement;
    }
}