<?php
	$sessionID = $_GET['sessionID'];
	$timestep = $_GET['timestep'];
	$timestep2 = $timestep+1;
	#	echo $node;
	include 'settings.php';
	$link = mysqli_connect($dbHost,$dbUser,$dbPass, $dbName);

	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	if($_GET['type'] == 'trust'){
#		  echo "id is ".substr($_GET['toID'],5);
#		  echo "fromID is ".substr($_GET['fromID'],5);
		  $updatedLevel = $_GET['level']/100;
#		  echo "level is ".$updatedLevel;
		  $sql = "
		  update agent_trust
		  set level = ".$updatedLevel."
		  where trustingAgent = ".substr($_GET['fromID'],5)."
		  and trustedAgent = ".substr($_GET['toID'],5)."
		  and sessionID = '".$sessionID."'
		  and timestep = ".$timestep.";
		  ";
          $result=mysqli_query($link,$sql);
#          echo $sql;
		  echo "Finished updating level to ".$_GET['level'].".";
    }
	else if($_GET['type'] == 'fact'){
#		  echo "agentid is ".substr($_GET['agentID'],5);
#		  echo "factid is ".substr($_GET['factID'],4);
		  $updatedLevel = $_GET['level']/100;
#		  echo "level is ".$updatedLevel;
		  $sql = "
		  update agent_has_beliefs
		  set level = ".$updatedLevel."
		  where agentID = ".substr($_GET['agentID'],5)."
		  and beliefID = ".substr($_GET['factID'],4)."
		  and sessionID = '".$sessionID."'
		  and timestep = ".$timestep."
		  and isInferred = 0
		  ";
          $result=mysqli_query($link,$sql);
#          echo $sql;
		  echo "Finished updating level to ".$_GET['level'].".";
    }

    ?>