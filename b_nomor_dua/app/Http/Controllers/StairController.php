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

                $pos=[];
                
                
                $posisi=0;
                $j=0;
                for($i=0;$i<$n; $i++){
                    $pos[$j][$i]=1;
                }
                $j++;

                $x=0;
                while($x<pow($n,($n*(2/5)))){
                    $k=0;
                    foreach($pos[$posisi] as $key=>$po){
                        $pos[$j]=$pos[$posisi];
                        if($key==$k){
                            $pos[$j][$k]=2;
                        }
                        $j++;
                        $k++;
                    }
                    $posisi++;

                    // if($pos[count($pos)-1]==$last_array){
                    //     $x=1;
                    // }
                    $x++;
                }

                $pos_2=[];
                foreach($pos as $key=> $po){
                    if(!in_array($po, $pos_2)){
                        array_push($pos_2, $po);
                    }
                }
                foreach($pos_2 as $key => $po){
                    $q=0;
                    while($q<1){
                        if(array_sum($pos_2[$key])!=$n){
                            $last=count($pos_2[$key])-1;
                            $pos_2[$key][$last]=$pos_2[$key][$last]-1;
                            if($pos_2[$key][$last]==0){
                                unset($pos_2[$key][$last]);
                            }
                        }
                        else{
                            $q=1;
                        }
                    }
                }

                $a=0;
                foreach($pos_2 as $value){
                    $b=0;
                    foreach($value as $subvalue){
                        $res[$a][$b]=$subvalue;
                        $b++;
                    }
                    $a++;
                }

                $result=[];
                foreach($res as $key=> $po){
                    if(!in_array($po, $result)){
                        array_push($result, $po);
                    }
                }

                
                return response(dd($result), 200 );
            }
        }
    }
}
