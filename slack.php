<?php

/**
 * Funkcja wysyłająca wiadomość na Slacka
 */
function sendToSlack($channel, $username, $msg, $icon)
{
	$msg = str_replace("+", "\u002b", $msg);    //poprawne wyświetlanie znaku +
	$msg = str_replace("\"", "\u0022", $msg);   //poprawne wyświetlanie znaku "
	$url = SLACK_WEBHOOK;
	$useragent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
	$payload = 'payload={
		"channel": "' . $channel . '", 
		"username": "' . $username . '", 
		"text": "' . $msg . '", 
		"icon_emoji": "' . $icon . '"}';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent); 
	curl_setopt($ch, CURLOPT_POST, TRUE); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); 
	
	curl_exec($ch); 
	curl_close($ch);
	echo "<br/>";
}

?>