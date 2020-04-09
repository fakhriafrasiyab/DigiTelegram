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

class TelegramBot
{
    const API_URL = 'https://api.telegram.org/bot';
    public $token;
    public $chatId;

    public function setToken($token)
    {
        $this->token = $token;
    }
//    public function getData(){
//        $data = json_decode(file_get_contents('php://input'));
//        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//        fwrite($myfile, $data);
//        $this->chatId = $data->message->chat->id;
//        return $data->message;
//    }
    function getData()
    {
        $myfile = fopen("testmeqsedli.txt", "w") or die("Unable to open file!");
        fwrite($myfile, "bura gelib catir");
        $data = json_decode(file_get_contents('php://input'), true);
        //print_r($data);
        fwrite($myfile, "bura gelib catmir");
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        //fwrite($myfile, $data['message']);
//        print_r($data['message']);
        $this->chatId = 483621591;
        print_r($this->chatId);
        return $data['message'];
    }

    public function setWebhook($url)
    {
        return $this->request('setWebhook', [
            'url' => $url
        ]);
    }

    public function sendMessage($message)
    {
        return $this->request('sendMessage', [
            'chat_id' => 483621591,
            'text' => $message
        ]);
    }
    function sendTelegram($chatID, $msg) {
        echo "sending message to " . $chatID . "\n";

        $token = "1135490249:AAFupOMDh31tpxqDIzBRcLseU__w1UPspFo";
        $getUpdate = "http://api.telegram.org/" . $token . "/getUpdates";

        $url = "https://api.telegram.org/" . $token . "/sendMessage?chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($msg);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function request($method, $posts)
    {
        $ch = curl_init();
        $url = self::API_URL . $this->token . '/' . $method;
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
$telegram = new TelegramBot();
//$result = $telegram->sendTelegram(483621591, "hi");
//print_r($result);

//https://digitelegram.herokuapp.com
try {
    $telegram->setToken('1135490249:AAFupOMDh31tpxqDIzBRcLseU__w1UPspFo');
    //print_r($telegram->setWebhook(''));

    $data = $telegram->getData();
    print_r($data['text']);
    if ($data['text'] == 'hello') {
       print_r($telegram->sendMessage('hey hi everyone'));
    }
} catch (Exception $e) {
    print_r( 'Message:' .$e->getMessage());
}
