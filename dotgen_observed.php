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
/** @page dotgen_observed_impl Implementation Details: dotgen_observed.php
 * dotgen_observed.php: 
 * File that generates dot file highlighting all the elements associated with
 * the user selected fact within the "Observed Knowledge" radio elements.
 *
 * Generates dot file highlighting all the elements associated with the user
 * selected fact or observed knowledge starting from agent posing question
 * using data structures defined in file datagen_db.php. Those elements not
 * fully contained in the selected fact/observed knowledge are greyed out.
 */


$agentIDs = array_keys($agents);
/** @page dotgen_observed_impl
 *
 * * Use $agents_assoc_qagnt_facts to obtain all agents that have this fact ID
 * ($beliefID) as part of their beliefs either directly or indirectly. Populate
 * $agents_not_assoc_beliefID with those agents that don't have this fact as
 * part of their direct or indirect beliefs.
 */
$agents_not_assoc_beliefID = array_diff($agentIDs,
                                        $agents_assoc_qagnt_facts[$beliefID]);

/** @page dotgen_observed_impl
 *
 * * Draw all elements that lead to this fact or observed knowledge
 * ($beliefID)
 */

/** @page dotgen_observed_impl
 *
 *  + Create agents associated (even indirectly) with this $beliefID (which
 * is a fact)
 */
foreach ($agents_assoc_qagnt_facts[$beliefID] as $id) {
    printf("%s [label=%s, fontsize=80, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $agents[$id]["dot_label"], $agents[$id]["name"]);
}

/** @page dotgen_observed_impl
 *
 *  + Create arrows between agents so that the trusted agents are part of
 * the agents that have this fact in their beliefs
 */
foreach ($agent_arrows_to as $to=>$info) {
    if (in_array($to, $agents_assoc_qagnt_facts[$beliefID])) {
        foreach ($info as $from => $from_to_arrow) {
            printf("%s -> %s [color=yellow, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n", 
                   $from_to_arrow["from_dot_label"],
                   $from_to_arrow["to_dot_label"]);
        }
    }
}

/** @page dotgen_observed_impl
 *
 *  + Create this fact node (with id $beliefID) (which can be either an end
 * or not of an argument)
 */
if ($qagnt_facts[$beliefID]["end_argument"] == 0) {
    printf("%s [label=\"%s:%s\", shape=box, fillcolor=lightcyan, fontsize=60, height=\"1.5\", width=9.5, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $qagnt_facts[$beliefID]["dot_label"],
           $qagnt_facts[$beliefID]["logic_display"],
           min($qagnt_facts[$beliefID]["levels"]));
} else {
    $info = $qagnt_facts[$beliefID];
    if ($info["num_statuses"] == 1) {
        if ($info["statuses"][0] == "IN") {
            printf("%s [label=\"%s:%s : %s\", shape=box, fillcolor=palegreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), $info["statuses"][0]);
        }else if($info["statuses"][0] == "OUT") {
            printf("%s [label=\"%s:%s : %s\", style=\"filled\", fillcolor=pink, shape=box, href=\"javascript:void(0)\",
onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), $info["statuses"][0]);
        }else if($info["statuses"][0] == "UNDEC") {
            printf("%s [label=\"%s:%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"], $info["logic_display"],
                   min($info["levels"]), $info["statuses"][0]);
        }
    } else {
        $statuses = implode(", ", $info["statuses"]);
        printf("%s [label=\"%s:%s : %s\", style=\"dotted, filled\" shape=box, fillcolor=lemonchiffon, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["dot_label"], $info["logic_display"],
               min($info["levels"]), $statuses);
    }
}

/** @page dotgen_observed_impl
 *
 *  + Create arrows between agents who have as their direct belief this fact
 * ($beliefID)
 */
foreach ($agent_fact_arrows_to[$beliefID] as $from=>$info) {
    printf("%s -> %s [color=crimson, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $info["from_dot_label"], $info["to_dot_label"]);
}


?>
        }
<?php
/** @page dotgen_observed_impl
 *
 * * Draw all elements that have not been drawn. Grey out all these elements.
 */

/** @page dotgen_observed_impl
 *
 *   + Create agents that are not associated with this fact ($beliefID)
 */
