<?php

namespace WalkerChiu\Shipment\Models\Repositories;

use Illuminate\Support\Facades\App;
use WalkerChiu\Core\Models\Forms\FormTrait;
use WalkerChiu\Core\Models\Repositories\Repository;
use WalkerChiu\Core\Models\Repositories\RepositoryTrait;
use WalkerChiu\Core\Models\Services\PackagingFactory;

class shipanyRepository extends Repository
{
    use FormTrait;
    use RepositoryTrait;

    protected $instance;



    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->instance = App::make(config('wk-core.class.shipment.shipany'));
    }

    /**
     * @param String  $code
     * @param Array   $data
     * @param Bool    $is_enabled
     * @param Bool    $auto_packing
     * @return Array|Collection|Eloquent
     */
    public function list(string $code, array $data, $is_enabled = null, $auto_packing = false)
    {
        $instance = $this->instance;
        if ($is_enabled === true)      $instance = $instance->ofEnabled();
        elseif ($is_enabled === false) $instance = $instance->ofDisabled();

        $data = array_map('trim', $data);
        $repository = $instance->with(['langs' => function ($query) use ($code) {
                                    $query->ofCurrent()
                                          ->ofCode($code);
                                }])
                                ->whereHas('langs', function ($query) use ($code) {
                                    return $query->ofCurrent()
                                                 ->ofCode($code);
                                })
                                ->when($data, function ($query, $data) {
                                    return $query->unless(empty($data['id']), function ($query) use ($data) {
                                                return $query->where('id', $data['id']);
                                            })
                                            ->unless(empty($data['username']), function ($query) use ($data) {
                                                return $query->where('username', $data['username']);
                                            })
                                            ->unless(empty($data['client_id']), function ($query) use ($data) {
                                                return $query->where('client_id', $data['client_id']);
                                            })
                                            ->unless(empty($data['currency']), function ($query) use ($data) {
                                                return $query->where('currency', $data['currency']);
                                            })
                                            ->unless(empty($data['locale']), function ($query) use ($data) {
                                                return $query->where('locale', $data['locale']);
                                            })
                                            ->unless(empty($data['intent']), function ($query) use ($data) {
                                                return $query->where('intent', $data['intent']);
                                            });
                                })
                                ->orderBy('order', 'ASC');

        if ($auto_packing) {
            $factory = new PackagingFactory(config('wk-shipment.output_format'), config('wk-shipment.pagination.pageName'), config('wk-shipment.pagination.perPage'));
            return $factory->output($repository);
        }

        return $repository;
    }

    /**
     * @param ShipAny       $instance
     * @param Array|String  $code
     * @return Array
     */
    public function show($instance, $code): array
    {
    }
}
