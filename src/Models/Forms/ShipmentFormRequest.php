<?php

namespace WalkerChiu\Shipment\Models\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use WalkerChiu\Core\Models\Forms\FormRequest;

class ShipmentFormRequest extends FormRequest
{
    /**
     * @Override Illuminate\Foundation\Http\FormRequest::getValidatorInstance
     */
    protected function getValidatorInstance()
    {
        $request = Request::instance();
        $data = $this->all();
        if (
            $request->isMethod('put')
            && empty($data['id'])
            && isset($request->id)
        ) {
            $data['id'] = (int) $request->id;
            $this->getInputSource()->replace($data);
        }

        return parent::getValidatorInstance();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return Array
     */
    public function attributes()
    {
        $attributes = [
            'host_type'   => trans('php-shipment::system.host_type'),
            'host_id'     => trans('php-shipment::system.host_id'),
            'serial'      => trans('php-shipment::system.serial'),
            'type'        => trans('php-shipment::system.type'),
            'order'       => trans('php-shipment::system.order'),
            'options'     => trans('php-shipment::system.options'),
            'is_enabled'  => trans('php-shipment::system.is_enabled'),

            'name'        => trans('php-shipment::shipment.name'),
            'description' => trans('php-shipment::shipment.description'),
            'note'        => trans('php-shipment::shipment.note'),
            'remarks'     => trans('php-shipment::shipment.remarks')
        ];

        return $attributes;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return Array
     */
    public function rules()
    {
        $rules = [
            'host_type'   => 'required_with:host_id|string',
            'host_id'     => 'required_with:host_type|integer|min:1',
            'serial'      => '',
            'type'        => '',
            'order'       => 'nullable|numeric|min:0',
            'options'     => 'nullable|json',
            'is_enabled'  => 'required|boolean',

            'name'        => 'required|string|max:255',
            'description' => '',
            'note'        => '',
            'remarks'     => ''
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return Array
     */
    public function messages()
    {
        $messages = [
            'id.required'              => trans('php-core::validation.required'),
            'id.integer'               => trans('php-core::validation.integer'),
            'id.min'                   => trans('php-core::validation.min'),
            'id.exists'                => trans('php-core::validation.exists'),
            'host_type.required_with'  => trans('php-core::validation.required_with'),
            'host_type.string'         => trans('php-core::validation.string'),
            'host_id.required_with'    => trans('php-core::validation.required_with'),
            'host_id.integer'          => trans('php-core::validation.integer'),
            'host_id.min'              => trans('php-core::validation.min'),
            'order.numeric'            => trans('php-core::validation.numeric'),
            'order.min'                => trans('php-core::validation.min'),
            'options.json'             => trans('php-core::validation.json'),
            'is_enabled.required'      => trans('php-core::validation.required'),
            'is_enabled.boolean'       => trans('php-core::validation.boolean'),

            'name.required'            => trans('php-core::validation.required'),
            'name.string'              => trans('php-core::validation.string'),
            'name.max'                 => trans('php-core::validation.max')
        ];

        return $messages;
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after( function ($validator) {
            $data = $validator->getData();
            if (
                isset($data['host_type'])
                && isset($data['host_id'])
            ) {
                if (
                    config('wk-shipment.onoff.site')
                    && !empty(config('wk-core.class.site.site'))
                    && $data['host_type'] == config('wk-core.class.site.site')
                ) {
                    $result = DB::table(config('wk-core.table.site.sites'))
                                ->where('id', $data['host_id'])
                                ->exists();
                    if (!$result)
                        $validator->errors()->add('host_id', trans('php-core::validation.exists'));
                } elseif (
                    config('wk-shipment.onoff.group')
                    && !empty(config('wk-core.class.group.group'))
                    && $data['host_type'] == config('wk-core.class.group.group')
                ) {
                    $result = DB::table(config('wk-core.table.group.groups'))
                                ->where('id', $data['host_id'])
                                ->exists();
                    if (!$result)
                        $validator->errors()->add('host_id', trans('php-core::validation.exists'));
                } elseif (
                    config('wk-shipment.onoff.account')
                    && !empty(config('wk-core.class.account.profile'))
                    && $data['host_type'] == config('wk-core.class.account.profile')
                ) {
                    $result = DB::table(config('wk-core.table.account.profiles'))
                                ->where('id', $data['host_id'])
                                ->exists();
                    if (!$result)
                        $validator->errors()->add('host_id', trans('php-core::validation.exists'));
                } elseif (
                    !empty(config('wk-core.class.user'))
                    && $data['host_type'] == config('wk-core.class.user')
                ) {
                    $result = DB::table(config('wk-core.table.user'))
                                ->where('id', $data['host_id'])
                                ->exists();
                    if (!$result)
                        $validator->errors()->add('host_id', trans('php-core::validation.exists'));
                }
            }
        });
    }
}
