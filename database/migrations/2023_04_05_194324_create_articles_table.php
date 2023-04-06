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
        Schema::create('articles', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('kode',16)->unique();
            $table->string('name',50)->index();
            $table->smallInteger('pantone_id')->index();
            $table->smallInteger('brand_id')->index();
            $table->string('modul',25);
            $table->string('designer',50);
            $table->smallInteger('created_by')->index();
            $table->smallInteger('updated_by')->index();
            $table->smallInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
