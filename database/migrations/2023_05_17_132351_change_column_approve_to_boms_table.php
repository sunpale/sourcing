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
        Schema::table('boms', function (Blueprint $table) {
            $table->dropColumn('approved');
            $table->boolean('is_approved')->nullable();
            $table->timestamp('approved_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('boms', function (Blueprint $table) {
            $table->dropColumn('is_approved');
            $table->dropColumn('approved_at');
            $table->smallInteger('approved')->nullable();
        });
    }
};
