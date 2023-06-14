<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bom_details', function (Blueprint $table) {
            $table->bigInteger('id')->primary()->unique();
            $table->bigInteger('bom_id')->index();
            $table->bigInteger('material_id')->index();
            $table->tinyInteger('product_group_id')->index();
            $table->tinyInteger('size_id')->index();
            $table->tinyInteger('ratio')->nullable();
            $table->float('cons');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bom_details');
    }
};
