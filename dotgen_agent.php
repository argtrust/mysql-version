digraph g {
	graph [size="5,5", ratio=fill, overlap=false, splines=true, margin=".10"];
	node [label="\N"];
	graph [bb="0 0 3000 3000"];	
	subgraph cluster_trust_net {
		graph [bb=""];
		node [shape=circle,
			style=filled,
			fillcolor=lavender,
			fontname=arial];
		edge [color=blue];
		subgraph cluster_0 {
			graph [style="rounded,filled",
				fillcolor=whitesmoke];
<?php
	//Inner graph
/*
* Create agents nodes
*/
 $sql="SELECT DISTINCT agentID, agentName FROM agents 
 		INNER JOIN agent_trust on (trustingAgent = agentID or trustedAgent = agentID) 
 		where sessionID = '".$sessionID."' and timestep=".$timestep." and agentID=".$agentID;
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("agent%s [label=%s, fontsize=35, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);

/*
* Create rule nodes that aren't argument ends
*/
$sql =" select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported and ab.agentID = q.agentID
	    inner join parent_argument_has_argument paa on paa.argumentID=a.argumentID
	    inner join (select pa.parentArgumentID
	                from parent_argument pa
	                inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
	                inner join arguments a on a.argumentID = paa.argumentID and a.sessionID = pa.sessionID and a.timestep = pa.timestep
	                inner join beliefs b on b.beliefID = a.beliefID
	                inner join agent_has_beliefs ab on ab.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep = a.timestep
	                where ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep." and ab.agentID=".$agentID."
	    ) ij on ij.parentArgumentID = paa.parentArgumentID
	    where b.isRule = 1 and a.isSupported=1	and b.beliefID NOT IN (select distinct b.beliefID 
							from arguments a 
							inner join beliefs b on b.beliefID = a.beliefID 
							inner join parent_argument pa on pa.argumentID = a.argumentID 
										and pa.sessionID = a.sessionID 
										and pa.timestep = a.timestep 
							where a.sessionID = '".$sessionID."' and a.timestep=".$timestep.");";
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	$sql="select CASE 
        WHEN isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate
		from belief_has_premises b
		inner join predicate_has_constant pc on pc.predicateConstantID = b.premiseID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		where beliefID = ".$row[0].";";
  	$return=mysqli_query($link,$sql);
  	$premise='';
  	$count=0;
  	while($innerrow = mysqli_fetch_array($return)) {
  		if($count > 0){ 
  			$premise .= ", ";}
  		$premise .= $innerrow[0];	
  		$count++;
  	}
  	mysqli_free_result($return);
  	printf ("rule%s [label=\"%s :- %s:%s\", shape=box3d,  fontsize=35, fillcolor=lightblue, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$premise,$row[2]);
  	printf ("inference%s [label=\"%s\", shape=box,  fontsize=35, fillcolor=lightcyan, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
	printf ("rule%s -> inference%s [color=darkgreen,  fontsize=35, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[0]);
  }
}
mysqli_free_result($result);

/*
* Create fact nodes that aren't argument ends
*/
$sql =" select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported and ab.agentID = q.agentID
	    inner join parent_argument_has_argument paa on paa.argumentID=a.argumentID
	    inner join (select pa.parentArgumentID
	                from parent_argument pa
	                inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
	                inner join arguments a on a.argumentID = paa.argumentID and a.sessionID = pa.sessionID and a.timestep = pa.timestep
	                inner join beliefs b on b.beliefID = a.beliefID
	                inner join agent_has_beliefs ab on ab.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep = a.timestep
	                where ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep." and ab.agentID=".$agentID."
	    ) ij on ij.parentArgumentID = paa.parentArgumentID
	    where b.isRule = 0 and a.isSupported=1	and b.beliefID NOT IN (select distinct b.beliefID 
							from arguments a 
							inner join beliefs b on b.beliefID = a.beliefID 
							inner join parent_argument pa on pa.argumentID = a.argumentID 
										and pa.sessionID = a.sessionID 
										and pa.timestep = a.timestep 
							where a.sessionID = '".$sessionID."' and a.timestep=".$timestep.")
			and b.beliefID IN (select beliefID
							    from agent_has_beliefs 
							    where sessionID = '".$sessionID."' and timestep=".$timestep." and agentID=".$agentID.");";
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("fact%s [label=\"%s:%s\", shape=box,  fontsize=35, fillcolor=lightcyan, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2]);
  }
}
mysqli_free_result($result);


/*
* Create rule nodes that are argument ends
*/
$sql =" select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported and ab.agentID = q.agentID
	    inner join parent_argument_has_argument paa on paa.argumentID=a.argumentID
	    inner join (select pa.parentArgumentID
	                from parent_argument pa
	                inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
	                inner join arguments a on a.argumentID = paa.argumentID and a.sessionID = pa.sessionID and a.timestep = pa.timestep
	                inner join beliefs b on b.beliefID = a.beliefID
	                inner join agent_has_beliefs ab on ab.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep = a.timestep
	                where ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep." and ab.agentID=".$agentID."
	    ) ij on ij.parentArgumentID = paa.parentArgumentID
	    where b.isRule = 1 and a.isSupported=1	and b.beliefID IN (select distinct b.beliefID 
							from arguments a 
							inner join beliefs b on b.beliefID = a.beliefID 
							inner join parent_argument pa on pa.argumentID = a.argumentID 
										and pa.sessionID = a.sessionID 
										and pa.timestep = a.timestep 
							where a.sessionID = '".$sessionID."' and a.timestep=".$timestep.");";
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	$sql="select CASE 
        WHEN isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate
		from belief_has_premises b
		inner join predicate_has_constant pc on pc.predicateConstantID = b.premiseID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		where beliefID = ".$row[0].";";
  	$return=mysqli_query($link,$sql);
  	$premise='';
  	$count=0;
  	while($innerrow = mysqli_fetch_array($return)) {
  		if($count > 0){ 
  			$premise .= ", ";}
  		$premise .= $innerrow[0];	
  		$count++;
  	}
  	mysqli_free_result($return);
  	printf ("rule%s [label=\"%s :- %s:%s\",  fontsize=35, shape=box3d, fillcolor=lightblue, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$premise,$row[2]);
	printf ("rule%s -> inference%s [color=darkgreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[0]);

  	if($row[3] == "IN" && $row[4] == 1){
		printf ("inference%s [label=\"%s:%s : %s\", shape=box, fillcolor=palegreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$row[3]);
  	}else if($row[3] == "OUT" && $row[4] == 1){
		printf ("inference%s [label=\"%s:%s : %s\", style=\"filled\", fillcolor=pink, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$row[3]);
  	}else if($row[3] == "UNDEC" && $row[4] == 1){
		printf ("inference%s [label=\"%s:%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$row[3]);
  	}else{
  		$statuses = "";
		$count = 0;
		$sql = "select status 
				from parent_argument pa
				inner join arguments a on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and a.timestep = pa.timestep
				inner join beliefs b on a.beliefID = b.beliefID
				where pa.sessionID = '".$sessionID."' and pa.timestep = ".$timestep." and b.beliefID = ".$row[0];
		$result2=mysqli_query($link,$sql);
		if ($result2) {
			while ($row2 = mysqli_fetch_array($result2)) {
				if($count > 0)
					$statuses = $statuses . ", ".$row2[0];
				else{	
					$statuses = $row2[0];
					$count=$count+1;
				}
			}
		}
		mysqli_free_result($result2);
		printf ("inference%s [label=\"%s:%s : %s\",  fontsize=35, style=\"dotted, filled\" shape=box, fillcolor=lemonchiffon, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$statuses);
				
  	}
  }
}
mysqli_free_result($result);

/*
* Create fact nodes that are argument ends
*/
$sql =" select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported and ab.agentID = q.agentID
	    inner join parent_argument_has_argument paa on paa.argumentID=a.argumentID
	    inner join (select pa.parentArgumentID
	                from parent_argument pa
	                inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
	                inner join arguments a on a.argumentID = paa.argumentID and a.sessionID = pa.sessionID and a.timestep = pa.timestep
	                inner join beliefs b on b.beliefID = a.beliefID
	                inner join agent_has_beliefs ab on ab.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep = a.timestep
	                where ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep." and ab.agentID=".$agentID."
	    ) ij on ij.parentArgumentID = paa.parentArgumentID
	    where b.isRule = 0 and a.isSupported=1	and b.beliefID IN (select distinct b.beliefID 
							from arguments a 
							inner join beliefs b on b.beliefID = a.beliefID 
							inner join parent_argument pa on pa.argumentID = a.argumentID 
										and pa.sessionID = a.sessionID 
										and pa.timestep = a.timestep 
							where a.sessionID = '".$sessionID."' and a.timestep=".$timestep.")
			and b.beliefID IN (select beliefID
							    from agent_has_beliefs 
							    where sessionID = '".$sessionID."' and timestep=".$timestep." and agentID=".$agentID.")";
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	if($row[3] == "IN" && $row[4] == 1){
		printf ("fact%s [label=\"%s:%s : %s\", shape=box,  fontsize=35, fillcolor=palegreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$row[3]);
  	}else if($row[3] == "OUT" && $row[4] == 1){
		printf ("fact%s [label=\"%s:%s : %s\", style=\"filled\",  fontsize=35, fillcolor=pink, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$row[3]);
  	}else if($row[3] == "UNDEC" && $row[4] == 1){
		printf ("fact%s [label=\"%s:%s : %s\", shape=box,  fontsize=35, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$row[3]);
  	}else{
  		$statuses = "";
		$count = 0;
		$sql = "select status 
				from parent_argument pa
				inner join arguments a on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and a.timestep = pa.timestep
				inner join beliefs b on a.beliefID = b.beliefID
				where pa.sessionID = '".$sessionID."' and pa.timestep = ".$timestep." and b.beliefID = ".$row[0];
		$result2=mysqli_query($link,$sql);
		if ($result2) {
			while ($row2 = mysqli_fetch_array($result2)) {
				if($count > 0)
					$statuses = $statuses . ", ".$row2[0];
				else{	
					$statuses = $row2[0];
					$count=$count+1;
				}
			}
		}
		mysqli_free_result($result2);
		printf ("fact%s [label=\"%s:%s : %s\", style=\"dotted, filled\" shape=box,  fontsize=35, fillcolor=lemonchiffon, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$statuses);
				
  	}
  }
}
mysqli_free_result($result);

/*
* Create arrows between agents and their direct beliefs
*/
$sql="select distinct concat('agent',ab.agentID), case when isRule = 1 then concat('rule',b.beliefID) else concat('fact',b.beliefID) end l
	from agent_has_beliefs ab
	inner join beliefs b on ab.beliefID = b.beliefID 
	inner join arguments a on a.beliefID = b.beliefID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
	inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
	where isInferred = 0 and a.isSupported = 1 and b.isRule = 0
	and ab.agentID = ".$agentID."
	and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("%s -> %s [color=crimson, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);
    
	
				?>
		}
<?php
	//Outer graph
/*
* Create agents nodes not in inner graph
*/
 $sql="SELECT DISTINCT agentID, agentName FROM agents 
 		INNER JOIN agent_trust on (trustingAgent = agentID or trustedAgent = agentID) 
 		where sessionID = '".$sessionID."' and timestep=".$timestep." and agentID != ".$agentID;
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("agent%s [label=%s, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);

$sql="select concat('agent',trustingAgent), concat('agent',trustedAgent) from agent_trust where sessionID = '".$sessionID."' and timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);
	
/*
* Create arrows between agents and their direct beliefs
*/
$sql="select distinct concat('agent',ab.agentID), case when isRule = 1 then concat('rule',b.beliefID) else concat('fact',b.beliefID) end l
	from agent_has_beliefs ab
	inner join beliefs b on ab.beliefID = b.beliefID 
	inner join arguments a on a.beliefID = b.beliefID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
	inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
	where isInferred = 0 and a.isSupported = 1 and b.isRule = 0
	and ab.agentID != ".$agentID."
	and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);

/*
* Create arrows between beliefs
*/
$sql="select distinct case when b1.isRule = 1 then concat('rule',a.beliefID) else concat('fact',a.beliefID) end fromID, 
	case when b2.isRule = 1 then concat('rule',ab.beliefID) else concat('fact',ab.beliefID) end toID, b1.isRule, a.beliefID
	from arguments a
	inner join arguments ab on a.supportsArgumentID = ab.argumentID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
	inner join beliefs b1 on a.beliefID = b1.beliefID 
	inner join beliefs b2 on ab.beliefID = b2.beliefID
	inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
	inner join questions q2 on q2.sessionID = ab.sessionID and q2.timestep = ab.timestep and q2.isSupported = ab.isSupported
		where a.isSupported = 1 and ab.isSupported = 1
	and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
//	order by a.questionID, a.supportsArgumentID";
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	if($row[2] == 0){
	  	printf ("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
	}else{
//	  	printf ("%s -> inference%s [color=darkgreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[3]);
	  	printf ("inference%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[3],$row[1]);
	}
  }
}
mysqli_free_result($result);
$sql="select distinct case when b.isRule = 1 then concat('inference',b.beliefID)
				  else concat('fact',b.beliefID) END fromID,
			 case when b2.isRule = 1 then concat('inference',b2.beliefID)
				  else concat('fact',b2.beliefID) END toID, paa.attackType, 
			 case when b.isRule = 1 and b2.isRule = 1 then 'rebut'
			 	  when b.isRule = 1 and b2.isRule = 0 then 'undermine'
			 	  when b.isRule = 0 and b2.isRule = 0 then 'undermine'
			 	  ELSE 'rebut' END attackTypeOld
			  from parent_argument_attacks_argument paa
		inner join parent_argument pa1 on pa1.parentArgumentID = paa.fromParentArgID
		inner join arguments a on a.argumentID = pa1.argumentID and a.sessionID = pa1.sessionID and a.timestep = pa1.timestep
		inner join beliefs b on b.beliefID = a.beliefID
		inner join parent_argument pa2 on pa2.parentArgumentID = paa.toParentArgID
		inner join arguments a2 on a2.argumentID = pa2.argumentID and a2.sessionID = pa2.sessionID and a2.timestep = pa2.timestep
		inner join beliefs b2 on b2.beliefID = a2.beliefID
		where a.sessionID = '".$sessionID."' and a.timestep = ".$timestep;
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
	printf ("%s -> %s [label=%s color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2]);
  }
}
mysqli_free_result($result);
		

?>
	}
}
