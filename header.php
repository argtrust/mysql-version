<?php
putenv('PATH=/usr/local/bin:');
include 'settings.php';
$link = mysqli_connect($dbHost,$dbUser,$dbPass, $dbName);
if (!$link) {
	die('Could not connect: ' . mysql_error());
}

//$command = "sh runTrust.sh ". $_GET['xmlfile']." ". $_GET['outputfile'];
if(array_key_exists('xmlfile', $_GET)){
	$graphType = 'default';
	$sessionID=exec("python testZML_C.py -i ".$_GET['xmlfile'] ."");
//	$sessionID2=exec("/usr/bin/python2.7 --version 2>&1");
//	echo "Session ID: (";
//	echo $sessionID;
//	echo $sessionID2;
//	echo ") END";
	$timestep=1;
	ob_start();
	include 'datagen_db.php';
	$contents = ob_get_contents();
	ob_end_clean();
	$fp = file_put_contents("graphs2/".$sessionID.".debug",$contents);

	ob_start();
	include 'dotgen_hw.php';
	$contents = ob_get_contents();
	ob_end_clean();
	$fp = file_put_contents("graphs2/".$sessionID.".dot",$contents);
//	$output = exec("/usr/local/bin/dot graphs2/".$sessionID.".dot -Txdot -o graphs2/".$sessionID.".gv 2>&1");
	$output = exec("dot graphs2/".$sessionID.".dot -Txdot -o graphs2/".$sessionID.".gv");
//	echo $output;
//	break;
}else if(array_key_exists('sessionID', $_GET)){
	$sessionID=$_GET['sessionID'];
	$timestep=$_GET['timestep'];
	$graphType = 'anythingelse';

	$contents = file_get_contents("graphs2/".$sessionID.".vars");
	$store = unserialize($contents);
	// TODO: look at issues with extract - is it bad to use extract?
	extract($store);

	if(array_key_exists('beliefID', $_GET)){
		$beliefID=$_GET['beliefID'];
		ob_start();
		include 'dotgen_observed.php';
		$contents = ob_get_contents();
		ob_end_clean();
	}else if(array_key_exists('ruleID', $_GET)){
		$ruleID=$_GET['ruleID'];
		ob_start();
		include 'dotgen_inferred.php';
		$contents = ob_get_contents();
		ob_end_clean();
	}else if(array_key_exists('agentID', $_GET)){
		$agentID=$_GET['agentID'];
		ob_start();
		include 'dotgen_agent.php';
		$contents = ob_get_contents();
		ob_end_clean();
	}else if(array_key_exists('argumentID', $_GET)){
		$argumentID=$_GET['argumentID'];
		ob_start();
		include 'dotgen_argument.php';
		$contents = ob_get_contents();
		ob_end_clean();
	}else{
		exec("python testZML_C.py -s ".$sessionID . " -t ".$timestep);
	//	echo "python testZML_A.py -s ".$sessionID . " -t ".$timestep;

		ob_start();
		include 'datagen_db.php';
		$contents = ob_get_contents();
		ob_end_clean();
		$fp = file_put_contents("graphs2/".$sessionID.".debug",$contents);

		ob_start();
		include 'dotgen_hw.php';
		$contents = ob_get_contents();
		ob_end_clean();
	}
	$fp = file_put_contents("graphs2/".$sessionID.".dot",$contents);
	$output = exec("dot graphs2/".$sessionID.".dot -Txdot -o graphs2/".$sessionID.".gv");	
}else{
//	echo "Upload a file on the right side";
	$sessionID = "";
	$timestep = 1;
}
?>
