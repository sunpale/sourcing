<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->smallIncrements('id')->unique();
            $table->string('kode',3)->unique();
            $table->string('type',15);
            $table->tinyInteger('product_group_id');
            $table->string('name',30);
            $table->string('address',255)->nullable();
            $table->string('country',30)->nullable();
            $table->string('pic',30);
            $table->string('phone',16);
            $table->string('email',50)->nullable();
            $table->smallInteger('created_by')->index();
            $table->smallInteger('updated_by')->index();
            $table->smallInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
