<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('color_aks', function (Blueprint $table) {
            $table->smallIncrements('id')->unique();
            $table->string('kode',3)->unique();
            $table->string('color_desc',100);
            $table->string('remarks',100)->nullable();
            $table->smallInteger('created_by')->index();
            $table->smallInteger('updated_by')->index();
            $table->smallInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('color_aks');
    }
};
