<?php
ob_start();
//Config
$website = "وب سایت میزبان";
define('API_KEY','توکن ربات');
//Function
function WorldTm($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//Variables
$update = json_decode(file_get_contents('php://input'));
$chat_id = $update->message->chat->id;
$text = $update->message->text;
$api = json_decode(file_get_contents("https://api.worldtm.uk/ping/?site=$website"), true);
$ping = $api['result']['ping'];
//Code
if($text){
for($i=0;$i<12;$i++){
    if($i !== 11){
    WorldTm('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$i,
	'parse_mode'=>'HTML'
    ]);
    }else{
WorldTm('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$website,
	'parse_mode'=>'HTML',
	'reply_markup'=>json_encode([
    'inline_keyboard'=>[
              [
                 ['text'=>"ping:",'url'=>$website]
             ],
             [
                 ['text'=>$ping,'url'=>$website]
             ],
             ]])
    ]);
    }
    }
}
/*
WorldTeam
@worldtm
*/
?>
