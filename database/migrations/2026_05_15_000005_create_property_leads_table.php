<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_leads', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('cpf', 14);
            $table->string('email')->index();
            $table->string('phone', 20);

            $table->string('address');
            $table->string('zip', 20)->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('number', 20)->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('complement')->nullable();

            $table->string('property_type', 80)->index();
            $table->smallInteger('suites')->unsigned()->nullable();
            $table->smallInteger('bedrooms')->unsigned()->nullable();
            $table->smallInteger('bathrooms')->unsigned()->nullable();
            $table->smallInteger('rooms')->unsigned()->nullable();
            $table->smallInteger('garages')->unsigned()->nullable();
            $table->boolean('bbq')->default(false);
            $table->text('additional_info')->nullable();

            $table->string('status', 30)->default('new')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_leads');
    }
};
