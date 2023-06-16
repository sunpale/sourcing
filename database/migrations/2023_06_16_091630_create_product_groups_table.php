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
        Schema::create('product_groups', function (Blueprint $table) {
            $table->tinyIncrements('id')->unique();
            $table->string('kode',2)->unique();
            $table->string('type',15)->index();
            $table->string('group',25)->index();
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
        Schema::dropIfExists('product_groups');
    }
};
