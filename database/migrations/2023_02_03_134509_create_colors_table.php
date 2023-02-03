<?php

use App\Schemas\Grammars\CustomSqlServerGrammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::setSchemaGrammar(new CustomSqlServerGrammar());
        Schema::create('colors', function (Blueprint $table) {
            $table->tinyIncrements('id')->unique();
            $table->string('kode',3)->unique();
            $table->string('description',25)->index();
            $table->smallInteger('created_by')->index();
            $table->smallInteger('updated_by')->index();
            $table->smallInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('colors');
    }
};
