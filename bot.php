<?php
 require("pub.php");
 require("line.php");
 $access_token = 'FBzQZx8xlOAa+Y1Wug39X9eS5CeGrncZKaLXCejdlIMjjBdrxTivKW4z0gxqYKc4AJ0TbafGH3HblKsIQ0G/+esWfmj5dJVqyARzvvbx1aASiRQaxSD4jcyjs2vgO7MRUJ6Sx/9jCFQig/nc3omTwgdB04t89/1O/w1cDnyilFU=';    //PUT LINE token ID at "Channel access token (long-lived)" 
function pubMqtt($topic,$msg) {
    $APPID= "JARVIS/";      //PUT NETPIE APPID Name end with "/"
    $KEY = "B4nf5meVFnvLVDS";          //PUT NETPIE Key ID
    $SECRET = "SvCxt7YSA18JrCekOcFGCaGIB";   //PUT NETPIE Secret ID 
    $Topic = "$topic";
  
    put("https://api.netpie.io/microgear/".$APPID.$Topic."?retain&auth=".$KEY.":".$SECRET,$msg);
  }

 function getMqttfromlineMsg($Topic,$lineMsg) {
    $pos = strpos($lineMsg, ":");
    if($pos) {
      $splitMsg = explode(":", $lineMsg);
      $topic = $splitMsg[0];
      $msg = $splitMsg[1];
      pubMqtt($topic,$msg);
    }
    else {
      $topic = $Topic;
      $msg = $lineMsg;
      pubMqtt($topic,$msg);
    }
  }
 
  function put($url,$tmsg) {
     $ch = curl_init($url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
     curl_setopt($ch, CURLOPT_POSTFIELDS, $tmsg);
     
     $response = curl_exec($ch);
     curl_close($ch);
     echo $response . "\r\n";
    return $response;
  }
function send_LINE($msg){
 //$access_token = 'FBzQZx8xlOAa+Y1Wug39X9eS5CeGrncZKaLXCejdlIMjjBdrxTivKW4z0gxqYKc4AJ0TbafGH3HblKsIQ0G/+esWfmj5dJVqyARzvvbx1aASiRQaxSD4jcyjs2vgO7MRUJ6Sx/9jCFQig/nc3omTwgdB04t89/1O/w1cDnyilFU=';    //PUT LINE token ID at "Channel access token (long-lived)" 
 $messages = [
        'type' => 'text',
        'text' => $msg
      ];

      // Make a POST Request to Messaging API to reply to sender
      $url = 'https://api.line.me/v2/bot/message/push';
      $data = [
        'to' => 'U70da6a9e9f798d5c0bbf9e8cdbf3ed3c',         //PUT LINE ID at "Your user ID"
        'messages' => [$messages],
      ];
      $post = json_encode($data);
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

// Get POST body content
$content = file_get_contents('php://input');

// Parse JSON
$events = json_decode($content, true);

// Validate parsed JSON data
if (!is_null($events['ESP'])) {
   send_LINE($events['ESP']);
   
   echo "OK";
}

if (!is_null($events['events'])) {
   echo "line bot";
   // Loop through each event
   foreach ($events['events'] as $event) {
	// Reply only when message sent is in 'text' format
	if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
	   // Get text sent
	   $text = $event['message']['text'];
	   // Get replyToken
	   $replyToken = $event['replyToken'];
  	   // Build message to reply back
           $Topic = "NodeMCU1" ;
	   getMqttfromlineMsg($Topic,$text);
	}
    }
 }
 /*if (!is_null($events['events'])) {
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
	$Topic = "NodeMCU1" ;
	   getMqttfromlineMsg($Topic,$text);

    }
  }
}*/

 echo "OK3";
?>
