<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
$userData = array(
  'user_name' => 'danilockthar',
   'id' => 1,
   'rol' => 'admin'
);


function tokenizar($userInfo){


  $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
  $headerbase64 = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

  $payload = json_encode($userInfo);
  $payloadbase64 = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

  $signature = hash_hmac('sha256', $headerbase64 . "." . $payloadbase64, 'daniphp', true);

  $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

  $jwt = $headerbase64 . "." . $payloadbase64 . "." . $base64UrlSignature;

  return $jwt;
}








 ?>
