digraph g {
    graph [size="5,5", ratio=fill, overlap=false, splines=true, margin=".10"];
    node [label="\N"];
    graph [bb="0 0 3000 3000"];    
    subgraph cluster_trust_net {
        graph [bb=""];
        node [shape=oval,
            style=filled,
            fillcolor=lavender,
            fontname=arial];
        edge [color=blue];
        subgraph cluster_0 {
            graph [style="rounded,filled",
                fillcolor=whitesmoke];
<?php
/** @page dotgen_argument_low_impl Implementation Details: dotgen_argument_low.php
 * dotgen_argument_low.php: 
 * File that generates dot file highlighting all the elements in the user
 * selected argument within the "Outcomes" radio elements when the "Detail"
 * slider position is at "low-level".
 *
 * Generates dot file highlighting all the elements in the user selected
 * outcome (or argument) starting from agent posing question using data
 * structures defined in file datagen_db.php for "low-level" position of the
 * "Detail" slider. Those elements not fully contained in the selected
 * outcome/argument are greyed out.
 */


/** @page dotgen_argument_low_impl
 *
 * * Find agents IDs that are part of this argument ($arg_agentIDs) and those
 * that are not part of this argument ($not_arg_agentIDs). Use
 * $arguments[$argumentID]["agentIDs"] and $agents.
 */
$arg_agentIDs = $arguments[$argumentID]["agentIDs"];
$agentIDs = array_keys($agents);
$not_arg_agentIDs = array_diff($agentIDs, $arg_agentIDs);
//printf("//arg_agentIDs = (%s), not_arg_agentIDs = (%s)\n",
//       implode(", ", $arg_agentIDs), implode(", ", $not_arg_agentIDs));

/** @page dotgen_argument_low_impl
 *
 * * Find belief IDs that are part of this argument ($arg_beliefIDs) and
 * those that are not part of this argument ($not_arg_beliefIDs). Use
 * $arguments[$argumentID]["beliefIDs"] and $qagnt_beliefs.
 */
$arg_beliefIDs = $arguments[$argumentID]["beliefIDs"];
$beliefIDs = array_keys($qagnt_beliefs);
$not_arg_beliefIDs = array_diff($beliefIDs, $arg_beliefIDs);
//printf("//arg_beliefIDs = (%s), not_arg_beliefIDs = (%s)\n",
//       implode(", ", $arg_beliefIDs), implode(", ", $not_arg_beliefIDs));

/** @page dotgen_argument_low_impl
 *
 * * Draw all elements associated with this argument ID ($argumentID) for
 * "low-level" position of the "Detail" slider.
 */

/** @page dotgen_argument_low_impl
 *
 *   + Create agents nodes that are part of this argument ($argumentID)
 */
foreach ($arg_agentIDs as $id) {
      printf("%s [label=%s, fontsize=35, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $agents[$id]["dot_label"], $agents[$id]["name"]);
}


/** @page dotgen_argument_mid_impl
 *
 * * Create node for this argument ($argumentID) conclusions/outcomes
 */
//Arguments in current argument
$nodesInDraw = array();
$sql="select distinct case when b.isRule = 1 then concat('inference',b.beliefID) else concat('fact',b.beliefID) end theID,
    round(max(pa.level)*100), UPPER(ltrim(rtrim(pa.status))), CASE
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))')
        ELSE concat(p.name,'(',c.name,')') END predicate
from parent_argument pa
inner join arguments a on a.argumentID = pa.argumentID and a.timestep = pa.timestep and pa.sessionID = a.sessionID
inner join beliefs b on b.beliefID = a.beliefID
inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
inner join predicates p on p.predicateID = pc.predicateID
inner join constants c on pc.constantID = c.constantID
where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep." and a.isSupported = 1
    and pa.parentArgumentID = ".$argumentID."
group by a.argumentID, pa.status, b.isNEgated, p.name, c.name
;";
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        array_push($nodesInDraw, $row[0]);
        if ($row[2] == "IN") {
            printf("%s [label=\"%s : %s : %s\", fontsize=35, shape=box, fillcolor=palegreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $row[0], $row[3], $row[1],
                   $row[2]);
        }else if ($row[2] == "OUT") {
            printf("%s [label=\"%s : %s\", fontsize=35, shape=box, fillcolor=pink, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $row[0], $row[3], $row[1],
                   $row[2]);
        }else if ($row[2] == "UNDEC") {
            printf("%s [label=\"%s : %s\", fontsize=35, shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $row[0], $row[3], $row[1],
                   $row[2]);
        }else{
            printf("%s [label=\"%s : %s\", fontsize=35, shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $row[0], $row[3], $row[1],
                   $row[2]);
        }
    }
}

//facts in the argument
$sql="
select distinct case when b.isRule = 1 then concat('inference',b.beliefID) else concat('fact',b.beliefID) end theID,
CASE
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))')
        ELSE concat(p.name,'(',c.name,')') END predicate, round(ab.level*100)
