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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('territory_id');
            $table->string('type'); //App\Enums\LeadType
            $table->string('name');
            $table->string('shop_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('post_code')->nullable();
            $table->string('address')->nullable();
            $table->string('union_id')->nullable();
            $table->string('upazila_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('division_id')->nullable();
            $table->boolean('is_customer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
