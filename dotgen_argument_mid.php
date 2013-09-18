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
/** @page dotgen_argument_mid_impl Implementation Details: dotgen_argument_mid.php
 * dotgen_argument_mid.php: 
 * File that generates dot file highlighting all the elements in the user
 * selected argument within the "Outcomes" radio elements when the "Detail"
 * slider position is at "mid-level".
 *
 * Generates dot file highlighting all the agents in the user selected
 * outcome (or argument) starting from agent posing question using data
 * structures defined in file datagen_db.php for "mid-level" position of the
 * "Detail" slider. Those elements (agents and other arguments) not fully
 * contained in the selected outcome/argument are greyed out.
 */


/** @page dotgen_argument_mid_impl
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

/** @page dotgen_argument_mid_impl
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

/** @page dotgen_argument_mid_impl
 *
 * * Draw all elements associated with this argument ID ($argumentID) for
 * "mid-level" position of the "Detail" slider.
 */

/** @page dotgen_argument_mid_impl
 *
 *   + Create agents nodes that are part of this argument ($argumentID)
 */
foreach ($arg_agentIDs as $id) {
      printf("%s [label=%s, fontsize=35, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $agents[$id]["dot_label"], $agents[$id]["name"]);
}

/** @page dotgen_argument_mid_impl
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
                printf("%s -> %s [color=yellow, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $agent_arrows[$from_to]["from_dot_label"],
                       $agent_arrows[$from_to]["to_dot_label"]);
            }
        }
    }
}

/** @page dotgen_argument_mid_impl
 *
 * * Create node for this argument ($argumentID) conclusions/outcomes
 */
$disp_arguments = array ();

$id = $argumentID;
$info = $arguments[$argumentID];
if ($info["status"] == "IN") {
    printf("%s [label=\"%s : %s\", fontsize=35, shape=box, fillcolor=palegreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           "outcome".$id, $info["conclusion_display"],
           $info["status"]);
}else if($info["status"] == "OUT") {
    printf("%s [label=\"%s : %s\", fontsize=35, style=\"filled\", fillcolor=pink, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           "outcome".$id, $info["conclusion_display"],
           $info["status"]);
}else if($info["status"] == "UNDEC") {
    printf("%s [label=\"%s : %s\", fontsize=35, shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           "outcome".$id, $info["conclusion_display"],
           $info["status"]);
}
$disp_arguments[] = $id;

/** @page dotgen_argument_mid_impl
 *
 * * Create arrows between this outcome ($argumentID) and agents that
 * contribute to the outcome
 */
$disp_agent_arg_arrows = array ();

$disp_argid = $argumentID;
$arg_agentIDs = $info["agentIDs"];
$arg_beliefIDs = $info["beliefIDs"];
foreach ($arg_agentIDs as $agentID) {
    foreach ($arg_beliefIDs as $beliefID) {
        $from_to = $agentID."_".$beliefID;
        if (array_key_exists($from_to, $agent_fact_arrows)) {
            // If not in $disp_agent_arg_arrows, draw and add to array.
            $agent_disparg = $agentID."_".$disp_argid;
            if (array_key_exists($agent_disparg, $disp_agent_arg_arrows)
                == FALSE) {
                printf("%s -> %s [color=crimson, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $agents[$agentID]["dot_label"],
                       "outcome".$disp_argid);
                $disp_agent_arg_arrows[$agent_disparg] = 1;
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
 * * Draw all elements that are NOT fully part of this argument ID
 * ($agrumentID). This includes arrows between agents that are part of
 * this argument ID and other arguments that are not this argument ID.
 * Color all these elements grey.
 */

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

/** @page dotgen_argument_mid_impl
 *
 * * Create nodes for argument conclusions/outcomes that are NOT this
 * argument ($argumentID)
 */
foreach ($arguments as $id => $info) {
    $displayed = 0;
    foreach ($disp_arguments as $argid) {
        if ($info["conclusion_display"] ==
            $arguments[$argid]["conclusion_display"]) {
            $displayed = 1;
            break;
        }
    }
    if ($displayed == 0) {
        if ($info["status"] == "IN") {
            printf("%s [label=\"%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   "outcome".$id, $info["conclusion_display"],
                   $info["status"]);
        }else if($info["status"] == "OUT") {
            printf("%s [label=\"%s : %s\", style=\"filled\", fillcolor=grey, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   "outcome".$id, $info["conclusion_display"],
                   $info["status"]);
        }else if($info["status"] == "UNDEC") {
            printf("%s [label=\"%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   "outcome".$id, $info["conclusion_display"],
                   $info["status"]);
        }

        $disp_arguments[] = $id;
    }
}

/** @page dotgen_argument_mid_impl
 *
 * * Create arrows between outcomes and agents that contribute to the outcome
 * for arguments NOT $argumentID
 */
foreach ($arguments as $id => $info) {
    $disp_argid = -1;
    foreach ($disp_arguments as $argid) {
        if ($info["conclusion_display"] ==
            $arguments[$argid]["conclusion_display"]) {
            $disp_argid = $argid;
            break;
        }
    }
    $arg_agentIDs = $info["agentIDs"];
    $arg_beliefIDs = $info["beliefIDs"];
    foreach ($arg_agentIDs as $agentID) {
        foreach ($arg_beliefIDs as $beliefID) {
            $from_to = $agentID."_".$beliefID;
            if (array_key_exists($from_to, $agent_fact_arrows)) {
                // If not in $disp_agent_arg_arrows, draw and add to array.
                $agent_disparg = $agentID."_".$disp_argid;
                if (array_key_exists($agent_disparg, $disp_agent_arg_arrows)
                    == FALSE) {
                    printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                           $agents[$agentID]["dot_label"],
                           "outcome".$disp_argid);
                    $disp_agent_arg_arrows[$agent_disparg] = 1;
                }
            }
        }
    }
}



?>
    }
}
