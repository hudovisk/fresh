<?php
/**
 * Created by PhpStorm.
 * User: hudoassenco
 * Date: 7/23/17
 * Time: 11:49 PM
 */

namespace App\Services;


use App\Repositories\AdvertisementRepository;

class AdvertisementService
{

    private $advertisementRepository;

    public function __construct(AdvertisementRepository $advertisementRepository)
    {
        $this->advertisementRepository = $advertisementRepository;
    }

    public function create(array $data) {
        $advertisement = $this->advertisementRepository->create($data);

        return $advertisement;
    }

}