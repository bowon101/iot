<?php
 require("pub.php");
 require("line.php");

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
			$access_token = 'FBzQZx8xlOAa+Y1Wug39X9eS5CeGrncZKaLXCejdlIMjjBdrxTivKW4z0gxqYKc4AJ0TbafGH3HblKsIQ0G/+esWfmj5dJVqyARzvvbx1aASiRQaxSD4jcyjs2vgO7MRUJ6Sx/9jCFQig/nc3omTwgdB04t89/1O/w1cDnyilFU='; 

  $messages = [
        'type' => 'text',
        'text' => $msg
        //'text' => $text
      ];

      // Make a POST Request to Messaging API to reply to sender
      $url = 'https://api.line.me/v2/bot/message/push';
      $data = [

        'to' => 'U70da6a9e9f798d5c0bbf9e8cdbf3ed3c',
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
 
			// Build message to reply back

			$Topic = "NodeMCU1" ;
			getMqttfromlineMsg($Topic,$text);
			   
			
		}
	}
}
$Topic = "NodeMCU1" ;
$text = "Test";
getMqttfromlineMsg($Topic,$text);
echo "OK3";
?>
