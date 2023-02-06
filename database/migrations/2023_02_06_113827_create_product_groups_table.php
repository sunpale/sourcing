<?php

use App\Schemas\Grammars\CustomSqlServerGrammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (env('DB_CONNECTION')==='sqlsrv'){
            DB::connection()->setSchemaGrammar(new CustomSqlServerGrammar());
        }
        Schema::create('product_groups', function (Blueprint $table) {
            $table->tinyIncrements('id')->unique();
            $table->string('group',25)->index();
            $table->string('remarks',100)->nullable();
            $table->smallInteger('created_by')->index();
            $table->smallInteger('updated_by')->index();
            $table->smallInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_groups');
    }
};
