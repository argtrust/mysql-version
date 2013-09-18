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
/** @page dotgen_argument_impl Implementation Details: arguments_low.php
 * arguments_high.php: 
 * File that generates dot file for low level view of arguments. 
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
 * * Find belief IDs that are part of this argument ($arg_beliefIDs) and
 * those that are not part of this argument ($not_arg_beliefIDs). Use
 * $arguments[$argumentID]["beliefIDs"] and $qagnt_beliefs.
 */
$arg_beliefIDs = $arguments[$argumentID]["beliefIDs"];
$beliefIDs = array_keys($qagnt_beliefs);
$not_arg_beliefIDs = array_diff($beliefIDs, $arg_beliefIDs);
//printf("//arg_beliefIDs = (%s), not_arg_beliefIDs = (%s)\n",
//       implode(", ", $arg_beliefIDs), implode(", ", $not_arg_beliefIDs));

/** @page dotgen_argument_impl
 *
 * * Draw all elements associated with this argument ID ($argumentID)
 */


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
 *  Create rule nodes that are argument conclusions and that are part of
 * this argument ($argumentID)
 */
foreach ($arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 1) &&
        ($qagnt_beliefs[$id]["end_argument"] == 1)) {
        $info = & $qagnt_beliefs[$id];
        /*printf("%s [label=\"%s:%s\", shape=box3d, fillcolor=lightblue, fontsize=35, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["rule_dot_label"],
               $info["rule_display"], $info["level"]);
        printf("%s -> %s [color=darkgreen, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["rule_dot_label"],
               $info["inference_dot_label"]);*/

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
 *  + Create rule nodes that are argument conclusions and that are NOT part of
 * this argument ($argumentID)
 */
foreach ($not_arg_beliefIDs as $id) {
    if (($qagnt_beliefs[$id]["is_rule"] == 1) &&
        ($qagnt_beliefs[$id]["end_argument"] == 1)) {
        $info = & $qagnt_beliefs[$id];
        /*printf("%s [label=\"%s:%s\", shape=box3d, fillcolor=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["rule_dot_label"],
               $info["rule_display"], $info["level"]);
        printf("%s -> %s [color=grey, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
               $info["rule_dot_label"],
               $info["inference_dot_label"]);*/

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