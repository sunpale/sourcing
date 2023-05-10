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
        Schema::create('boms', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('kode',20)->unique();
            $table->bigInteger('article_id')->index();
            /*$table->string('remarks',255)->nullable();*/
            $table->tinyInteger('revision');
            /*$table->json('items');*/
            $table->tinyInteger('status');
            $table->smallInteger('created_by');
            $table->smallInteger('updated_by');
            $table->smallInteger('deleted_by')->nullable();
            $table->smallInteger('approved')->nullable();
            $table->smallInteger('approved_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['id','kode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boms');
    }
};
