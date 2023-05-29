<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (env('DB_CONNECTION')==='sqlsrv') {
            DB::unprepared('CREATE TRIGGER [dbo].[set_price]
ON [dbo].[bom_details]
INSTEAD OF INSERT
AS
BEGIN
	DECLARE @materialId BIGINT;
	DECLARE @price DECIMAL;

	SELECT @materialId = material_id FROM INSERTED bom_details;
	SELECT @price = (SELECT unit_price FROM materials WHERE id = @materialId);

	INSERT INTO sourcing.dbo.bom_details(id,bom_id,material_id,product_group_id,size_id,ratio,cons,price) SELECT t.id,t.bom_id,t.material_id,t.product_group_id,t.size_id,t.ratio,t.cons,@price FROM inserted t;
END;');
        }
        elseif(env('DB_CONNECTION')==='mysql'){
            DB::unprepared('CREATE TRIGGER `set_price` BEFORE INSERT ON `bom_details` FOR EACH ROW BEGIN
	SET new.price = (SELECT unit_price FROM materials WHERE id = New.material_id);
END;');
        }
    }

    public function down(): void
    {
        Schema::table('bom_details', function (Blueprint $table) {
            //
        });
    }
};
