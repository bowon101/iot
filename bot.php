<?php
 require("pub.php");
 require("line.php");
 $access_token = 'FBzQZx8xlOAa+Y1Wug39X9eS5CeGrncZKaLXCejdlIMjjBdrxTivKW4z0gxqYKc4AJ0TbafGH3HblKsIQ0G/+esWfmj5dJVqyARzvvbx1aASiRQaxSD4jcyjs2vgO7MRUJ6Sx/9jCFQig/nc3omTwgdB04t89/1O/w1cDnyilFU=';    //PUT LINE token ID at "Channel access token (long-lived)" 

// Get POST body content
$content = file_get_contents('php://input');

// Parse JSON
$events = json_decode($content, true);

// Validate parsed JSON data
/*if (!is_null($events['ESP'])) {
   send_LINE($events['ESP']);
   echo "OK";
}*/

/*if (!is_null($events['events'])) {
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
 }*/
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
			
			$Topic = "NodeMCU1" ;
	   getMqttfromlineMsg($Topic,$text);

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

 echo "OK3";
?>
