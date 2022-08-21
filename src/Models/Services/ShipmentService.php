<?php

namespace WalkerChiu\Shipment\Models\Services;

use Illuminate\Support\Facades\App;
use WalkerChiu\Core\Models\Services\CheckExistTrait;

class ShipmentService
{
    use CheckExistTrait;

    protected $repository;

    public function __construct()
    {
        $this->repository = App::make(config('wk-core.class.shipment.shipmentRepository'));
    }

    /**
     * @param String  $code
     * @param Array   $data
     * @return Array
     */
    public function listForOrder(string $code, array $data)
    {
        return $this->repository->listForOrder($code, $data);
    }
}