from parent_argument pa
inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
inner join arguments a on a.argumentID = paa.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep
inner join beliefs b on b.beliefID = a.beliefID and b.isRule = 0
inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
inner join predicates p on p.predicateID = pc.predicateID
inner join constants c on pc.constantID = c.constantID
inner join agent_has_beliefs ab on ab.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep = a.timestep
inner join questions q on q.agentID = ab.agentID and q.sessionID = a.sessionID and q.timestep = a.timestep and isAttack = 0
where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep."
    and pa.parentArgumentID = ".$argumentID."
";
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        if(!in_array($row[0],$nodesInDraw)){
            array_push($nodesInDraw, $row[0]);
            printf("%s [label=\"%s : %s\", shape=box, fontsize=35, fillcolor=lightcyan, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                $row[0],$row[1], $row[2]);
        }
    }
}

$argumentsInDraw = array();
//Arrows from facts to conclusions
$sql="select distinct concat('fact',b.beliefID),
    case when b2.isRule = 1 then concat('inference',b2.beliefID) else concat('fact',b2.beliefID) end
    from agent_has_beliefs ab
    inner join beliefs b on ab.beliefID = b.beliefID
    inner join arguments a on a.beliefID = b.beliefID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
    inner join parent_argument_has_argument paa on a.argumentID = paa.argumentID
    inner join parent_argument pa on paa.parentArgumentID = pa.parentArgumentID and a.sessionID = pa.sessionID and a.timestep = pa.timestep
    inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported and q.questionID = pa.questionID
    inner join arguments a2 on a2.argumentID = pa.argumentID and a2.sessionID = pa.sessionID and a2.timestep = pa.timestep
    inner join beliefs b2 on b2.beliefID = a2.beliefID
    where isInferred = 0 and a.isSupported = 1 and b.isRule = 0
    and pa.parentArgumentID = ".$argumentID."
	and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        if($row[0] != $row[1]){
            array_push($argumentsInDraw, $row[0]."_".$row[1]);
            printf("%s -> %s [color=crimson, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $row[0], $row[1]);
        }
    }
}

//Arrows from agents to facts
$sql="select distinct concat('agent',ab.agentID),
case when b.isRule = 1 then concat('inference',b.beliefID) else concat('fact',b.beliefID) end theID,
CASE
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))')
        ELSE concat(p.name,'(',c.name,')') END predicate, ab.level
from parent_argument pa
inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
inner join arguments a on a.argumentID = paa.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep
inner join beliefs b on b.beliefID = a.beliefID and b.isRule = 0
inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
inner join predicates p on p.predicateID = pc.predicateID
inner join constants c on pc.constantID = c.constantID
inner join agent_has_beliefs ab on ab.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep = a.timestep
where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep."
    and pa.parentArgumentID = ".$argumentID." and ab.isInferred = 0";
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        if($row[0] != $row[1]){
            array_push($argumentsInDraw, $row[0]."_".$row[1]);
            printf("%s -> %s [color=crimson, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $row[0], $row[1]);
        }

    }
}


/** @page dotgen_argument_low_impl
 *
 *  + Create arrows between agents that are part of this argument
 * ($argumentID) and add to $arg_agent_arrows
 */
$arg_agent_arrows = array ();
foreach ($arg_agentIDs as $id1) {
    foreach ($arg_agentIDs as $id2) {
        if ($id1 != $id2) {
            $from_to = $id1."_".$id2;
            if (array_key_exists($from_to, $agent_arrows)) {
                $arg_agent_arrows[$from_to] = "Yes";
                printf("%s -> %s [color=blue, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $agent_arrows[$from_to]["from_dot_label"],
                       $agent_arrows[$from_to]["to_dot_label"]);
            }
        }
    }
}


//////////////////////////////////////////////////////////////////
?>
        }

<?php

/** @page dotgen_argument_mid_impl
 *
 *   + Create agents nodes that are NOT part of this argument ($argumentID)
 */
foreach ($not_arg_agentIDs as $id) {
    printf("%s [label=%s, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $agents[$id]["dot_label"], $agents[$id]["name"]);
}

/** @page dotgen_argument_mid_impl
 *
 *  + Create arrows between agents that are NOT both part of this argument
 * ($argumentID), i.e., agent arrows not in $arg_agent_arrows
 */
foreach ($agent_arrows as $id=>$info) {
    if (array_key_exists($id, $arg_agent_arrows) == FALSE) {
        printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["from_dot_label"], $info["to_dot_label"]);
    }
}

//Arguments in current argument
$sql="select distinct  case when b.isRule = 1 then concat('inference',b.beliefID) else concat('fact',b.beliefID) end theID,
    round(max(pa.level)*100), UPPER(ltrim(rtrim(pa.status))), CASE
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))')
        ELSE concat(p.name,'(',c.name,')') END predicate
