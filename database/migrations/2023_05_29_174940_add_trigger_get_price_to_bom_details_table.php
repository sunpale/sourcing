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
FOR INSERT
AS
BEGIN
  UPDATE bom_details SET bom_details.PRICE = materials.unit_price FROM bom_details INNER JOIN materials ON bom_details.material_id = materials.id WHERE bom_details.id IN (SELECT inserted.id FROM inserted);
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
        if (env('DB_CONNECTION')==='sqlsrv'){
            DB::unprepared('DROP TRIGGER IF EXISTS set_price;');
        }
        elseif(env('DB_CONNECTION')==='mysql'){
            DB::unprepared('DROP TRIGGER IF EXISTS set_price');
        }
    }
};
