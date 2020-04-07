<?php

//$token="1047034345:AAEo7NOBOyiJR1cJvVRuSKdnZ1mLae3onZQ";
//$user_id=483621591;
//$mesg='Davud bot';
//$request_params = [
//    'chat_id' => $user_id,
//    'text' => $mesg
//];
//$request_url= 'https://api.telegram.org/bot' .$token .'/sendMessage?' .http_build_query($request_params);
//file_get_contents($request_url);


class TelegramBot {
    const API_URL = 'https://api.telegram.org/bot';
    public $token;
    public $chatId;
    public function setToken($token){
        $this->token = $token;
    }
    public function getData(){
        $data = json_decode(file_get_contents('php://input'));
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $data);
        echo $data;
        $this->chatId = $data->message->chat->id;
        return $data->message;
    }
    public function setWebhook($url){
        return $this->request('setWebhook',[
           'url'=>$url
        ]);
    }
    public function sendMessage($message){
        return $this->request('sendMessage', [
            'chat_id' => $this->chatId,
            'text'=> $message
        ]);
    }
    public function request($method, $posts){
        $ch = curl_init();
        $url=self::API_URL .$this->token .'/' .$method;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($posts));
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }
}
// https://digitelegram.requestcatcher.com/
$telegram = new TelegramBot();
$telegram->setToken('1135490249:AAFupOMDh31tpxqDIzBRcLseU__w1UPspFo');
echo $telegram->setWebhook('');


$data = $telegram->getData();

if ($data->text == 'hello'){
    $telegram->sendMessage('hey hi everyone');
}
