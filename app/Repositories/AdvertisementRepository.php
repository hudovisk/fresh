<?php
/**
 * Created by PhpStorm.
 * User: hudoassenco
 * Date: 7/23/17
 * Time: 11:57 PM
 */

namespace App\Repositories;


use App\Models\Advertisement;
use Ramsey\Uuid\Uuid;

class AdvertisementRepository
{

    public function create(array $data) {
        $data['uuid'] = Uuid::uuid1();
        $advertisement = (new Advertisement())->fill($data);
        $advertisement->save();

        return $advertisement;
    }

}