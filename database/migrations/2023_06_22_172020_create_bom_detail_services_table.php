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
        Schema::create('bom_detail_services', function (Blueprint $table) {
            $table->bigInteger('id')->primary()->unique();
            $table->bigInteger('bom_id')->index();
            $table->tinyInteger('service_id')->index();
            $table->string('remarks',100)->nullable();
            $table->tinyInteger('cons');
            $table->decimal('price',places: 2);
            $table->foreign('bom_id')->references('id')->on('boms')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bom_detail_services');
    }
};
