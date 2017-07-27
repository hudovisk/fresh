<?php
/**
 * Created by PhpStorm.
 * User: hudoassenco
 * Date: 7/23/17
 * Time: 11:57 PM
 */

namespace App\Repositories;


use App\Models\Advertisement;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class AdvertisementRepository
{

    public function fetchAll() {
        return Advertisement::all();
    }

    public function search(array $filters) {
        $query = Advertisement::query();

        if(isset($filters['q']) && $filters['q']) {
            $query = $query->selectRaw("*, MATCH (title,description,tags) AGAINST (?) as score", [$filters['q']])
                ->whereRaw("MATCH (title,description,tags) AGAINST (? IN BOOLEAN MODE)", [$filters['q']])
                ->orderBy('score', 'desc');
        }

        return $query->get();
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