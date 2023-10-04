<?php 
require_once('./classes/connect_pdo_emp.php');
$pdoConnect = new connect_pdo();
$db = $pdoConnect->connectToDB();
$todayNow = date('Y-m-d H:i:s');
   
    $boolean = true;
    $email = trim($_POST["email"]);
      
    
    if(!preg_match("/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,})$/",$email)){
        $emailError = "Please enter valid email";
        $boolean = false;
    }
   


    if($boolean == true){

        $insert_query = $db->prepare("insert into khabarnewindia_subscribe_details(email,status,created) values (:email,:st,:date)");

        
                    
        $params = array("email" => $email,"st" => 1,"date" => $todayNow);

        $data = $insert_query->execute($params);

        $lastId = $db->lastInsertId();

        $toEmail = "khabarnewindia@gmail.com";
        $message="New Subscriber";
        $subject = "This is Email Subject";
        $mailheader .= "Reply-To: ".$_POST["email"]."\r\n";
        
       
        

        if($lastId>0){

           
            if(mail($toEmail, $subject, $message,$mailHeaders)) {
                
                $msg="Thank you for Subscribing us.";
                
                
            } else {
                $msg="An error occured, Please try after sometime.";
            } 
        }
        
    }


?>