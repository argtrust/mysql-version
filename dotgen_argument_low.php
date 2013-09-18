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

/** @page dotgen_argument_low_impl
 *
 *  + Create fact nodes that aren't ends of arguments and that are part of
 * this argument ($argumentID)
 */
foreach ($arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 0) &&
        ($qagnt_beliefs[$id]["end_argument"] == 0)) {
        printf("%s [label=\"%s:%s\", shape=box, fontsize=35, fillcolor=lightcyan, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $qagnt_beliefs[$id]["dot_label"],
               $qagnt_beliefs[$id]["logic_display"],
               min($qagnt_beliefs[$id]["levels"]));
    }
}

/** @page dotgen_argument_low_impl
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

/** @page dotgen_argument_low_impl
 *
 *  + Create belief nodes (without the rule box) that aren't argument ends and
 * that are part of this argument ($argumentID)
 */
foreach ($arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 1) &&
        ($qagnt_beliefs[$id]["end_argument"] == 0)) {
        //printf("%s [label=\"%s:%s\", shape=box3d, fontsize=35, fillcolor=lightblue, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
        //       $qagnt_beliefs[$id]["rule_dot_label"],
        //       $qagnt_beliefs[$id]["rule_display"], $qagnt_beliefs[$id]["level"]);
        printf("%s [label=\"%s\", shape=box, fontsize=35, fillcolor=lightcyan, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $qagnt_beliefs[$id]["inference_dot_label"],
               $qagnt_beliefs[$id]["inference_display"]);
        //printf("%s -> %s [color=darkgreen, fontsize=35, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
        //       $qagnt_beliefs[$id]["rule_dot_label"],
        //       $qagnt_beliefs[$id]["inference_dot_label"]);
    }
}

/** @page dotgen_argument_low_impl
 *
 *  + Create belief nodes (without the rule box) that are argument conclusions
 * and that are part of this argument ($argumentID)
 */
foreach ($arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 1) &&
        ($qagnt_beliefs[$id]["end_argument"] == 1)) {
        $info = & $qagnt_beliefs[$id];
        //printf("%s [label=\"%s:%s\", shape=box3d, fillcolor=lightblue, fontsize=35, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
        //       $info["rule_dot_label"],
        //       $info["rule_display"], $info["level"]);
        //printf("%s -> %s [color=darkgreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
        //       $info["rule_dot_label"],
        //       $info["inference_dot_label"]);

        if (($info["num_statuses"] == 1) && ($info["statuses"][0] == "IN")) {
            printf("%s [label=\"%s:%s : %s\", shape=box, fontsize=35, fillcolor=palegreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"], $info["statuses"][0]);
        } else if (($info["num_statuses"] == 1) &&
                   ($info["statuses"][0] == "OUT")) {
            printf("%s [label=\"%s:%s : %s\", style=\"filled\", fontsize=35, fillcolor=pink, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"], $info["statuses"][0]);
        } else if (($info["num_statuses"] == 1) &&
                   ($info["statuses"][0] == "UNDEC")) {
            printf("%s [label=\"%s:%s : %s\", shape=box, fontsize=35, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"], $info["statuses"][0]);
        } else {
            printf("%s [label=\"%s:%s : %s\", style=\"dotted, fontsize=35, filled\" shape=box, fillcolor=lemonchiffon, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"],
                   implode(", ", $info["statuses"]));
        }
    }
}

/** @page dotgen_argument_low_impl
 *
 *  + Create arrows between beliefs (not to a rule) that are part of this
 * argument ($argumentID) and add to $arg_belief_arrows
 */
$arg_belief_arrows = array();
foreach ($arg_beliefIDs as $id1) {
    foreach ($arg_beliefIDs as $id2) {
        if ($id1 != $id2) {
            $from_to = $id1."_".$id2;
            if (array_key_exists($from_to, $belief_arrows)) {
                $arg_belief_arrows[$from_to] = "Yes";
                $info = $belief_arrows[$from_to];
                if ($info["from_rule"] == 0) {
                    printf("%s -> %s [color=darkgreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                           $info["from_dot_label"], "inference".$id2);
                           //$info["from_dot_label"], $info["to_dot_label"]);
                } else {
                    printf("%s -> %s [color=darkgreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                           $info["from_dot_label"], "inference".$id2);
                           //$info["from_dot_label"], $info["to_dot_label"]);
                }
            }
        }
    }
}

/** @page dotgen_argument_low_impl
 *
 *  + Create arrows for attacks (rebut and undermine) that are part of this
 * argument ($argumentID) and add to $arg_attack_arrows
 */
$arg_attack_arrows = array();
foreach ($arg_beliefIDs as $id1) {
    foreach ($arg_beliefIDs as $id2) {
        if ($id1 != $id2) {
            $from_to = $id1."_".$id2;
            if (array_key_exists($from_to, $attack_arrows)) {
                $arg_attack_arrows[$from_to] = "Yes";
                $info = $attack_arrows[$from_to];
                printf("%s -> %s [label=%s color=orange, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $info["from_dot_label"],$info["to_dot_label"],$info["attack_type"]);
            }
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
                printf("%s -> %s [color=yellow, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $agent_arrows[$from_to]["from_dot_label"],
                       $agent_arrows[$from_to]["to_dot_label"]);
            }
        }
    }
}

/** @page dotgen_argument_impl
 *
 *  + Create arrows between agents and their direct beliefs that are part of
 * this argument ($argumentID) and add to $arg_agent_belief_arrows
 */
$arg_agent_belief_arrows = array();
foreach ($arg_agentIDs as $id1) {
    foreach ($arg_beliefIDs as $id2) {
        $from_to = $id1."_".$id2;
        if (array_key_exists($from_to, $agent_belief_arrows)) {
            $arg_agent_belief_arrows[$from_to] = "Yes";
            printf("%s -> %s [color=crimson, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $agent_belief_arrows[$from_to]["from_dot_label"],
                   $agent_belief_arrows[$from_to]["to_dot_label"]);
        }
    }
}

//////////////////////////////////////////////////////////////////
?>
        }

<?php

/** @page dotgen_argument_low_impl
 *
 * * Draw all elements that are NOT fully part of this argument ID
 * ($agrumentID). This includes arrows between beliefs/agents that are part of
 * this argument ID and other beliefs/agents that are not part of this
 * argument ID. Color all these elements grey.
 */

/** @page dotgen_argument_low_impl
 *
 *   + Create agents nodes that are NOT part of this argument ($argumentID)
 */
foreach ($not_arg_agentIDs as $id) {
    printf("%s [label=%s, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $agents[$id]["dot_label"], $agents[$id]["name"]);
}

/** @page dotgen_argument_low_impl
 *
 *  + Create fact nodes that aren't ends of arguments and that are NOT part of
 * this argument ($argumentID).
 */
foreach ($not_arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 0) &&
        ($qagnt_beliefs[$id]["end_argument"] == 0)) {
        printf("%s [label=\"%s:%s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $qagnt_beliefs[$id]["dot_label"],
               $qagnt_beliefs[$id]["logic_display"],
               min($qagnt_beliefs[$id]["levels"]));
    }
}

