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

        Schema::create('materials', function (Blueprint $table) {
            $table->bigInteger('id')->primary()->unique();
            $table->string('kode',16)->unique();
            $table->string('kode_infor',16)->nullable()->index();
            $table->smallInteger('fabric_id')->nullable()->index();
            $table->tinyInteger('color_id')->nullable()->index();
            $table->tinyInteger('brand_id')->index();
            $table->smallInteger('supplier_id')->index();
            $table->smallInteger('pantone_id')->nullable()->index();
            $table->tinyInteger('product_group_id')->nullable()->index();
            $table->smallInteger('color_aks_id')->nullable()->index();
            $table->tinyInteger('komposisi_id')->nullable()->index();
            $table->string('item_name',100);
            $table->string('item_desc',255);
            $table->string('gramasi',25)->nullable();
            $table->string('lebar',15)->nullable();
            $table->float('susut')->nullable();
            $table->string('finish',25)->nullable();
            $table->smallInteger('lead_time');
            $table->smallInteger('moq');
            $table->smallInteger('moq_color')->nullable();
            $table->tinyInteger('ppn');
            $table->tinyInteger('measure_id');
            $table->decimal('unit_price',places: 0)->default('0');
            $table->string('component',255)->nullable();
            $table->smallInteger('created_by')->index();
            $table->smallInteger('updated_by')->index();
            $table->smallInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
