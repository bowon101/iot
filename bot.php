<?php
require("vendor/autoload.php");
 
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
 
require("phpMQTT.php");
 
$mqtt = new phpMQTT("postman.cloudmqtt.com", 1883, "phpMQTT Pub Example"); //เปลี่ยน www.yourmqttserver.com ไปที่ mqtt server ที่เราสมัครไว้นะครับ
 
$token = "FBzQZx8xlOAa+Y1Wug39X9eS5CeGrncZKaLXCejdlIMjjBdrxTivKW4z0gxqYKc4AJ0TbafGH3HblKsIQ0G/+esWfmj5dJVqyARzvvbx1aASiRQaxSD4jcyjs2vgO7MRUJ6Sx/9jCFQig/nc3omTwgdB04t89/1O/w1cDnyilFU="; //นำ token ที่มาจาก line developer account ของเรามาใส่ครับ
 
$httpClient = new CurlHTTPClient($token);
$bot = new LINEBot($httpClient, ['2f77160200bbb55edbe98b767f0ed52e' =&gt; $token]);
// webhook
$jsonStr = file_get_contents('php://input');
$jsonObj = json_decode($jsonStr);
print_r($jsonStr);
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			//source
     			$userId = $event['source']['userId'];

			// Get replyToken
			if ($receivetext == 'hello')
			{
				$replyToken = $event['replyToken'];
	   		$receivetext = $event['message']['text'];

      			$processtext = 'ว่าไงครับท่าน'."\n";
			$processtext .= 'ดีงับ';

		 	 // Build message to reply back
	    		$messages = [
	   		'type' => 'text',
	    		'text' => $processtext
	     		];
			$post = json_encode($data);	
			}else{
			$replyToken = $event['replyToken'];
	   		$receivetext = $event['message']['text'];

      			$processtext = 'ว่าไงครับท่าน'."\n";
			$processtext .= $receivetext;

		 	 // Build message to reply back
	    		$messages = [
	   		'type' => 'text',
	    		'text' => $processtext
	     		];

			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
			'replyToken' => $replyToken,
			'messages' => [$messages],
			];
			$post = json_encode($data);
			}
      
      $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $result = curl_exec($ch);
      curl_close($ch);

      echo $result . "\r\n";


    }
  }
}
echo "OK";

?>
