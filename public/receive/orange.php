<?php
$message ="bonjour";
$senderAddress ="tel+21654614211";
$receiverAddress = "tel+216555555";

	$fields = array (
  'outboundSMSMessageRequest' => 
  array (
    'address' => $receiverAddress,
    'outboundSMSTextMessage' => 
    array (
      'message' => $message,
    ),
    'senderAddress' => $SenderAddress,
    'senderName' => 'Agent',
  ),
)
	
	
	
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic U0cwUE1aeGZmZ0JLbUkzWUV2ZWlsM0xBdEt0UVZ4Q1k6SVRqWXQxRU5nWlV4SGM5OQ=='));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
?>