foreach ($agents_not_assoc_beliefID as $id) {
    printf("%s [label=%s, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $agents[$id]["dot_label"], $agents[$id]["name"]);
}

/** @page dotgen_observed_impl
 *
 *  + Create other fact nodes with id NOT $beliefID (that can be either end
 * of an argument or not)
 */
foreach ($qagnt_facts as $id=>$info) {
    if ($id != $beliefID) {
        if ($info["end_argument"] == 0) {
            printf("%s [label=\"%s:%s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["dot_label"],
                   $info["logic_display"],
                   min($info["levels"]));
        } else {
            if ($info["num_statuses"] == 1) {
                printf("%s [label=\"%s:%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $info["dot_label"], $info["logic_display"],
                       min($info["levels"]), $info["statuses"][0]);
            } else {
                $statuses = implode(", ", $info["statuses"]);
                printf("%s [label=\"%s:%s : %s\", style=\"dotted, filled\" shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                       $info["dot_label"], $info["logic_display"],
                       min($info["levels"]), $statuses);
            }
        }
    }
}

/** @page dotgen_observed_impl
 *
 *   + Create rule nodes for agentID posing question that aren't argument ends
 */
foreach ($qagnt_rules_not_end_argument as $id=>$info) {
    printf("%s [label=\"%s:%s\", shape=box3d, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $info["rule_dot_label"], $info["rule_display"], $info["level"]);
    printf("%s [label=\"%s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $info["inference_dot_label"], $info["inference_display"]);
    printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $info["rule_dot_label"], $info["inference_dot_label"]);
}


/** @page dotgen_observed_impl
 *
 *  + Create rule nodes for agentID posing question that are argument
 * conclusions
 */
foreach ($qagnt_rules_end_argument as $id=>$info) {
      printf("%s [label=\"%s:%s\", shape=box3d, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
             $info["rule_dot_label"], $info["rule_display"], $info["level"]);
    printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $info["rule_dot_label"], $info["inference_dot_label"]);
    if ($info["num_statuses"] == 1) {
        if($info["statuses"][0] == "IN") {
            printf("%s [label=\"%s:%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"], $info["statuses"][0]);
        } else if ($info["statuses"][0] == "OUT") {
            printf("%s [label=\"%s:%s : %s\", style=\"filled\", fillcolor=grey, shape=box, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"], $info["statuses"][0]);
        } else if ($info["statuses"][0] == "UNDEC") {
            printf("%s [label=\"%s:%s : %s\", shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["inference_dot_label"], $info["inference_display"],
                   $info["level"], $info["statuses"][0]);
        }
    } else {
        $statuses = implode(", ", $info["statuses"]);
        printf("%s [label=\"%s:%s : %s\", style=\"dotted, filled\" shape=box, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["inference_dot_label"], $info["inference_display"],
               $info["level"], $statuses);
      }
}


/** @page dotgen_observed_impl
 *
 *   + Create arrows between beliefs
 */
foreach ($belief_arrows as $id=>$info) {
    // YUP: both if and else arrows are the same code but
    // $info["from_dot_label"] differ and potentially we can do sthg
    // different!
    if ($info["from_rule"] == 0) {
        printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["from_dot_label"], $info["to_dot_label"]);
    } else {
        printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["from_dot_label"], $info["to_dot_label"]);
    }
}

/** @page dotgen_observed_impl
 *
 *   + Create arrows for attacks (rebut and undermine)
 */
foreach ($attack_arrows as $id=>$info) {
    printf("%s -> %s [label=%s color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $info["from_dot_label"],$info["to_dot_label"],$info["attack_type"]);
}

/** @page dotgen_observed_impl
 *
 *  + Create arrows between agents and their direct facts that do have id
 * $beliefID
 */
foreach ($agent_fact_arrows_to as $id=>$arrow_info) {
    if ($id != $beliefID) {
        foreach ($arrow_info as $from=>$info) {
            printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
                   $info["from_dot_label"], $info["to_dot_label"]);
        }
    }
}


/** @page dotgen_observed_impl
 *
 *  + Create arrows between agents with trusted agents that are NOT part of
 * the agents that have this fact ($beliefID) in their beliefs
 */
foreach ($agent_arrows_to as $to=>$info) {
    if (in_array($to, $agents_not_assoc_beliefID)) {
        foreach ($info as $from => $from_to_arrow) {
            printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n", 
                   $from_to_arrow["from_dot_label"],
                   $from_to_arrow["to_dot_label"]);
        }
    }
}

?>
    }
}
