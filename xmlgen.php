<?php
printf("<argtrust>");
/** @page dotgen_hw_impl Implementation Details: dotgen_hw.php
 * dotgen_hw.php: 
 * File that generates dot file containing the "Scenario Overview" with all
 * arguments (outcomes).
 *
 * Generates dot file containing the "Scenario Overview" starting from agent
 * posing question with all relevant generated arguments using data structures
 * defined in file datagen_db.php.
 */


/** @page dotgen_hw_impl
 *
 * * Create agents nodes
 */
printf("<agents>\n");
foreach ($agents as $agent_id => $agent_info) {
    printf("<agent id=%s>%s</agent>", $agent_info["dot_label"], $agent_info["name"]);
}
printf("</agents>\n");

/** @page dotgen_hw_impl
 *
 * * Create fact nodes for agentID posing question that aren't ends of
 * arguments
 */

printf("<beliefs>\n");
foreach ($qagnt_facts_not_end_argument as $id => $info) {
    printf("<belief id=%s level=%s>%s</belief>" , $info["dot_label"], min($info["levels"]), $info["logic_display"]);
}

/** @page dotgen_hw_impl
 *
 * * Create fact nodes for agentID posing question that are argument
 * conclusions
 */
foreach ($qagnt_facts_end_argument as $id => $info) {
    if ($info["num_statuses"] == 1) {
	    printf("<belief id=%s level=%s status=%s>%s</belief>" ,$info["dot_label"], min($info["levels"]), $info["statuses"][0], $info["logic_display"]);
    } else {
        $statuses = implode(", ", $info["statuses"]);
	printf("<belief id=%s level=%s status=%s>%s</belief>" ,min($info["levels"]), $info["dot_label"],  $statuses, $info["logic_display"]);
    }
}

/** @page dotgen_hw_impl
 *
 * * Create rule nodes for agentID posing question that aren't argument ends
 */
foreach ($qagnt_rules_not_end_argument as $id=>$info) {
    printf("<belief id=%s level=%s><rule>%s</rule>",
           $info["rule_dot_label"], $info["level"], $info["rule_display"]);
    printf("<conclusion id=%s>%s</conclusion>",
           $info["inference_dot_label"], $info["inference_display"]);
    printf("</belief>");
}

/** @page dotgen_hw_impl
 *
 * * Create rule nodes for agentID posing question that are argument
 * conclusions
 */
foreach ($qagnt_rules_end_argument as $id=>$info) {
    printf("<belief id=%s level=%s><rule>%s</rule>",
           $info["rule_dot_label"], $info["level"], $info["rule_display"]);
    if ($info["num_statuses"] == 1) {
        printf("<conclusion id=%s status=%s>%s</conclusion>",
    	       $info["inference_dot_label"],  $info["statuses"][0], $info["inference_display"]);
    }else{
        $statuses = implode(", ", $info["statuses"]);
        printf("<conclusion id=%s status=%s>%s</conclusion>",
    	       $info["inference_dot_label"],  $statuses, $info["inference_display"]);
    }
    printf("</belief>");

}
printf("</beliefs>\n");
/** @page dotgen_hw_impl
 *
 * * Create arrows for attacks (rebut and undermine)
 */
printf("<attacks>");
foreach ($attack_arrows as $id=>$info) {
    printf("<attack><from>%s</from><to>%s</to><type>%s</type></attack>",
           $info["from_dot_label"],$info["to_dot_label"],$info["attack_type"]);
}
printf("</attacks>");
printf("</argtrust>");

?>