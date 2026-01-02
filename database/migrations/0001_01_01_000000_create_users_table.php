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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name' , 50)->nullable()->default('کاربر سایت');
            $table->json('bank_accounts_info')->nullable();
            $table->string('melli_code',11)->nullable();
            $table->string('mobile' , 10)->unique();
            $table->string('password')->nullable();
            $table->enum('status' , \App\Models\User::$statuses)->default(\App\Models\User::ACTIVE)->nullable();
            $table->unsignedBigInteger('city_id')->nullable();;
            $table->integer('credit')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->softDeletes();
            $table->string('birth_date' , 11)->nullable();
            $table->timestamps();
            $table->index('mobile','users_mobile_index');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
