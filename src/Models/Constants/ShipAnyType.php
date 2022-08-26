<?php

namespace WalkerChiu\Shipment\Models\Constants;

/**
 * @license MIT
 * @package WalkerChiu\Shipment
 * 
 * 
 */

class ShipAnyType
{
    /**
     * @return Array
     */
    public static function getAddressType(): array
    {
        return [
            '1' => 'Residential',
            '2' => 'Business',
            '3' => 'Pickup',
            '4' => 'Accounting',
            '5' => 'Remote_Area',
            '6' => 'Convenience_Store',
            '7' => 'Locker',
            '8' => 'Store'
        ];
    }

    /**
     * https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3
     * 
     * @return Array
     */
    public static function getCountryType(): array
    {
        return [
            '1' => 'HKG',
            '2' => 'CHN'
        ];
    }

    /**
     * https://en.wikipedia.org/wiki/ISO_4217
     * 
     * @return Array
     */
    public static function getCurrencyUnit(): array
    {
        return [
            '1' => 'HKD',
            '2' => 'USD'
        ];
    }

    /**
     * @return Array
     */
    public static function getLangType(): array
    {
        return [
            '1' => 'CHT',
            '2' => 'CHS',
            '3' => 'ENG'
        ];
    }

    /**
     * @return Array
     */
    public static function getLengthUnit(): array
    {
        return [
            '1' => 'cm',
            '2' => 'm',
            '3' => 'mm',
            '4' => 'inch',
            '5' => 'ft',
            '6' => 'yd'
        ];
    }

    /**
     * @return Array
     */
    public static function getOnlineStoreType(): array
    {
        return [
            '1' => 'Opencart',
            '2' => 'Shopify',
            '3' => 'Shopline',
            '4' => 'Magento',
            '5' => 'MobileApp',
            '6' => 'WebApp',
            '7' => 'CloudERP',
            '8' => 'Others'
        ];
    }

    /**
     * @return Array
     */
    public static function getOnlineCourierType(): array
    {
        return [
            '3'  => 'SfExpress',
            '10' => 'UPS',
            '12' => 'MorningExpress',
            '13' => 'SfPlus',
            '15' => 'EfLocker'
        ];
    }

    /**
     * @return Array
     */
    public static function getOrderStatusType(): array
    {
        return [
            '1'  => 'Order_Drafted',
            '2'  => 'Order_Created',
            '3'  => 'Order_Processing',
            '4'  => 'Pickup_Request_Sent',
            '5'  => 'Preparing_For_Pickup',
            '6'  => 'Pickup_Request_Received',
            '7'  => 'Departure_Scan',
            '8'  => 'Ready_For_Shipment',
            '9'  => 'Shipping',
            '10' => 'In_Transit',
            '11' => 'Custom_Clearance_In_Progress',
            '12' => 'Ready_For_Delivery',
            '13' => 'Delivery_In_Progress',
            '14' => 'Order_Delivered',
            '15' => 'Order_Partially_Delivered',
            '16' => 'Order_Completed',
            '17' => 'Failed_To_Deliver_Pending_Retry',
            '18' => 'Failed_To_Deliver_Abandon_The_Goods',
            '19' => 'Failed_To_Deliver_Returning_To_Sender',
            '20' => 'Returning_In_Progress',
            '21' => 'Order_Returned',
            '22' => 'Delivery_Issue_Action_Required',
            '23' => 'Shipping_Issue_Action_Required',
            '24' => 'Order_Cancelled',
            '25' => 'Held_At_Yamato',
            '26' => 'Forwarded',
            '27' => 'Arrival',
            '28' => 'Failed_To_Deliver_Absence',
            '29' => 'Delivery_Appointment',
            '30' => 'Returned',
            '31' => 'Return_Completed',
            '32' => 'Failed_To_Deliver_Other',
            '33' => 'Ready_For_Pickup',
            '34' => 'Collected_By_Courier',
            '35' => 'Collected_By_Customer',
            '36' => 'Waiting_For_Quotation',
            '37' => 'More_Info_Required',
            '38' => 'Quotation_Provided',
            '39' => 'Quotation_Accepted',
            '40' => 'Quotation_Declined',
            '43' => 'Shipment_Under_Processing',
            '44' => 'Failed_To_Deliver',
            '45' => 'Delivery_In_Progress_Retry',
            '46' => 'Pickup_Req_Rcvd_But_Status_Unavail',
            '47' => 'Delivered_To_Locker',
            '48' => 'Delivered_To_Conv_Store',
            '49' => 'Collected_By_Courier_Overdue',
            '50' => 'Collected_By_Admin_Overdue',
            '51' => 'Returning_From_Conv_Store',
            '52' => 'Abnormal',
            '53' => 'Delivery_Address_Updated',
            '54' => 'Shipment_On_Hold',
            '55' => 'Return_Cancelled_Scheduling_Next_Delivery'
        ];
    }

