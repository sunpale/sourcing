<?php

use App\Schemas\Grammars\CustomSqlServerGrammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::connection()->setSchemaGrammar(new CustomSqlServerGrammar());
        Schema::create('fabrics', function (Blueprint $table) {
            $table->smallIncrements('id')->unique();
            $table->string('kode',3)->index();
            $table->string('description',25);
            $table->smallInteger('created_by')->index();
            $table->smallInteger('updated_by')->index();
            $table->smallInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fabrics');
    }
};