/** @page dotgen_argument_low_impl
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

/** @page dotgen_argument_low_impl
 *
 *  + Create belief nodes (without the rule box) that aren't argument ends and
 * that are NOT part of this argument ($argumentID)
 */
foreach ($not_arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 1) &&
        ($qagnt_beliefs[$id]["end_argument"] == 0)) {
        //printf("%s [label=\"%s:%s\", shape=box3d, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
        //       $qagnt_beliefs[$id]["rule_dot_label"],
        //       $qagnt_beliefs[$id]["rule_display"], $qagnt_beliefs[$id]["level"]);
        printf("%s [label=\"%s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $qagnt_beliefs[$id]["inference_dot_label"],
               $qagnt_beliefs[$id]["inference_display"]);
        //printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
        //       $qagnt_beliefs[$id]["rule_dot_label"],
        //       $qagnt_beliefs[$id]["inference_dot_label"]);
    }
}

/** @page dotgen_argument_low_impl
 *
 *  + Create belief nodes (without the rule box) that are argument conclusions
 * and that are NOT part of this argument ($argumentID)
 */
foreach ($not_arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 1) &&
        ($qagnt_beliefs[$id]["end_argument"] == 1)) {
        $info = & $qagnt_beliefs[$id];
        //printf("%s [label=\"%s:%s\", shape=box3d, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
        //       $info["rule_dot_label"],
        //       $info["rule_display"], $info["level"]);
        //printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
        //       $info["rule_dot_label"],
        //       $info["inference_dot_label"]);

        if (($info["num_statuses"] == 1) && ($info["statuses"][0] == "IN")) {
            printf("%s [label=\"%s:%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"], $info["statuses"][0]);
        } else if (($info["num_statuses"] == 1) &&
                   ($info["statuses"][0] == "OUT")) {
            printf("%s [label=\"%s:%s : %s\", style=\"filled\", fillcolor=grey, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"], $info["statuses"][0]);
        } else if (($info["num_statuses"] == 1) &&
                   ($info["statuses"][0] == "UNDEC")) {
            printf("%s [label=\"%s:%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"], $info["statuses"][0]);
        } else {
            printf("%s [label=\"%s:%s : %s\", style=\"dotted, filled\" shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"],
                   implode(", ", $info["statuses"]));
        }
    }
}

/** @page dotgen_argument_low_impl
 *
 *  + Create arrows between beliefs (fact or inference to inference) that are
 * NOT both part of this argument ($argumentID), i.e., belief arrows not
 * in $arg_belief_arrows
 */
foreach ($belief_arrows as $id=>$info) {
    if (array_key_exists($id, $arg_belief_arrows) == FALSE) {
        if ($info["from_rule"] == 0) {
            printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["from_dot_label"], "inference".$info["to_id"]);
                   //$info["from_dot_label"], $info["to_dot_label"]);
        } else {
            printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["from_dot_label"], "inference".$info["to_id"]);
                   //$info["from_dot_label"], $info["to_dot_label"]);
        }
    }
}

/** @page dotgen_argument_low_impl
 *
 *  + Create arrows for attacks (rebut and undermine) that are NOT both part
 * of this argument ($argumentID), i.e., attack arrows not in
 * $arg_attack_arrows
 */
foreach ($attack_arrows as $id=>$info) {
    if (array_key_exists($id, $arg_attack_arrows) == FALSE) {
        printf("%s -> %s [label=%s color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["from_dot_label"], $info["to_dot_label"],
               $info["attack_type"]);
    }
}

/** @page dotgen_argument_low_impl
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

/** @page dotgen_argument_low_impl
 *
 *  + Create arrows between agents and their direct facts that are NOT both
 * part of this argument ($argumentID), i.e., agent to direct fact arrows
 * not in $arg_agent_fact_arrows
 */
foreach ($agent_belief_arrows as $id=>$info) {
    if (array_key_exists($id, $arg_agent_belief_arrows) == FALSE) {
        printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["from_dot_label"], $info["to_dot_label"]);
    }
}

?>
    }
}
