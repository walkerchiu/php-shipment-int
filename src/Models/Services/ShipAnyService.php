<?php

namespace WalkerChiu\Shipment\Models\Services;

use Illuminate\Support\Facades\Log;
use ShipAnyCheckoutSdk\Core\ShipAnyHttpClient;
use ShipAnyCheckoutSdk\Core\SandboxEnvironment;
use ShipAnyCheckoutSdk\Orders\OrdersCreateRequest;
use ShipAnyCheckoutSdk\Orders\OrdersGetRequest;
use ShipAnyCheckoutSdk\Shipments\CapturesRefundRequest;

class ShipAnyService
{
    protected $client_id;
    protected $client_secret;
    protected $application_context;

    protected $environment;
    protected $client;



    /**
     * Create a new service instance.
     *
     * @param String  $client_id
     * @param String  $client_secret
     * @param Mixed   $application_context
     * @return void
     */
    public function __construct(string $client_id, string $client_secret, array $application_context)
    {
        $this->client_id           = $client_id;
        $this->client_secret       = $client_secret;
        $this->application_context = $application_context;

        $this->environment = new SandboxEnvironment($this->client_id, $this->client_secret);
        $this->client      = new ShipAnyHttpClient($this->environment);
    }

    /**
     * @param Array  $purchase_units
     * @param Bool   $debug
     * @return Mixed
     */
    public function order(array $purchase_units, $debug = false)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => $purchase_units,
            "application_context" => $this->application_context
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);
            
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            if ($debug) {
                print_r($response);
            } else {
                return $response;
            }
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    /**
     * This function can be used to retrieve an order by passing order Id as argument.
     * 
     * @param Mixed  $orderId
     * @param Bool   $debug
     * @return Mixed
     */
    public static function getOrder($orderId, $debug = false)
    {
        $client = ShipAnyClient::client();
        $response = $client->execute(new OrdersGetRequest($orderId));

        if ($debug) {
            /**
             * Enable below line to print complete response as JSON.
             */
            //print json_encode($response->result);
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Intent: {$response->result->intent}\n";
            print "Links:\n";
            foreach($response->result->links as $link)
            {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }

            print "Gross Amount: {$response->result->purchase_units[0]->amount->currency_code} {$response->result->purchase_units[0]->amount->value}\n";

            // To toggle printing the whole response body comment/uncomment below line
            echo json_encode($response->result, JSON_PRETTY_PRINT), "\n";
        }

        return $response;
    }

    /**
     * This function can be used to capture an order shipment by passing the approved
     * order id as argument.
     * 
     * @param Mixed  $orderId
     * @param Bool   $debug
     * @return Mixed
     */
    public static function captureOrder($orderId, $debug = false)
    {
        $request = new OrdersCaptureRequest($orderId);
        $client = ShipAnyClient::client();
        $response = $client->execute($request);

        if ($debug) {
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Links:\n";
            foreach($response->result->links as $link)
            {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            print "Capture Ids:\n";
            foreach($response->result->purchase_units as $purchase_unit)
            {
                foreach($purchase_unit->shipments->captures as $capture)
                {    
                    print "\t{$capture->id}";
                }
            }
            // To toggle printing the whole response body comment/uncomment below line
            echo json_encode($response->result, JSON_PRETTY_PRINT), "\n";
        }

        return $response;
    }

    /**
     * Function to create an refund capture request. Payload can be updated to issue partial refund.
     * 
     * @param Mixed   $captureId
     * @param Int     $amount
     * @param String  $currency
     * @param Bool    $debug
     * @return Mixed
     */
    public function refund($captureId, int $amount, string $currency, $debug = false)
    {
        $request = new CapturesRefundRequest($captureId);
        $request->body = [
            'amount' => [
                'value'         => $amount,
                'currency_code' => $currency
            ]
        ];
        $client = ShipAnyClient::client();
        $response = $client->execute($request);

        $debug = true;
        if ($debug) {
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Links:\n";
            foreach($response->result->links as $link)
            {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            // To toggle printing the whole response body comment/uncomment below line
            echo json_encode($response->result, JSON_PRETTY_PRINT), "\n";
        }

        return $response;
    }
}
