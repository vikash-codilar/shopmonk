<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Excel;
use DB;
class ExcelController extends Controller

{

	/**
     * Create a new controller instance.
     *
     * @return void
     */

    public function importExportView(){

        return view('import_export');

    }



    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function importFile(Request $request){

        if($request->hasFile('sample_file')){
           // 

                

                Excel::load($request->file('sample_file')->getRealPath(), function($reader) use (&$excel) {
                    $objExcel = $reader->getExcel();
                    $sheet = $objExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    //  Loop through each row of the worksheet in turn
                    for ($row = 1; $row <= $highestRow; $row++){
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL, TRUE, FALSE);
                        $excel[] = $rowData[0];
                    }
                });
                $limit = 4;
                $qty   = 0;
                $box   = 1;
                $tc    = $excel[3][4];       // first time count
                $invoiceno   = $excel[0][3]; // first time count
                $palletid    = $excel[2][1]; // Pallet Id
                $productcode = $excel[3][1]; // Product Code
                $description = $excel[3][2]; // product description
                $model       = "";
                $storage     = "";
                $color       = "";
                $allrecords  = [];
                echo "Box No: ".$box;
                $arr = (array)$this->getProductdetails($productcode);
                $allrecords =[];
                for ($exrow = $limit; $exrow <= sizeof($excel); $exrow++){
                    $qty++;
                    //echo $qty."-".$tc;
                        if($excel[$exrow][0]!=''){
                            if($qty==$tc+1 || $qty==$tc+2){
                                echo"<br/>";
                                if($qty==($tc+2)){
                                    echo "Box No: ".++$box;
                                    $tc+= ($excel[$exrow][4]+2);
                                    echo $productcode = $excel[$exrow][1];
                                    $arr = (array)$this->getProductdetails($productcode);
                                    echo"<br/>";
                                }
                            }else{
                                echo"IMEI => ".$excel[$exrow][0];
                                
                                $allrecords[] = array_merge(array('imei'=>$excel[$exrow][0],'productcode'=>$productcode,'invoiceno'=>$invoiceno,'palletid'=>$palletid,'boxid'=>$box,'description'=>$description),$arr);
                                echo"<br/>";
                               
                                
                            }
                        }else{
                            break;
                        }
                }

                //dd('Read all records successfully.');
                
                if(!empty($allrecords)){
                    $srcarr=array_chunk($allrecords,5000);
                    foreach($srcarr as $item) {
                        DB::table('product_csv_data')->insert($item);
                    }
                    dd('Insert Recorded successfully.');
                }


            

        }

        dd('Request data does not have any files to import.');      

    } 
    
    public function getProductdetails($productcode){
        $productdetails = DB::table('product_detail_lines')->where('productcode', $productcode)->first(['model', 'color','storage']);
        if(!empty((array)$productdetails)){
            return $productdetails;
        }else{
            return array('model'=>'NA','color'=>'NA','storage'=>'NA');
        }
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function exportFile($type){

        $products = Product::get()->toArray();



        return \Excel::create('hdtuto_demo', function($excel) use ($products) {

            $excel->sheet('sheet name', function($sheet) use ($products)

            {

                $sheet->fromArray($products);

            });

        })->download($type);

    }      

}