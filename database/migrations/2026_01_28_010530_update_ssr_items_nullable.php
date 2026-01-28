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
        Schema::table('ssr_items', function (Blueprint $table) {
            $table->integer('quantity_req')->nullable()->change();
            $table->integer('quantity_app')->nullable()->change();
            $table->integer('balance')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ssr_items', function (Blueprint $table) {
            //
        });
    }
};
