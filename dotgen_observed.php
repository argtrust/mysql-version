digraph g {
	graph [size="11,8.5", ratio=fill, overlap=false, splines=true, page="12.222222,9.444444", margin="0.617284,0.277778"];
	node [label="\N"];
	graph [bb="0 0 1478 1142"];
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
$sql = "select distinct a.agentID, a.agentName
		from agents a
		inner join agent_has_beliefs ab on ab.agentID = a.agentID
		where ab.sessionID = '".$sessionID."' and ab.timestep = ".$timestep." and ab.beliefID = ".$beliefID.";";	
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("agent%s [label=%s, fontsize=80, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);

/*
* Create arrows between agents
*/
$sql="select concat('agent',trustingAgent), concat('agent',trustedAgent) from agent_trust where sessionID = '".$sessionID."' and timestep=".$timestep."
and trustedAgent in (
                        select distinct a.agentID
                        from agents a
                        inner join agent_has_beliefs ab on ab.agentID = a.agentID
                        where ab.sessionID = '".$sessionID."' and ab.timestep = ".$timestep." and ab.beliefID = ".$beliefID."
                       )";
$result=mysqli_query($link,$sql);
if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("%s -> %s [color=yellow, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);


/*
* Create fact nodes that aren't ends of arguments
*/
 $sql="select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		where ab.agentID = 1 and b.isRule = 0 and a.isSupported = 1
		and ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep."
		and b.beliefID = ".$beliefID.";";
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("fact%s [label=\"%s:%s\", shape=box, fillcolor=lightcyan, fontsize=60, height=\"1.5\", width=9.5, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2]);
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
	and a.sessionID = '".$sessionID."' and a.timestep=".$timestep." and b.beliefID = ".$beliefID;
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
//Agents not displayed above
$sql = "select distinct a.agentID, a.agentName
		from agents a
		inner join agent_has_beliefs ab on ab.agentID = a.agentID
		where ab.sessionID = '".$sessionID."' and ab.timestep = ".$timestep." and a.agentID NOT IN (
			select distinct a.agentID
			from agents a
			inner join agent_has_beliefs ab on ab.agentID = a.agentID
			where ab.sessionID = '".$sessionID."' and ab.timestep = ".$timestep." and ab.beliefID = ".$beliefID.") ;";	
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("agent%s [label=%s, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);

/*
* Create rule nodes that aren't argument ends
*/
$sql="select distinct b.beliefID, CASE 
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID  
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		where ab.agentID = 1 and b.isRule = 1 and a.isSupported=1
		and ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep."
		and b.beliefID NOT IN (select distinct b.beliefID 
								from arguments a 
								inner join beliefs b on b.beliefID = a.beliefID 
								inner join parent_argument pa on pa.argumentID = a.argumentID 
											and pa.sessionID = a.sessionID 
											and pa.timestep = a.timestep 
								where a.sessionID = '".$sessionID."' and a.timestep=".$timestep.")";
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
  	printf ("rule%s [label=\"%s :- %s:%s\", shape=box3d, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$premise,$row[2]);
  	printf ("inference%s [label=\"%s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
	printf ("rule%s -> inference%s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[0]);
  }
}
mysqli_free_result($result);
/*
* Create rule nodes that are argument conclusions
*/
 $sql="select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, ab.level, max(pa.status), count(distinct pa.status) as argStatus 
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		inner join parent_argument pa on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep 
		where ab.agentID = 1 and b.isRule = 1 and a.isSupported = 1
		and ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep."
		group by b.beliefID, b.isNegated, p.name, c.name, ab.level";
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
  	printf ("rule%s [label=\"%s :- %s:%s\", shape=box3d, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$premise,$row[2]);
	printf ("rule%s -> inference%s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[0]);
  	
  	if($row[3] == "IN" && $row[4] == 1){
		printf ("inference%s [label=\"%s:%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$row[3]);
  	}else if($row[3] == "OUT" && $row[4] == 1){
		printf ("inference%s [label=\"%s:%s : %s\", style=\"filled\", fillcolor=grey, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$row[3]);
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
		printf ("inference%s [label=\"%s:%s : %s\", style=\"dotted, filled\" shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2],$statuses);
				
  	}
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
		

/*
* Create arrows between agents and their direct beliefs
*/
$sql="select distinct concat('agent',ab.agentID), case when isRule = 1 then concat('rule',b.beliefID) else concat('fact',b.beliefID) end l
	from agent_has_beliefs ab
	inner join beliefs b on ab.beliefID = b.beliefID 
	inner join arguments a on a.beliefID = b.beliefID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
	inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
	where isInferred = 0 and a.isSupported = 1 and b.isRule = 0
	and a.sessionID = '".$sessionID."' and a.timestep=".$timestep." and b.beliefID != ".$beliefID;
$result=mysqli_query($link,$sql);
if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);


$sql="select concat('agent',trustingAgent), concat('agent',trustedAgent), level
from agent_trust at
where trustedAgent NOT IN (
                        select distinct a.agentID
                        from agents a
                        inner join agent_has_beliefs ab on ab.agentID = a.agentID
                        where ab.sessionID = '".$sessionID."' and ab.timestep = ".$timestep." and ab.beliefID = ".$beliefID."
                       )
and at.sessionID = '".$sessionID."' and at.timestep = ".$timestep.";";
$result=mysqli_query($link,$sql);
if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1]);
  }
}
mysqli_free_result($result);

/*
* Create fact nodes that aren't ends of arguments
*/
 $sql="select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, level
		from beliefs b
		inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
		inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
		inner join predicates p on p.predicateID = pc.predicateID
		inner join constants c on pc.constantID = c.constantID 
		inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
		inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
		where ab.agentID = 1 and b.isRule = 0 and a.isSupported = 1
		and ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep."
		and b.beliefID != ".$beliefID.";";
 $result=mysqli_query($link,$sql);
 if ($result) {
  while ($row = mysqli_fetch_array($result)) {
  	printf ("fact%s [label=\"%s:%s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",$row[0],$row[1],$row[2]);
  }
}
mysqli_free_result($result);


?>
	}
}