from parent_argument pa
inner join arguments a on a.argumentID = pa.argumentID and a.timestep = pa.timestep and pa.sessionID = a.sessionID
inner join beliefs b on b.beliefID = a.beliefID
inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
inner join predicates p on p.predicateID = pc.predicateID
inner join constants c on pc.constantID = c.constantID
where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep." and a.isSupported = 1
    and not a.argumentID in (select argumentID from parent_argument where parentArgumentID = ".$argumentID.")
    and pa.parentArgumentID != ".$argumentID."
group by a.argumentID, pa.status, b.isNEgated, p.name, c.name
;";
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        if(!in_array($row[0],$nodesInDraw)){
            array_push($nodesInDraw, $row[0]);
            if ($row[2] == "IN") {
                printf("%s [label=\"%s : %s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $row[0], $row[3], $row[1],
                       $row[2]);
            }else if ($row[2] == "OUT") {
                printf("%s [label=\"%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $row[0], $row[3], $row[1],
                       $row[2]);
            }else if ($row[2] == "UNDEC") {
                printf("%s [label=\"%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $row[0], $row[3], $row[1],
                       $row[2]);
            }else{
                printf("%s [label=\"%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $row[0], $row[3], $row[1],
                       $row[2]);
            }
        }
    }
}

//facts not in the argument
$sql="
select distinct case when b.isRule = 1 then concat('inference',b.beliefID) else concat('fact',b.beliefID) end theID,
CASE
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))')
        ELSE concat(p.name,'(',c.name,')') END predicate, round(ab.level*100)
from beliefs b
inner join agent_has_beliefs ab on ab.beliefID = b.beliefID
inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
inner join predicates p on p.predicateID = pc.predicateID
inner join constants c on pc.constantID = c.constantID
where ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep."
and isInferred = 0 and b.isRule = 0
and not b.beliefID in
	(select distinct b.beliefID
		from parent_argument pa
		inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
		inner join arguments a on a.argumentID = paa.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep
		inner join beliefs b on b.beliefID = a.beliefID and b.isRule = 0
		where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep."
		and pa.parentArgumentID = ".$argumentID."
	)
and not b.beliefID in
	(select distinct b.beliefID
		from parent_argument pa
		inner join arguments a on a.argumentID = pa.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep
		inner join beliefs b on b.beliefID = a.beliefID and b.isRule = 0
		where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep."
	)
;
";
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        if(!in_array($row[0],$nodesInDraw)){
            array_push($nodesInDraw, $row[0]);
            printf("%s [label=\"%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                $row[0],$row[1], $row[2]);
        }
    }
}

//Arrows from facts to conclusions
$sql="select distinct concat('fact',b.beliefID),
    case when b2.isRule = 1 then concat('inference',b2.beliefID) else concat('fact',b2.beliefID) end
    from agent_has_beliefs ab
    inner join beliefs b on ab.beliefID = b.beliefID
    inner join arguments a on a.beliefID = b.beliefID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
    inner join parent_argument_has_argument paa on a.argumentID = paa.argumentID
    inner join parent_argument pa on paa.parentArgumentID = pa.parentArgumentID and a.sessionID = pa.sessionID and a.timestep = pa.timestep
    inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported and q.questionID = pa.questionID
    inner join arguments a2 on a2.argumentID = pa.argumentID and a2.sessionID = pa.sessionID and a2.timestep = pa.timestep
    inner join beliefs b2 on b2.beliefID = a2.beliefID
    where isInferred = 0 and a.isSupported = 1 and b.isRule = 0
    and pa.parentArgumentID != ".$argumentID."
	and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        if($row[0] != $row[1] && !in_array($row[0]."_".$row[1],$argumentsInDraw)){
            array_push($argumentsInDraw,$row[0]."_".$row[1]);
            printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $row[0], $row[1]);
        }
    }
}

//Arrows from agents to facts not in argument
$sql="select distinct concat('agent',ab.agentID),
case when b.isRule = 1 then concat('inference',b.beliefID) else concat('fact',b.beliefID) end theID,
CASE
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))')
        ELSE concat(p.name,'(',c.name,')') END predicate, ab.level
from parent_argument pa
inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
inner join arguments a on a.argumentID = paa.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep
inner join beliefs b on b.beliefID = a.beliefID and b.isRule = 0
inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
inner join predicates p on p.predicateID = pc.predicateID
inner join constants c on pc.constantID = c.constantID
inner join agent_has_beliefs ab on ab.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep = a.timestep
where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep." and ab.isInferred = 0";
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        if($row[0] != $row[1] && !in_array($row[0]."_".$row[1], $argumentsInDraw)){
            array_push($argumentsInDraw,$row[0]."_".$row[1]);
            printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $row[0], $row[1]);
        }

    }
}
/** @page dotgen_hw_impl
 *
 * * Create arrows for attacks (rebut and undermine)
 */
foreach ($attack_arrows as $id=>$info) {
    printf("%s -> %s [label=%s color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $info["from_dot_label"],$info["to_dot_label"],$info["attack_type"]);
}

?>
    }
}
