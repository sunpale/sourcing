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
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('bom_release')->default('0');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('bom_release');
        });
    }
};
