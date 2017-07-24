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

    public function fetchAll() {
        return Advertisement::all();
    }

    public function search(array $filters) {
        //TODO(Hudo): Update to FULL TEXT search
        $advertisements = Advertisement::where(function ($query) use ($filters) {
            if (isset($filters['q'])) {
               $q = $filters['q'];

               $query->where('title', 'like', "%$q%")
                     ->orWhere('description', 'like', "%$q%")
                     ->orWhere('tags', 'like', "%$q%");
            }
        })->get();

        return $advertisements;
    }

    public function findByUuid($uuid) {
        $advertisement = Advertisement::where('uuid', $uuid)->first();

        return $advertisement;
    }

    public function create(array $data) {
        $data['uuid'] = Uuid::uuid1();
        $advertisement = (new Advertisement())->fill($data);
        $advertisement->save();

        return $advertisement;
    }

    public function edit(Advertisement $advertisement, array $data) {
        $advertisement->fill($data)->save();

        return $advertisement;
    }

    public function delete($advertisement) {
        $advertisement->delete();
    }

}