<div id="wrapper">
	
  <div id="tabContainer">
    <div id="tabs">
      <ul>
        <li id="tabHeader_1">Focus</li>
        <li id="tabHeader_2">Set-Up</li>
        <li id="tabHeader_3">Graph Key</li>
        <li id="tabHeader_4">Help</li>
      </ul>
    </div>
    <div id="tabscontent">

      <div class="tabpage" id="tabpage_1">
        <form name="focus">
        <br>
		<table>
			<tr>
				<td><h3>Default:</td>
				<td><p><input type="radio" name="focus" value="outcome1" onClick="updategraph('default',0,<?php if(array_key_exists('graphDetail', $_GET)) {echo $_GET['graphDetail'];}else{echo 0;}?>)" 
					<?php
						if($graphType == 'default'){
							echo "checked";
						}
					?>
					> Scenario Overview</td>
			</tr>
			<tr>
				<td><h3>Outcomes:</h3></td>
				<td></td>
			</tr>
<?php
$sql = "select pa.parentArgumentID, pa.level, pa.status, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate
from parent_argument pa
inner join arguments a on a.argumentID = pa.argumentID and a.timestep = pa.timestep and pa.sessionID = a.sessionID
inner join beliefs b on b.beliefID = a.beliefID
inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
inner join predicates p on p.predicateID = pc.predicateID
inner join constants c on pc.constantID = c.constantID 
where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep." and a.isSupported = 1;";
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	?>
			<tr>
				<td></td>
				<td><input type="radio" name="focus" value="outcome" onClick="updategraph('argument',<?php echo $row[0]; ?>, 
          <?php if(array_key_exists('graphDetail', $_GET)) {echo $_GET['graphDetail'];}else{echo 0;}?>)" 
          <?php if((array_key_exists('argumentID', $_GET))&&($row[0]==$_GET['argumentID'])) {?> checked <?php }?>> 
          <?php echo $row[3]; ?>: <?php echo $row[1]; ?></input></td>
			</tr>		
	<?php
  }
}
mysqli_free_result($result);
?>
<!--				<tr>
					<td><h3>Conflicts:</td>
					<td></td>
				</tr>
<?php
$sql = "select paa.fromParentArgID, paa.toParentArgID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate,
        CASE               
        WHEN b2.isNegated=1 THEN concat('NOT(',p2.name,'(',c2.name,'))') 
        ELSE concat(p2.name,'(',c2.name,')') END predicate2
from parent_argument pa
inner join arguments a on a.argumentID = pa.argumentID and a.timestep = pa.timestep and pa.sessionID = a.sessionID
inner join beliefs b on b.beliefID = a.beliefID
inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
inner join predicates p on p.predicateID = pc.predicateID
inner join constants c on pc.constantID = c.constantID 
inner join parent_argument_attacks_argument paa on paa.fromParentArgID = pa.parentArgumentID
inner join parent_argument pa2 on paa.toParentArgID = pa2.parentArgumentID
inner join arguments a2 on a2.argumentID = pa2.argumentID and a2.timestep = pa2.timestep and pa2.sessionID = a2.sessionID
inner join beliefs b2 on b2.beliefID = a2.beliefID
inner join predicate_has_constant pc2 on pc2.predicateConstantID = b2.conclusionID
inner join predicates p2 on p2.predicateID = pc2.predicateID
inner join constants c2 on pc2.constantID = c2.constantID 
where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep." and a.isSupported = 1 and paa.isIncluded = 1;";
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	?>
			<tr>
				<td></td>
				<td><input type="radio" name="focus" value="outcome" onClick="updategraph('attack',<?php echo $row[0]; ?>,<?php echo $row[1]; ?>)"> <?php echo $row[2]; ?> | <?php echo $row[3]; ?></td>
			</tr>		
	<?php
  }
}
mysqli_free_result($result);
?> -->
<!--				<tr>
					<td><h3>Agents:</h3></td>
					<td></td>
				</tr>
