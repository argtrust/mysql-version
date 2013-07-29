<?php
include 'settings.php';
// #$link = mysqli_connect('jsalvitdbinstance.cku3opv9prdt.us-east-1.rds.amazonaws.com','trust_user','trust123', 'trust');
$link = mysqli_connect($dbHost,$dbUser,$dbPass, $dbName);
// #$link = mysqli_connect('127.0.0.1','root','', 'trust');
if (!$link) {
        die('Could not connect: ' . mysql_error());
}

if(array_key_exists('sessionID', $_GET) && array_key_exists('timestep', $_GET)){
        $timestep=$_GET['timestep'];
        $sessionID=$_GET['sessionID'];
}else if(array_key_exists('sessionID', $_GET)){
        $timestep=1;
        $sessionID=$_GET['sessionID'];
}else{
	echo "error";
}

ob_start();
include 'datagen_db.php';
$contents = ob_get_contents();
ob_end_clean();
$fp = file_put_contents("graphs2/".$sessionID.".debug",$contents);
include 'xmlgen.php';

?>