<?php
header('Content-Type: application/json; charset=utf-8');
$api_key = "your-key";
$text = !empty($_GET["text"])?$_GET["text"]:NULL;
if (empty($text)){
    echo json_encode(["status"=>"error", "massage"=> "You must specify text"]);
    exit();
}

$lang_caple = "ru-uk";

         $str_arr = explode(" ", $text);
         krsort($str_arr);
         $last_words = [];
         $i=0;
         foreach ($str_arr as $key=>$value){
             if($i==5){
                 break;
             }
             $last_words[$key]=$value;
             $i++;
         }
         ksort($last_words);
         $last_words_str=  implode(" ", $last_words);
         $detect = file_get_contents("https://translate.yandex.net/api/v1.5/tr.json/detect?key=".$api_key.
           "&text=".urlencode($last_words_str));
         if(!empty($detect)){
             $detect=  json_decode($detect);
             if($detect->code==200){
                 if($detect->lang=="uk"){
                     $lang_caple="uk-ru";
                 }
             }
         }


$translate = file_get_contents("https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$api_key.
        "&text=".  urlencode($text)."&lang=".$lang_caple
        );
$translate = json_decode($translate);
if($translate->code==200){
echo json_encode(["status"=> "ok", "text"=>$translate->text, "direct"=>$lang_caple]);
}
if($translate->code==402){
    echo json_encode(["status"=>"error", "massage"=> "Api key blocked"]);
    
}
if($translate->code==403){
    echo json_encode(["status"=>"error", "massage"=> "Day lomit"]);
    
}
if($translate->code==404){
    echo json_encode(["status"=>"error", "massage"=> "Month lomit"]);
}
 
return $lang;
 
}
