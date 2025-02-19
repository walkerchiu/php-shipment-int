<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateWkShipmentTable extends Migration
{
    public function up()
    {
        Schema::create(config('wk-core.table.shipment.settings'), function (Blueprint $table) {
            $table->uuid('id');
            $table->nullableUuidMorphs('host');
            $table->string('serial')->nullable();
            $table->string('type');
            $table->unsignedBigInteger('order')->nullable();
            $table->json('options')->nullable();
            $table->boolean('is_enabled')->default(0);

            $table->timestampsTz();
            $table->softDeletes();

            $table->primary('id');
            $table->index('serial');
            $table->index('type');
            $table->index('is_enabled');
        });
        if (!config('wk-shipment.onoff.core-lang_core')) {
            Schema::create(config('wk-core.table.shipment.settings_lang'), function (Blueprint $table) {
                $table->uuid('id');
                $table->nullableUuidMorphs('morph');
                $table->uuid('user_id')->nullable();
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

                $table->primary('id');
            });
        }
        Schema::create(config('wk-core.table.shipment.shipany'), function (Blueprint $table) {
            $table->uuid('id');
            $table->nullableUuidMorphs('host');
            $table->string('api_tk');
            $table->string('password');
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('url_cancel')->nullable();
            $table->string('url_return')->nullable();
            $table->string('currency');
            $table->string('locale', 5);
            $table->string('intent');
            $table->json('options')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            $table->foreign('host_id')->references('id')
                  ->on(config('wk-core.table.shipment.settings'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->primary('id');
        });
    }

    public function down() {
        Schema::dropIfExists(config('wk-core.table.shipment.shipany'));
        Schema::dropIfExists(config('wk-core.table.shipment.settings_lang'));
        Schema::dropIfExists(config('wk-core.table.shipment.settings'));
    }
}
