<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bom_details', function (Blueprint $table) {
            $table->decimal('price',places: 0)->default('0');
        });
    }

    public function down(): void
    {
        Schema::table('bom_details', function (Blueprint $table) {
           $table->dropColumn('price');
        });
    }
};
