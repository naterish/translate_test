<?php
header('Content-Type: application/json; charset=utf-8');
$api_key = "your key";
$word=!empty($_GET["text"])?$_GET["text"]:NULL;
$from = "ru";
$to = "uk";

        $text=  str_replace("\n", " ", $word);
        $text_array=  explode(" ", $text);
        $text_parts=array();
        $length=0;
        $part=0;
        $text_parts[$part]="";


$lang_caple="ru-uk";
         $str_arr = explode(" ", $word);
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
                     $from = "uk";
                     $to = "ru";
                     $lang_caple="uk-ru";
                 }
             }
         }


            if (empty($word)){
                echo json_encode(["status"=>"error", "massage"=>"You must specify text"]);
                exit();
            }





 foreach ($text_array as $word){
            if (empty($word)){
                continue;
            }
            $length+=mb_strlen($word)+2;
            if($length>700){
                $part++;
                $length=0;
                $text_parts[$part]="";
            }
            $text_parts[$part].="{$word} ";
        }
        $res_parts = array();

         foreach ($text_parts as $part=>$value){
             exec("echo '{$value}' | translate {$from} {$to} ", $res);
             $res_parts[]=!empty($res[0])?$res[0]:"";
             unset($res);
        }
$translated_text = implode(" ", $res_parts);
echo json_encode(["status"=>"ok", "text"=>$translated_text, "direct"=>$lang_caple]);

?>

