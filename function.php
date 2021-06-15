<?php
function set_message($msg){

    if(!empty($msg)) {
    
    $_SESSION['message'] = $msg;
    
    } else {
    
    $msg = "";
    
    
        }
    
    
    }
    
    
    function display_message() {
    
        if(isset($_SESSION['message'])) {
    
            echo $_SESSION['message'];
            unset($_SESSION['message']);
    
        }
    
    
    
    }

    

function makeReservation(){
global $conn;
if(isset($_POST['submit'])){
$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$number=$_POST['number-guests'];
$date=$_POST['date'];
$time=$_POST['time'];
$message=$_POST['message'];
$query="INSERT INTO reserve (name, email, phone, number, date,time, message) VALUES ('{$name}','{$email}',{$phone},'{$number}','{$date}','{$time}','{$message}') ";
$result=mysqli_query($conn,$query);
header("location: index.php");
 
if(!$result){

    die("Error".mysqli_error($conn));
}

else{
    echo "No";
}

}


}

  

?>