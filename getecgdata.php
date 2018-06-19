<?php header('Access-Control-Allow-Origin: *');

$id      = $_GET['id'];

//   May 1 2017 - next 4 lines needed for localhost so commented for Heroku
/*
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


$rtn = mysqli_fetch_assoc(mysqli_query($link,"SELECT max(`yr`) as tmp from ecgdata WHERE `patid`=$id"));
$yr = $rtn['tmp'];
//echo $yr;

$rtn = mysqli_fetch_assoc(mysqli_query($link,"SELECT max(`mon`) as tmp from ecgdata WHERE `patid`=$id AND `yr` = $yr"));
$mnth = $rtn['tmp'];
//echo $mnth;

$rtn = mysqli_fetch_assoc(mysqli_query($link,"SELECT max(`day`) as tmp from ecgdata WHERE `patid`=$id AND `yr` = $yr AND `mon` = $mnth"));
$day = $rtn['tmp'];
//echo $day;

	
	
    $query = "SELECT `millis`,`value` from ecgdata WHERE `patid`=$id AND `yr` = $yr AND `mon` = $mnth AND day=$day";
    if ($result = mysqli_query($link,$query)) {

        //echo "Query was successful";
        $rowcount=mysqli_num_rows($result);
        $data = array();
        if ($rowcount > 0){
            
            while ($arr = mysqli_fetch_row($result)) {
                $data[] = $arr;
            }
           // while ($row = mysqli_fetch_array($result)){
                
            //print_r($row);
            // echo "<p> Patient Name is".$row['name']."</p>";   //works Apr 23 2017
            //echo $row['systolic'].$row['diastolic'].$row['sugar'].$row['temp'];   //works Apr 24 2017
            //echo $data;
            $json = json_encode($data);
            
             }
        //mysql_close($link);
			echo $json;
		
    }
      else  {
        echo -1;  //does not work Apr 23 2017
    }
    

?>