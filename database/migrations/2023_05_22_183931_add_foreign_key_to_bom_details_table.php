<?php

use App\Schemas\Grammars\CustomSqlServerGrammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (env('DB_CONNECTION')==='sqlsrv') {
            DB::connection()->setSchemaGrammar(new CustomSqlServerGrammar());
        }
        Schema::table('bom_details', function (Blueprint $table) {
            $table->foreign('bom_id')->references('id')->on('boms')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bom_details', function (Blueprint $table) {
            $table->dropForeign(['bom_id']);
        });
    }
};
