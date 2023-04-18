<?php 
// DB credentials.
	//include '../config.php';
	include ("dbconnect.php");
if ($conn) {
}

else{


	echo "Service temporarily unavailable, please try again later!";
}

    include_once 'menu.php';
    //set isUserRegistered flag to true
    $isUserRegistered = true;
    //Read the data sent via POST from our AT API
    $sessionId   = $_POST["sessionId"];
    $serviceCode = $_POST["serviceCode"];
    $phoneNumber = $_POST["phoneNumber"];
    $text        = $_POST["text"];

	 $menu = new Menu();
    if($text == "" ){
         //user is registered and string is is empty
          include 'dbconnect.php';            
            $user = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber' ";
            $result2 = $conn->query($user);
            if ($result2->num_rows > 0) {
                $isUserRegistered  = 0;
        echo "CON ". $menu->mainMenuRegistered($phoneNumber);
    }else {
        $isUserRegistered  = 1;
        $menu->mainMenuUnRegistered($phoneNumber);
    }
    
    
    }else {
        include 'dbconnect.php';            
            $user = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber' ";
            $result2 = $conn->query($user);
            if ($result2->num_rows == 0) {
            $isUserRegistered  = 1;
        //user is unregistered and string is not empty
        $textArray = explode("*", $text);
        switch($textArray[0]){
            case 1: 
                $menu->registerMenu($textArray, $phoneNumber);
            break;
            default:
                echo "END Invalid choice. Please try again";
        }
    }else {
        //user is registered and string is not empty
        $textArray = explode("*", $text);
        switch($textArray[0]){
            case 1: 
                $menu->sendMoneyMenu($textArray,$phoneNumber);
            break;
            case 2: 
                $menu->checkBalanceMenu($textArray,$phoneNumber);
            break;
            case 3:
                $menu->setting($textArray,$phoneNumber);
            break;
            default:
                echo "END Inavalid menu\n";
        }
    }
    
    }
    
?>