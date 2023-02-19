<?php

namespace App\Models\master_rm;

use App\Traits\CustomSoftDelete;
use App\Traits\UserInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class material extends Model
{
    use UserInput,CustomSoftDelete,SoftDeletes {CustomSoftDelete::runSoftDelete insteadof SoftDeletes;}

    protected $fillable = ['kode','kode_infor','fabric_id','color_id','brand_id','supplier_id','pantone_id','product_group_id','color_aks_id','komposisi_id','item_name','item_desc','gramasi','lebar','susut','finish','lead_time','moq','moq_color','ppn','measure_id','image_path','image_name'];
}
