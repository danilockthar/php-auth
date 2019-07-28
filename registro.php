<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
  include_once 'db.php';


$userName = $_POST['username'];
$userEmail = $_POST['useremail'];
$userPw = $_POST['userpw'];
$userHashPw = password_hash($userPw, PASSWORD_DEFAULT);

if(empty($userName) || empty($userEmail) || empty($userPw)){
  $msg = array(
    'msg' => 'Por favor rellene todos los campos'
  );
  $jsonmsg = json_encode($msg);
  echo $jsonmsg;
  exit();
  }else{
    if(filter_var($userEmail, FILTER_VALIDATE_EMAIL)){

      $query = "SELECT * FROM users WHERE useremail = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('s', $userEmail);
      $stmt->execute();
      $result = $stmt->get_result();
      if($row = $result->fetch_all(MYSQLI_ASSOC)){
        $msg = array(
          'msg' => 'Este mail ya está registrado',
          'exito' => false
        );
        $jsonmsg = json_encode($msg);
        echo $jsonmsg;
        exit();
      }else{
        $query = "INSERT INTO users (username, useremail, passw) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $userName, $userEmail, $userHashPw);
        $stmt->execute();
        $newUser = array();
        $newUser['username'] = $userName;
        $newUser['useremail'] = $userEmail;
        $newUser['userpw'] = $userHashPw;

        $msg = array(
          'msg' => 'Se ha registrado con exito!',
          'user' => $newUser,
          'exito' => true
        );
        $jsonmsg = json_encode($msg);
        echo $jsonmsg;
        exit();
      }
    }else{
      $msg = array(
        'msg' => 'Por favor ingrese un email valido',
        'exito' => false
      );
      $jsonmsg = json_encode($msg);
      echo $jsonmsg;
      exit();
    }
}
