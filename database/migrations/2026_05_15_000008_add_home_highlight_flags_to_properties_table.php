<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->boolean('highlight_sale')->default(false)->index()->after('highlight_home');
            $table->boolean('highlight_rent')->default(false)->index()->after('highlight_sale');
            $table->boolean('weekly_deal')->default(false)->index()->after('highlight_rent');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['highlight_sale', 'highlight_rent', 'weekly_deal']);
        });
    }
};
