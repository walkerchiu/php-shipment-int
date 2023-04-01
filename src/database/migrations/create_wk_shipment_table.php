<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateWkShipmentTable extends Migration
{
    public function up()
    {
        Schema::create(config('wk-core.table.shipment.shipments'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableMorphs('host');
            $table->string('serial')->nullable();
            $table->string('type');
            $table->unsignedBigInteger('order')->nullable();
            $table->boolean('is_enabled')->default(0);

            $table->timestampsTz();
            $table->softDeletes();

            $table->index('serial');
            $table->index('type');
            $table->index('is_enabled');
        });
        if (!config('wk-shipment.onoff.core-lang_core')) {
            Schema::create(config('wk-core.table.shipment.shipments_lang'), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->morphs('morph');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('code');
                $table->string('key');
                $table->longText('value')->nullable();
                $table->boolean('is_current')->default(1);

                $table->timestampsTz();
                $table->softDeletes();

                $table->foreign('user_id')->references('id')
                    ->on(config('wk-core.table.user'))
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            });
        }
        Schema::create(config('wk-core.table.shipment.shipany'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('host_id');
            $table->string('api_tk');
            $table->string('password');
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('url_cancel')->nullable();
            $table->string('url_return')->nullable();
            $table->string('currency');
            $table->string('locale', 5);
            $table->string('intent');

            $table->timestampsTz();
            $table->softDeletes();

            $table->foreign('host_id')->references('id')
                  ->on(config('wk-core.table.shipment.shipments'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists(config('wk-core.table.shipment.shipany'));
        Schema::dropIfExists(config('wk-core.table.shipment.shipments_lang'));
        Schema::dropIfExists(config('wk-core.table.shipment.shipments'));
    }
}
