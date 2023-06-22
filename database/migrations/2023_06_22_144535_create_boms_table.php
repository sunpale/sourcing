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
            $table->tinyInteger('revision')->default(0);
            $table->tinyInteger('status');
            $table->smallInteger('created_by');
            $table->smallInteger('updated_by');
            $table->smallInteger('deleted_by')->nullable();
            $table->smallInteger('approved_by')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        if (env('DB_CONNECTION')==='sqlsrv') {
            DB::unprepared('CREATE TRIGGER [dbo].[update_bom_status_on_article]
ON [dbo].[boms]
FOR INSERT
AS
BEGIN
    DECLARE @articleId BIGINT;
		SELECT @articleId = article_id FROM INSERTED boms;
		UPDATE articles SET bom_release=1 WHERE id = @articleId;
END');
        }
        elseif(env('DB_CONNECTION')==='mysql'){
            DB::unprepared('CREATE TRIGGER `update_bom_status_on_article` AFTER INSERT ON `boms` FOR EACH ROW BEGIN
	UPDATE articles SET bom_release=1 WHERE id = new.article_id;
END;');
        }
    }

    public function down(): void
    {
        if (env('DB_CONNECTION')==='sqlsrv'){
            DB::unprepared('DROP TRIGGER IF EXISTS update_bom_status_on_article;');
        }
        elseif(env('DB_CONNECTION')==='mysql'){
            DB::unprepared('DROP TRIGGER IF EXISTS update_bom_status_on_article');
        }
        Schema::dropIfExists('boms');

    }
};
