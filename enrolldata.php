<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

/*$id      = $_POST['id'];
$dt = $_POST['dt'];
$sys = $_POST['sys'];
$dia = $_POST['dia'];
$sugar = $_POST['sugar'];
$temp = $_POST['temp'];
*/
$name = $_GET['name'];
$addr = $_GET['addr'];
$mob = $_GET['mob'];
$ed = $_GET['ed'];
$uid = $_GET['uid'];
$pwd = $_GET['pwd'];

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



    $query1 = "INSERT INTO patients (`Name`,`Address`,`Mobile`,`Enrolldate`) 
        VALUES ($name, $addr,$mob, $ed);"; 
    //echo $query;
    $result1= mysqli_query($link,$query1);
    $enpwd = md5($pwd);
    $query2 = "INSERT INTO users (`Userid`,`Password`,`Role`,`Mobile`) 
        VALUES ($uid, '$enpwd','P',$mob);"; 
        $result2= mysqli_query($link,$query2);

    if ($result1 AND $result2){

        //echo "Query was successful";
       
            //echo 1;
        
         $rtn = mysqli_fetch_assoc(mysqli_query($link,"SELECT `Id` from patients WHERE `Mobile`=$mob"));
         
            $id = $rtn['Id'];
            echo $id;
           }    
 else  {
        echo -1; 
    }
    mysqli_close($link);

?>