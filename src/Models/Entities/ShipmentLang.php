<?php

namespace WalkerChiu\Shipment\Models\Entities;

use WalkerChiu\Core\Models\Entities\Lang;

class ShipmentLang extends Lang
{
    /**
     * Create a new instance.
     *
     * @param Array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = config('wk-core.table.shipment.settings_lang');

        parent::__construct($attributes);
    }
}
