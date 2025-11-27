<?php

namespace App\Modules\Publication\Repositories\Implementations;

use Illuminate\Support\Facades\DB;
use App\Modules\Publication\Models\Dealers;
use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Repositories\Interfaces\DealersRepositoryInterface;

class DealersRepository extends BaseRepository implements DealersRepositoryInterface
{
    public function __construct(Dealers $model)
    {
        parent::__construct($model);
    }

    public function dealerHasUser($id)
    {
       return DB::table('users')->where('dealer_id', $id)->exists();
    }

    public function getUserByDealerId($id)
    {
        return DB::table('users')->where('dealer_id', $id)->value('id');
    }
}
