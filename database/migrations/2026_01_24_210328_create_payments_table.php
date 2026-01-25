<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('amount');
            $table->unsignedSmallInteger('attempt_number')->default(1);
            $table->string('status')->index();

            $table->string('idempotency_key', 191)->unique();

            $table->uuid('fk_order');
            $table->foreign('fk_order')
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
