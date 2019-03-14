<?php
   namespace App\Http\Controllers\User;
   use App\Http\Controllers\Controller;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Redis;
   class IndexController extends Controller{
       public  $hash_token="h:login:token:";
       public  function  login(Request $request){
           $uid=$request->input("uid");
           //设置token
           $token=substr(md5(time()+$uid+rand(1000,9999)),10,20);
           if(1){
               $key=$this->hash_token.$uid;
               Redis::hSet($key,'token',$token);
               Redis::expire($key,60*24*7);
               $response=[
                   'error'=>0,
                   'msg'=>'ok'
               ];
           }else{
               //TODO
           }

           return $response;
       }
      public  function  userCenter(Request $request){
             $uid=$request->input('uid');
             //print_r($_SERVER);die;
             if(!empty($_SERVER['HTTP_TOKEN'])){
                 $http_token=$_SERVER['HTTP_TOKEN'];
                 $key=$this->hash_token.$uid;
                 $token=Redis::hGet($key,'token');
                 if($http_token==$token){
                     $response=[
                         'error'=>0,
                         'msg'=>'ok'
                     ];
                 }else{
                     $response=[
                         'error'=>5001,
                         'msg'=>'invalid token'
                     ];
                 }


             }else{
                 $response=[
                     'error'=>5000,
                     'msg'=>'not find token'
                 ];

             }
          return $response;




      }



   }