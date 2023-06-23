<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->tinyIncrements('id')->unique();
            $table->string('location',50)->index();
            $table->string('remarks')->nullable();
            $table->smallInteger('created_by');
            $table->smallInteger('updated_by');
            $table->smallInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
