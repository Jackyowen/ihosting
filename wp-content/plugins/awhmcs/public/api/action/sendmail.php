<?php 

	$to = "duongtuyen.t1@gmail.com";
	$subject = $data['inputSubject'];
	$inputMessage = $data['inputMessage'];
	$headers = "From: ".$data['inputEmail'] . "\r\n" .

	mail($to,$subject,$inputMessage,$headers);