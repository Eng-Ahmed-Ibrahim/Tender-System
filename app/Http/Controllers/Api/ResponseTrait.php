<?php 
namespace App\Http\Controllers\Api;

trait ResponseTrait{
    public function Response($data=null,$msg=null,$status){
        $array=[
            "data"=>$data,
            "message"=>$msg,
            "status"=>$status,
        ];
        return response($array,$status);
    }
}