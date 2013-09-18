<?php
	$node=$_GET['nodeID'];
	$sessionID = $_GET['sessionID'];
	$timestep = $_GET['timestep'];
	$timestep2 = $timestep+1;
	#	echo $node;
	include 'settings.php';
	$link = mysqli_connect($dbHost,$dbUser,$dbPass, $dbName);

	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	if($_GET['type'] == 'agent'){
		  //Do something
#		  echo "id is ".substr($_GET['nodeID'],4);
			$sql="call copy_trust('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_beliefs('".$sessionID."',".$timestep.",".$timestep2.",-1,-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_question('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);
			mysqli_close($link);
			$script = "python addItems.py -s ".$sessionID . " -t ".$timestep2 . " -a ".$_GET['fromAgent'] . " -b ".$_GET['toAgent']. " -l ".$_GET['trust'];
			exec($script);
#			echo $script;			
                        if(!array_key_exists('headless', $_GET)){
                                header( 'Location: index.php?sessionID='.$sessionID.'&timestep='.$timestep2 );
                        }
 	}else if($_GET['type'] == 'fact'){
			$sql="call copy_trust('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_beliefs('".$sessionID."',".$timestep.",".$timestep2.",-1,-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_question('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);
			mysqli_close($link);
			$script = "python addItems.py -s ".$sessionID . " -t ".$timestep2 . " -a ".$_GET['agent'] . " -e \"".$_GET['belief']. "\" -l ".$_GET['trust'];
			$result = exec($script);
//			echo $script;
                        if(!array_key_exists('headless', $_GET)){
                                header( 'Location: index.php?sessionID='.$sessionID.'&timestep='.$timestep2 );
                        }
 	}else if($_GET['type'] == 'rule'){
			$sql="call copy_trust('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_beliefs('".$sessionID."',".$timestep.",".$timestep2.",-1,-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_question('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);
			mysqli_close($link);
			$script = "python addItems.py -s ".$sessionID . " -t ".$timestep2 . " -a ".$_GET['agent'] . " -c \"".$_GET['conclusion']. "\" -l ".$_GET['trust']. " -p \"".$_GET['premise']. "\"";
			$result = exec($script);
#			echo $script;			
                        if(!array_key_exists('headless', $_GET)){
                                header( 'Location: index.php?sessionID='.$sessionID.'&timestep='.$timestep2 );
                        }
 	}else if($_GET['type'] == 'question'){
			$sql="call copy_trust('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_beliefs('".$sessionID."',".$timestep.",".$timestep2.",-1,-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$script = "python addItems.py -s ".$sessionID . " -t ".$timestep2 . " -a ".$_GET['agent'] . " -q \"".$_GET['question']."\"";
			$result = exec($script);
                        if(!array_key_exists('headless', $_GET)){
                                header( 'Location: index.php?sessionID='.$sessionID.'&timestep='.$timestep2 );
                        }
 	}else{
			mysqli_close($link);
			echo "in else";			
#			header( 'Location: index.php?sessionID='.$sessionID.'&timestep='.$timestep );
		
		
 	}

?>
