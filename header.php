<?php
//putenv('PATH=/usr/local/bin:');
include 'settings.php';
$link = mysqli_connect($dbHost,$dbUser,$dbPass, $dbName);
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
if(!array_key_exists('graphDetail', $_GET)){
	$graphDetail=0;		
}else{
	$graphDetail=$_GET['graphDetail'];
}
$graphType = 'default';

//$command = "sh runTrust.sh ". $_GET['xmlfile']." ". $_GET['outputfile'];
if(array_key_exists('xmlfile', $_GET)){
	if (isset($_COOKIE["userID"])){
		echo "james said so";
		echo "python testZML_C.py -i ".$_GET['xmlfile'] ." -u ".$_COOKIE['userID'];
		$sessionID=exec("python testZML_C.py -i ".$_GET['xmlfile'] ." -u ".$_COOKIE['userID']);
	}else{
		echo "james missed it so";
		$sessionID=exec("python testZML_C.py -i ".$_GET['xmlfile'] ."");		
	}
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
	include 'dotgen_high.php';
	$contents = ob_get_contents();
	ob_end_clean();
	$fp = file_put_contents("graphs2/".$sessionID.".dot",$contents);
	$output = exec("dot graphs2/".$sessionID.".dot -Txdot -o graphs2/".$sessionID.".gv");
}else if(array_key_exists('sessionID', $_GET)){
	$sessionID=$_GET['sessionID'];
	$timestep=$_GET['timestep'];

	$contents = file_get_contents("graphs2/".$sessionID.".vars");
	$store = unserialize($contents);
	// TODO: look at issues with extract - is it bad to use extract?
	extract($store);

	//FOCUS is 'belief' DETAIL can be 'default' or 'low-level' 
	if(array_key_exists('beliefID', $_GET)){
		$graphType = 'belief';
		$beliefID=$_GET['beliefID'];
		$graphDetail=$_GET['graphDetail'];
		ob_start();
		if($graphDetail=='2'){
			//include 'belief_low.php';
		} else {
			include 'dotgen_observed.php';
		}
		$contents = ob_get_contents();
		ob_end_clean();
	//FOCUS is 'rule' DETAIL only 'expert'
	}else if(array_key_exists('ruleID', $_GET)){
		$graphType = 'rule';
		$ruleID=$_GET['ruleID'];
		ob_start();
		include 'dotgen_inferred.php';
		$contents = ob_get_contents();
		ob_end_clean();
	//FOCUS is 'agent' DETAIL can be 'expert', 'low-level', or 'mid-level'	
	}else if(array_key_exists('agentID', $_GET)){
		$graphType = 'agent';
		$agentID=$_GET['agentID'];
		ob_start();
		/*if($graphDetail=='2'){
			include 'agent_low.php';
		} else if($graphDetail=='1') { 
			include 'agent_mid.php';
		} else {*/
			include 'dotgen_agent.php';
		//}
		$contents = ob_get_contents();
		ob_end_clean();
	//FOCUS is 'argument' DETAIL can be 'expert', 'low-level', 'mid-level' or 'high-level'	
	}else if(array_key_exists('argumentID', $_GET)){
		$graphType = 'argument';
		$argumentID=$_GET['argumentID'];
		$graphDetail=$_GET['graphDetail'];
		ob_start();
		if($graphDetail=='0'){
			include 'dotgen_argument_high.php';
		} else if($graphDetail=='1') { 
			include 'dotgen_argument_mid.php';
		} else if($graphDetail=='2') { 
			include 'dotgen_argument_low.php';	
		} else {
			include 'dotgen_argument.php';
		}
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
		if($graphDetail=='0'){
			include 'dotgen_high.php';
		}else if($graphDetail=='1'){
			include 'dotgen_mid.php';
		}else if($graphDetail=='2'){
			include 'dotgen_low.php';
		} else { 
			include 'dotgen_hw.php';
		}
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
