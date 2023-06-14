<?php

use App\Schemas\Grammars\CustomSqlServerGrammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (env('DB_CONNECTION')==='sqlsrv') {
            DB::connection()->setSchemaGrammar(new CustomSqlServerGrammar());
        }
        Schema::create('users', function (Blueprint $table) {
            $table->smallIncrements('id')->unique();
            $table->string('name');
            $table->string('username',20)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
