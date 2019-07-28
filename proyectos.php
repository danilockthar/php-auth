<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    include_once 'dtb.inc.php';

      $id = $_POST['id'];

  $query= "SELECT * FROM proyectos WHERE id= ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();

    while($row = $result->fetch_all(MYSQLI_ASSOC)){

      $data = json_encode($row);
      echo $data;
      exit;
    }
