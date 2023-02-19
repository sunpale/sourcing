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
        Schema::create('color_aks', function (Blueprint $table) {
            $table->smallIncrements('id')->unique();
            $table->string('kode',3)->unique();
            $table->string('color_desc',100);
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
        Schema::dropIfExists('color_aks');
    }
};