<?php

	
$sql="call getAgents('".$sessionID."', ".$timestep.");";
if (mysqli_multi_query($link,$sql)) {
    do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
            while ($row = mysqli_fetch_array($result)) {
            	if(array_key_exists('agentID', $_GET)){
            		if($row[0] == $_GET['agentID']){
            			$status = " checked ";
						
            		}else{
		      			$status = "";					
            		}					
            	}
				
  	?> 
				<tr>
					<td></td>
					<td><input type="radio" name="focus" value="<?php echo $row[1]; ?>" onClick="updategraph('agent',<?php echo $row[0]; ?>)" <?php echo $status; ?>> <?php echo $row[1]; ?></td>
				</tr>  	
  	<?php
            }
            $result->free();
        }
    } while (mysqli_next_result($link));
}else{
	echo "error running agents query";
	
}

?> -->
<?php if ($graphDetail > 1){ ?>
				<tr>
					<td width="30%"><h3> Observed Knowledge:</td>
					<td valign="bottom"></td>
				</tr>
<?php

	
$sql="call getFacts('".$sessionID."', ".$timestep.",1,0);";
if (mysqli_multi_query($link,$sql)) {
    do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
            while ($row = mysqli_fetch_array($result)) {
  	?>
				<tr>
					<td></td>
					<td><input type="radio" name="focus" value="<?php echo $row[1]; ?>" onClick="updategraph('belief',<?php echo $row[0]; ?>,3)" 
          <?php if((array_key_exists('beliefID', $_GET))&&($row[0]==$_GET['beliefID'])) {?> checked <?php }?>> 
          <?php echo $row[1]; ?></input></td>				
        </tr>  	
  	<?php
            }
            $result->free();
        }
    } while (mysqli_next_result($link));
}else{
	echo "error running agents query";
	
}
}//close if statement
if ($graphDetail > 2){ 

?>
				<tr>
					<td width="30%"><h3>Inferred Knowledge:</td>
					<td valign="bottom"></td>
				</tr>
<?php

	
$sql="call getRules('".$sessionID."', ".$timestep.",1,0);";
if (mysqli_multi_query($link,$sql)) {
    do {
        /* store first result set */
        if ($result = mysqli_store_result($link)) {
            while ($row = mysqli_fetch_array($result)) {
  	?>
				<tr>
					<td></td>
          <td><input type="radio" name="focus" value="<?php echo $row[1]; ?>" onClick="updategraph('rule',<?php echo $row[0]; ?>,3)" 
          <?php if((array_key_exists('ruleID', $_GET))&&($row[0]==$_GET['ruleID'])) {?> checked <?php }?>> 
          <?php echo $row[1]; ?></input></td>       
				</tr>  	
  	<?php
            }
            $result->free();
        }
    } while (mysqli_next_result($link));
}else{
	echo "error running agents query";
	
}
}//close if statement
?>
			</table><br><br>
			</form>
      </div>
      <div class="tabpage" id="tabpage_2">
      		<form action="upload.php" method="post" enctype="multipart/form-data">
			<label for="file">Filename:</label>
			<input type="file" name="file" id="file"><br>
      <input type="text" name="userid" id="userid"><br>
			<input type="submit" name="submit" value="Submit">
			</form>
      </div>

      	<div class="tabpage" id="tabpage_3">
      		<img src = "./images/graph_key2.png" alt = "Graph Key" style="max-width:100%; height:620px;"/>
        </div> 

       	<div class="tabpage" id="tabpage_4">
      			<br>ArgTrust is designed to assist you in analyzing complex situations. You can use this system to diagram complex situations, 
      			compare different possible outcomes of a situation and break them down into their individual parts.<br><br><br> 
      			<b>What do the graphs mean?</b><br><br>
      			 Each graph is a visual representation of the scenario including who you know, what you know and all possible outcomes. <br><br>
      			 Each node represents a different agent, piece of information, rule or conclusion. The arrows represent relationships between agents and
      			    information.Click on the Graph Key tab to see what things means!<br><br><br>
      			<b>Why are there different graphs?</b><br><br>
      			 Choosing different options in the Focus tab allows you to zoom in on different aspects of the scenario and break down the situation into 
      			    it's individual parts. The different graphs represent the same information but focus on different relationships, outcomes and kinds 
      			    of knowledge.<br>
        		</div>
    	</div>
  </div>
