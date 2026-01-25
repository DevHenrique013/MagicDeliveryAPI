<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('idempotency_keys', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('idempotency_key', 191);

            $table->string('method', 10);
            $table->string('request_endpoint', 191);

            $table->string('request_hash', 64);

            $table->json('response_body')->nullable();
            $table->unsignedSmallInteger('response_status_code')->nullable();

            $table->string('status')->index();

            $table->timestamp('locked_until')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->unique([
                'user_id',
                'method',
                'request_endpoint',
                'idempotency_key'
            ], 'idempotency_unique_key');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idempotency_keys');
    }
};
