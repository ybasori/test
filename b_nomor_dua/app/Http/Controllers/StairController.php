<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StairController extends Controller
{
    public function possibility(Request $request){
        $rules=[
            'n' => 'required|integer'
            ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $errors=$validator->getMessageBag()->toArray();
            return response()->json($errors, 400);
        }
        else{
            if($request->input('n')==0){
                return response("<div class='alert alert-danger'>The n cannot be 0</div>", 400 );
            }
            else{
                $n=$request->input('n');
                $last_array=[];

                for($i=0;$i<$n; $i++){
                    $last_array[]=2;
                }
                if(array_sum($last_array)!=$n){
                    $selisih=array_sum($last_array)-$n;
                    for($i=0;$i<$selisih; $i++){
                        $last=count($last_array)-1;
                        $last_array[$last]=$last_array[$last]-1;
                        if($last_array[$last]==0){
                            unset($last_array[$last]);
                        }
                    }
                }

                $pos=[];
                
                
                $posisi=0;
                for($i=0;$i<$n; $i++){
                    $pos[0][]=1;
                }

                $x=0;
                while($x<1){
                    $k=0;
                        foreach($pos[$posisi] as $key=>$po){
                            $new=$pos[$posisi];
                            if($key==$k){
                                $new[$k]=2;
                                
                                if(array_sum($new)!=$n){
                                    $last=count($new)-1;
                                    $new[$last]=$new[$last]-1;
                                    if($new[$last]==0){
                                        unset($new[$last]);
                                    }
                                }
                                if(!in_array($new, $pos)){
                                    $pos[]=$new;
                                    $k++;
                                }
                            }
                        }
                        $posisi++;
                        
                    if(in_array($last_array, $pos)){
                        $x=1;
                    }
                }
                $output="";
                foreach($pos as $key=>$po){
                    $output=$output."<li>".json_encode($po)."</li>";
                }
                return response("Total: ".count($pos)."<br>"."Output: <br><ol>".$output."</ol>", 200 );
                
            }
        }
    }
}
