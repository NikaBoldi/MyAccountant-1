<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
 
  require "dbconnect.php";

$data = file_get_contents("php://input");
    if (isset($data)) {
        $request = json_decode($data);
		$login = $request->login;
		$password = $request->password;
		$pays = $request->pays;
		$profession= $request->profession;
		$revenus_mesuels = $request->revenus_mesuels;
        $plafond = $request->plafond;
        
	}
	
        $login = stripslashes($login);
		$password =stripslashes($password);
		$pays =stripslashes($pays);
		$profession= stripslashes($profession);
		$revenus_mesuels = stripslashes($revenus_mesuels);
        $plafond = stripslashes($plafond);
  $sql = "SELECT id FROM users login = '$login' ";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);      
      $count = mysqli_num_rows($result);		
      if($count == 0) {
	      $sql = "INSERT INTO users (login, password, pays, profession, revenu_mens, plafond )
          VALUES ('$login','$password','$pays','$profession','$revenus_mesuels','$plafond')";
          if ($con->query($sqli) == TRUE) {
	      $response= "Registration successfull";
   
          } else {
            $response= "Error: " . $sqli . "<br>" . $con->error;
            }
    
      }else {
      
		 $response= "Already exist";
      }
 	 
	echo json_encode( $response); 
?>


-