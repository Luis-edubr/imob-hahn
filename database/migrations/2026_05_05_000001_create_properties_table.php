<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->string('code', 50)->unique();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('property_type', 80)->index(); // casa, apartamento, terreno, comercial, rural...
            $table->string('transaction_type', 30)->index(); // venda, aluguel, temporada
            $table->string('status', 30)->default('draft')->index(); // draft, published, paused, sold, rented

            $table->string('short_description', 255)->nullable();
            $table->longText('description')->nullable();

            $table->unsignedBigInteger('price')->nullable(); // valor principal (venda ou aluguel)
            $table->unsignedBigInteger('price_sale')->nullable();
            $table->unsignedBigInteger('price_rent')->nullable();
            $table->unsignedBigInteger('condo_fee')->nullable();
            $table->unsignedBigInteger('iptu_value')->nullable();

            $table->decimal('total_area', 10, 2)->unsigned()->nullable();
            $table->decimal('built_area', 10, 2)->unsigned()->nullable();
            $table->decimal('land_area', 10, 2)->unsigned()->nullable();

            $table->smallInteger('bedrooms')->unsigned()->nullable();
            $table->smallInteger('suites')->unsigned()->nullable();
            $table->smallInteger('bathrooms')->unsigned()->nullable();
            $table->smallInteger('half_bathrooms')->unsigned()->nullable();
            $table->smallInteger('rooms')->unsigned()->nullable();
            $table->smallInteger('garages')->unsigned()->nullable();
            $table->smallInteger('parking_spaces')->unsigned()->nullable();
            $table->smallInteger('floors')->unsigned()->nullable();

            $table->boolean('furnished')->default(false);
            $table->boolean('featured')->default(false)->index();
            $table->boolean('highlight_home')->default(false)->index();
            $table->boolean('active')->default(true)->index();

            // endereço / localização
            $table->string('postal_code', 20)->nullable();
            $table->string('street')->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable()->index();
            $table->string('state', 2)->nullable()->index();
            $table->string('country', 60)->nullable()->default('Brasil');
            $table->string('location_label')->nullable(); // ex: "Rua Doutor Pena, Bagé/RS"
            $table->text('maps_url')->nullable();
            $table->decimal('latitude', 10, 7, true)->nullable();
            $table->decimal('longitude', 10, 7, true)->nullable();

            // SEO / mídia principal
            $table->string('cover_image_path')->nullable();
            $table->string('cover_image_alt')->nullable();
            $table->string('video_url')->nullable();
            $table->string('virtual_tour_url')->nullable();

            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['transaction_type', 'status']);
            $table->index(['property_type', 'active']);
            $table->index(['featured', 'active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
