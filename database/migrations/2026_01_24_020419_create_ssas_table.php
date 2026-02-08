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
        Schema::create('ssas', function (Blueprint $table) {
            $table->id();
            $table->string('ssa_no', 33)->nullable();
            $table->string('vessel', 33)->nullable();
            $table->string('department',33)->nullable();
            $table->dateTime('date');
            $table->string('location',255)->nullable();
            $table->string('ssa_raised',33)->nullable();

            //Foreign Keys
            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();
            $table->string('verified_status',33)->nullable();
            $table->string('verified_remark',255)->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();
            $table->string('approved_status',33)->nullable();
            $table->string('approved_remark',255)->nullable();

            $table->foreignId('pro_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('pro_at')->nullable();
            $table->string('pro_status',33)->nullable();
            $table->string('pro_remark',255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ssas');
    }
};
