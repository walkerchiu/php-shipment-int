<?php

namespace WalkerChiu\Shipment\Models\Constants;

/**
 * @license MIT
 * @package WalkerChiu\Shipment
 * 
 * 
 */

class ShipmentType
{
    /**
     * @return Array
     */
    public static function getCodes(): array
    {
        $items = [];
        $types = self::all();
        foreach ($types as $code => $type) {
            array_push($items, $code);
        }

        return $items;
    }

    /**
     * @param Bool  $onlyVaild
     * @return Array
     */
    public static function options($onlyVaild = false): array
    {
        $items = $onlyVaild ? [] : ['' => trans('php-core::system.null')];

        $types = self::all();
        foreach ($types as $key => $value) {
            $items = array_merge($items, [$key => trans('php-shipment::constants.shipment.'.$key)]);
        }

        return $items;
    }

    /**
     * @return Array
     */
    public static function all(): array
    {
        return [
            'direct_shipping'  => 'Direct Shipping',
            'drop_shipping'    => 'Drop Shipping',
            'e_can'            => 'Taiwan Pelican Express',
            'eflocker'         => 'EF Locker',
            'fedex'            => 'FedEx',
            'hct'              => 'HCT Logistics',
            'in_store_pickup'  => 'In-Store Pickup',
            'kerry_express'    => 'KERRY Express',
            'ktj'              => 'KERRY TJ',
            'morning_express'  => 'Morning Express',
            'pickup_in_person' => 'Pick up in Person',
            'post'             => 'Taiwan Post',
            'post_box'         => 'Taiwan Post iBox',
            'sf_express'       => 'SF Express',
            'sf_plus'          => 'SF Plus',
            'shipany'          => 'ShipAny',
            't_cat'            => 'T-CAT',
            'ups'              => 'UPS'
        ];
    }
}
