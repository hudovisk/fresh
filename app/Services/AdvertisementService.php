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

    public function delete($advertisement) {
        $this->advertisementRepository->delete($advertisement);
    }
}