<?php

namespace App\Repositories\Eloquent;


use App\Models\Order;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\OrderRepositoryInterface;


class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }


}
