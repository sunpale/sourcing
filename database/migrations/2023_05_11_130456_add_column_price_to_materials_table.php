<?php

use App\Schemas\Grammars\CustomSqlServerGrammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (env('DB_CONNECTION')==='sqlsrv'){
            DB::connection()->setSchemaGrammar(new CustomSqlServerGrammar());
        }
        Schema::table('materials', function (Blueprint $table) {
            $table->decimal('unit_price',places: 0)->default('0');
            $table->dropColumn('image_path');
            $table->dropColumn('image_name');
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('unit_price');
            $table->string('image_path',255)->nullable();
            $table->string('image_name',75)->nullable();
        });
    }
};
