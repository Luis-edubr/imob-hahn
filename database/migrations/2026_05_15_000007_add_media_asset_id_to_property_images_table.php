<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->foreignId('media_asset_id')
                ->nullable()
                ->after('property_id')
                ->constrained('media_assets')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->dropConstrainedForeignId('media_asset_id');
        });
    }
};
