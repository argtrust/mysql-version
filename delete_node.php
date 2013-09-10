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
	if(substr($_GET['nodeID'],0,4) == 'fact'){
		  //Do something
#		  echo "id is ".substr($_GET['nodeID'],4);
			$sql="call copy_trust('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			if( !$result )
#    			    echo mysqli_error($link);
#			mysqli_free_result($result);

			$sql="call copy_beliefs('".$sessionID."',".$timestep.",".$timestep2.",".substr($_GET['nodeID'],4).",-1);";
#			echo $sql;
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

/*
			$sql="call copy_fact('".$sessionID."',".$timestep.",".$timestep2.",".substr($_GET['nodeID'],4).");";
//			$sql="call copy_fact('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
//			print_r($result);
#			mysqli_free_result($result);

			$sql="call copy_rules('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);
*/
			$sql="call copy_question('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);
			mysqli_close($link);
			if(!array_key_exists('headless', $_GET)){			
				header( 'Location: index.php?sessionID='.$sessionID.'&timestep='.$timestep2 );
			}
 	}else if(substr($_GET['nodeID'],0,5) == 'agent'){
 #			echo "" .substr($_GET['nodeID'],5);
			$sql="call copy_trust('".$sessionID."',".$timestep.",".$timestep2.",".substr($_GET['nodeID'],5).");";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_beliefs('".$sessionID."',".$timestep.",".$timestep2.",-1,".substr($_GET['nodeID'],5).");";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_question('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);
			mysqli_close($link);
			
			if(!array_key_exists('headless', $_GET)){			
				header( 'Location: index.php?sessionID='.$sessionID.'&timestep='.$timestep2 );
			}
 	}else if(substr($_GET['nodeID'],0,4) == 'rule'){
 #			echo "" .substr($_GET['nodeID'],5);
			$sql="call copy_trust('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_beliefs('".$sessionID."',".$timestep.",".$timestep2.",".substr($_GET['nodeID'],4).",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);

			$sql="call copy_question('".$sessionID."',".$timestep.",".$timestep2.",-1);";
 			$result=mysqli_query($link,$sql);
#			mysqli_free_result($result);
			mysqli_close($link);
			
			if(!array_key_exists('headless', $_GET)){
				header( 'Location: index.php?sessionID='.$sessionID.'&timestep='.$timestep2 );
			}
 	}else{
			mysqli_close($link);
			
			header( 'Location: index.php?sessionID='.$sessionID.'&timestep='.$timestep );
		
		
 	}

?>
