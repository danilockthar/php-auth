<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
  include_once 'db.php';
  include_once 'token.php';


  $userEmail = $_POST['useremail'];
  $userPassword = $_POST['userpw'];

  if(empty($userEmail) || empty($userPassword)){
    $msg = array(
      'msg' => 'Por favor rellene todos los campos'
    );
    $jsonmsg = json_encode($msg);
    echo $jsonmsg;
    exit();
  }else{
    $query = "SELECT * FROM users WHERE useremail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_all(MYSQLI_ASSOC)){
      if(password_verify($userPassword, $row[0]['passw'])){
        $userCredentials = array(
          'id' => $row[0]['id'],
          'username' => $row[0]['username'],
          'useremail' => $row[0]['useremail'],
          'isAdmin' => true
        );

        $jwt = tokenizar($userCredentials);
        $creds = array(
          'token' => $jwt,
          'msg' => 'Haz logueado con exito'
        );
        $newCreds = json_encode($creds);
        echo $newCreds;
        exit();
      }else{
        $creds = array(
          'msg' => 'Email o contraseña incorrecta'
        );
        $newCreds = json_encode($creds);
        echo $newCreds;
        exit();
      }
    }else{
      $msg = array(
        'msg' => 'Email o contraseña incorrecta'
      );
      $jsonmsg = json_encode($msg);
      echo $jsonmsg;
      exit();
    }
  }
?>
