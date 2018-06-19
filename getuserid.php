<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


$mob = $_GET['mob'];


$query="";

/*   May 1 2017 - next 4 lines needed for localhost so commented for Heroku
$link = mysqli_connect("localhost","root","hariom","test");
    if (mysqli_connect_error()){
        die( "Connection error");
        }
        */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
 
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
 
//$conn = new mysqli($server, $username, $password, $db);
$link = mysqli_connect($server, $username, $password, $db);
if (mysqli_connect_error()){
        die( "Connection error");
        }
    
            $rtn = mysqli_fetch_assoc(mysqli_query($link,"SELECT `Id` from patients WHERE `Mobile`=$mob"));
            $id = $rtn['Id'];
            echo $id;
mysqli_close($link);  
  
?>