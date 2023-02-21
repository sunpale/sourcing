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
        if (Schema::hasTable('product_groups')){
            Schema::drop('product_groups');
        }
        Schema::create('product_groups', function (Blueprint $table) {
            $table->tinyIncrements('id')->unique();
            $table->string('kode',2)->unique();
            $table->string('group',25)->index();
            $table->string('remarks',100)->nullable();
            $table->smallInteger('created_by')->index();
            $table->smallInteger('updated_by')->index();
            $table->smallInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('product_groups', function(Blueprint $table) {
            Schema::drop('product_groups');
        });
    }
};
