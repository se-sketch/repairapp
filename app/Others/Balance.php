<?php 

namespace App\Others;

use Illuminate\Support\Facades\DB;
//use PhpParser\Node\Stmt\TryCatch;
use \App\Models\ReceiptOfMaterial;
//use \App\Models\ReceiptDetails;
use App\Models\WriteOffOfMaterial;
//use \App\Models\WriteOffDetail;
use \App\Models\Detail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 */
class Balance 
{
	function __construct()
	{
		# code...
	}

    private function get_string_array($arr){

        if (!is_array($arr)){
            return '';
        }
        if (sizeof($arr) == 0){
            return '';
        }

        $arr = array_map('intval', $arr);
        $str_arr = "(".implode(", ", $arr).")";

        return $str_arr;
    }

    public function getBalance($created_at, $arr_subdivision, $arr_nomen, $fl_names){

        $created_at = date('Y-m-d H:i:s');

        $cond_created = "";
        if ($created_at){
            if (\DateTime::createFromFormat('Y-m-d H:i:s', $created_at) !== FALSE) {
                $cond_created = " and doc.created_at <= '$created_at' ";
            }
        }

        $str_arr = $this->get_string_array($arr_nomen);
        $cond_nomen = ($str_arr) ? " and details.nomenclature_id in $str_arr " : "";

        $str_arr = $this->get_string_array($arr_subdivision);
        $cond_subdivision = ($str_arr) ? " and doc.subdivision_id in $str_arr " : "";


        $write_off_class = WriteOffOfMaterial::class;
        $write_off_class = addslashes($write_off_class);

        $sql_w = "select 
            doc.subdivision_id,
            details.nomenclature_id,
            - details.qty as qty
        from write_off_of_materials doc

        left join details on doc.id = details.detailable_id
        and details.detailable_type = '$write_off_class'

        where doc.active = 1
        and doc.deleted_at is null
        and details.deleted_at is null
        $cond_subdivision
        $cond_created
        $cond_nomen 
        ";        

        $receipt_of_class = ReceiptOfMaterial::class;
        $receipt_of_class = addslashes($receipt_of_class);

        $sql_r = "select 
            doc.subdivision_id,
            details.nomenclature_id,
            details.qty as qty
        from receipt_of_materials doc

        left join details on doc.id = details.detailable_id
        and details.detailable_type = '$receipt_of_class'

        where doc.active = 1
        and doc.deleted_at is null
        and details.deleted_at is null
        $cond_subdivision
        $cond_created
        $cond_nomen 
        ";

        $sql = "select subdivision_id, nomenclature_id, sum(qty) as qty
        from
         ($sql_w 
        union all 
        $sql_r ) t 
        group by subdivision_id, nomenclature_id";


        if ($fl_names){
            $sql = "select t2.subdivision_id, t2.nomenclature_id, t2.qty,
            subdivisions.name as subname, nomenclatures.name as nomname
            from ( $sql ) t2
            left join subdivisions on subdivisions.id = t2.subdivision_id
            left join nomenclatures on nomenclatures.id = t2.nomenclature_id
            ";
        }

        $result = DB::select($sql);

        return $result;
    }

    /*
        select write_off_of_materials.id, 
            write_off_of_materials.subdivision_id,
            details.nomenclature_id,
            details.qty
        from write_off_of_materials
        left join details on write_off_of_materials.id = details.detailable_id
        and details.detailable_type = "App\Models\WriteOffOfMaterial"
        where write_off_of_materials.active = 1
        and write_off_of_materials.deleted_at is null

    */

    /*
    public static function getBalance(){


        $table_w = DB::table('write_off_of_materials')
            ->leftJoin('details', function($join){
            $join->on('write_off_of_materials.id', '=', 'details.detailable_id')
                ->where('details.detailable_type', WriteOffOfMaterial::class);
        })
        ->where('active', 1)
        ->whereNull('write_off_of_materials.deleted_at')
        ->whereNull('details.deleted_at')
        ->select('subdivision_id', 'details.nomenclature_id')
        ->selectRaw('-details.qty as qty');

        $table_r = DB::table('receipt_of_materials')
            ->leftJoin('details', function($join){
            $join->on('receipt_of_materials.id', '=', 'details.detailable_id')
                ->where('details.detailable_type', ReceiptOfMaterial::class);
        })
        ->where('active', 1)
        ->whereNull('receipt_of_materials.deleted_at')
        ->whereNull('details.deleted_at')
        ->select('subdivision_id', 'details.nomenclature_id')
        ->selectRaw('details.qty as qty');

        
        $details = $table_w->unionAll($table_r)
            ->dd()
            //->select('subdivision_id , nomenclature_id')
            //->selectRaw('sum(qty)')
            //->groupBy('subdivision_id', 'nomenclature_id')
            ->get();

        return $details;
    }
    */

    /*
	public static function getBalance(){

		//$created_at = date('Y-m-d', strtotime('-14 day'));

		$created_at = date('Y-m-d H:i:s');
		//$created_at = date('Y-m-d H:i:s', strtotime('-14 day'));

		dump($created_at);

		$arr_nomen = [];

		$table1 = DB::table('write_off_of_materials')
            ->join('write_off_details', 
            	'write_off_of_materials.id', '=','write_off_details.write_off_id')
            ->where('write_off_of_materials.active', 1)
            //->where('write_off_of_materials.created_at', '<=', $created_at)
            ->whereNull('write_off_of_materials.deleted_at')
            ->whereNull('write_off_details.deleted_at')
            ->select('subdivision_id', 'nomenclature_id', 'write_off_details.qty');
            

        if ($created_at){
        	$table1->where('write_off_of_materials.created_at', '<=', $created_at);
        }

        if (sizeof($arr_nomen) > 0){
        	$table1->whereIn('nomenclature_id', $arr_nomen);
        }

		$table2 = DB::table('receipt_of_materials')
            ->join('receipt_details', 
            	'receipt_of_materials.id', '=','receipt_details.receipt_id')
            ->where('receipt_of_materials.active', 1)
            //->where('receipt_of_materials.created_at', '<=', $created_at)
            ->whereNull('receipt_of_materials.deleted_at')
            ->whereNull('receipt_details.deleted_at')
            ->select('subdivision_id', 'nomenclature_id', 'receipt_details.qty');
            //->selectRaw('qty as qty1')
            //->selectRaw('0 as qty2');

        if ($created_at){
        	$table2->where('receipt_of_materials.created_at', '<=', $created_at);
        }

        if (sizeof($arr_nomen) > 0){
        	$table2->whereIn('nomenclature_id', $arr_nomen);
        }

        
        $result = $table1->unionAll($table2)
        	->selectRaw('subdivision_id , nomenclature_id, sum(write_off_details.qty), sum(receipt_details.qty) ')

            //->groupBy('subdivision_id', 'nomenclature_id')
            ->get();

        return $result;
	}
    */

}


/*

    DB::beginTransaction();

    try{


        DB::commit();

    }catch(\Exception $e){

        DB::rollback();

        $message = $e->getMessage();
    }

*/