    /**
     * @return Array
     */
    public static function getPhoneType(): array
    {
        return [
            '1' => 'Home',
            '2' => 'Work',
            '3' => 'Mobile',
            '4' => 'Fax'
        ];
    }

    /**
     * @return Array
     */
    public static function getSalesType(): array
    {
        return [
            '1'  => 'Electronic',
            '2'  => 'Garment',
            '3'  => 'Cosmetic',
            '4'  => 'Food_Drinks',
            '5'  => 'Food_Drinks_Frozen',
            '6'  => 'Food_Drinks_Chilled',
            '7'  => 'Food_Drinks_Hot',
            '8'  => 'Food_Drinks_Warm',
            '9'  => 'Furniture',
            '10' => 'Stationery',
            '11' => 'Medicine',
            '12' => 'Others'
        ];
    }

    /**
     * @return Array
     */
    public static function getServicesType(): array
    {
        return [
            '1'  => 'Letter',
            '2'  => 'Document',
            '3'  => 'Parcel',
            '4'  => 'Overweight_Parcel',
            '5'  => 'Oversized_Parcel',
            '6'  => 'Frozen',
            '7'  => 'Chilled',
            '8'  => 'Hot',
            '9'  => 'Warm',
            '10' => 'Fragile',
            '11' => 'Luxury',
            '12' => 'International'
        ];
    }

    /**
     * @return Array
     */
    public static function getStorageType(): array
    {
        return [
            '1' => 'Normal',
            '2' => 'Chilled',
            '3' => 'Frozen',
            '4' => 'Warm',
            '5' => 'Hot',
            '6' => 'Document',
            '7' => 'Wine'
        ];
    }

    /**
     * @return Array
     */
    public static function getWeightUnit(): array
    {
        return [
            '1' => 'kg',
            '2' => 'g',
            '3' => 'lb',
            '4' => 'oz'
        ];
    }

    /**
     * @return Array
     */
    public static function getServiceLocationType(): array
    {
        return [
            'Locker'            => 'Locker',
            'Convenience_Store' => 'Convenience Store',
            'Store'             => 'Store'
        ];
    }

    /**
     * @return Array
     */
    public static function getDistrictType(): array
    {
        return [
            'Central_and_Western_District' => 'Central and Western District',
            'Cheung_Chau_District'         => 'Cheung Chau District',
            'Eastern_District'             => 'Eastern District',
            'Kowloon_City_District'        => 'Kowloon City District',
            'Kwai_Tsing_District'          => 'Kwai Tsing District',
            'Kwun_Tong_District'           => 'Kwun Tong District',
            'Lamma_Island_District'        => 'Lamma Island District',
            'Lantau_District'              => 'Lantau District',
            'North_District'               => 'North District',
            'Peng_Chau_District'           => 'Peng Chau District',
            'Sai_Kung_District'            => 'Sai Kung District',
            'Sha_Tin_District'             => 'Sha Tin District',
            'Sham_Shui_Po_District'        => 'Sham Shui Po District',
            'Southern_District'            => 'Southern District',
            'Tai_Po_District'              => 'Tai Po District',
            'Tsuen_Wan_District'           => 'Tsuen Wan District',
            'Tuen_Mun_District'            => 'Tuen Mun District',
            'Wan_Chai_District'            => 'Wan Chai District',
            'Wong_Tai_Sin_District'        => 'Wong Tai Sin District',
            'Yau_Tsim_Mong_District'       => 'Yau Tsim Mong District',
            'Yuen_Long_District'           => 'Yuen Long District'
        ];
    }
}
