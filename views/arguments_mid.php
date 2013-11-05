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
/** @page dotgen_argument_impl Implementation Details: arguments_mid.php
 * arguments_mid.php: 
 * File that generates dot file for mid level view of arguments. View includes 
 * sources, outcomes.
 *
 * Generates dot file highlighting all the elements in the user selected
 * outcome (or argument) starting from agent posing question using data
 * structures defined in file datagen_db.php. Those elements not fully
 * contained in the selected outcome/argument are greyed out.
 */


/** @page dotgen_argument_impl
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

/** @page dotgen_argument_impl
 *
 * * Draw all elements associated with this argument ID ($argumentID)
 */

/** @page dotgen_argument_impl
 *
 *   + Create agents nodes that are part of this argument ($argumentID)
 */
foreach ($arg_agentIDs as $id) {
      printf("%s [label=%s, fontsize=35, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $agents[$id]["dot_label"], $agents[$id]["name"]);
}

/** @page dotgen_argument_impl
 *
 *  + Create fact nodes that are argument conclusions and that are part of
 * this argument ($argumentID)
 */
foreach ($arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 0) &&
        ($qagnt_beliefs[$id]["end_argument"] == 1)) {
        $info = & $qagnt_beliefs[$id];
        if (($info["num_statuses"] == 1) && ($info["statuses"][0] == "IN")) {
            printf("%s [label=\"%s:%s : %s\", fontsize=35,shape=box, fillcolor=palegreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), $info["statuses"][0]);
        } else if (($info["num_statuses"] == 1) &&
                   ($info["statuses"][0] == "OUT")) {
            printf("%s [label=\"%s:%s : %s\", fontsize=35,style=\"filled\", fillcolor=pink, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), $info["statuses"][0]);
        } else if (($info["num_statuses"] == 1) &&
                   ($info["statuses"][0] == "UNDEC")) {
            printf("%s [label=\"%s:%s : %s\", fontsize=35,shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), $info["statuses"][0]);
        } else {
            printf("%s [label=\"%s:%s : %s\", fontsize=35, style=\"dotted, filled\" shape=box, fillcolor=lemonchiffon, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), implode(", ", $info["statuses"]));
        }
    }
}

/** @page dotgen_argument_impl
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

//////////////////////////////////////////////////////////////////
?>
        }

<?php

/** @page dotgen_argument_impl
 *
 * * Draw all elements that are NOT fully part of this argument ID
 * ($agrumentID). This includes arrows between beliefs/agents that are part of
 * this argument ID and other beliefs/agents that are not part of this
 * argument ID. Color all these elements grey.
 */

/** @page dotgen_argument_impl
 *
 *   + Create agents nodes that are NOT part of this argument ($argumentID)
 */
foreach ($not_arg_agentIDs as $id) {
    printf("%s [label=%s, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $agents[$id]["dot_label"], $agents[$id]["name"]);
}

/** @page dotgen_argument_impl
 *
 *  + Create fact nodes that are argument conclusions and that are NOT part of
 * this argument ($argumentID)
 */
foreach ($not_arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 0) &&
        ($qagnt_beliefs[$id]["end_argument"] == 1)) {
        $info = & $qagnt_beliefs[$id];
        if (($info["num_statuses"] == 1) && ($info["statuses"][0] == "IN")) {
            printf("%s [label=\"%s:%s : %s\",shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), $info["statuses"][0]);
        } else if (($info["num_statuses"] == 1) &&
                   ($info["statuses"][0] == "OUT")) {
            printf("%s [label=\"%s:%s : %s\",style=\"filled\", fillcolor=grey, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), $info["statuses"][0]);
        } else if (($info["num_statuses"] == 1) &&
                   ($info["statuses"][0] == "UNDEC")) {
            printf("%s [label=\"%s:%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), $info["statuses"][0]);
        } else {
            printf("%s [label=\"%s:%s : %s\", style=\"dotted, filled\" shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), implode(", ", $info["statuses"]));
        }
    }
}

/** @page dotgen_argument_impl
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

?>
    }
}