<?php

namespace WalkerChiu\Shipment\Models\Entities;

trait UserTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function shipments()
    {
        return $this->morphMany(config('wk-core.class.shipment.shipment'), 'morph');
    }
}
