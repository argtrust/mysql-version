<?php
/** @file datagen_db.php
 * @brief File that extracts data structures from the trust database.
 *
 * Contains declarations of all the data structures that can be used by the
 * dotgen files.
 */

/** @brief int \$debug: Output debug information (=1) or not (=0) into file
*          $sessionID".debug"
*/
$debug = 0;

/** @brief array $agents: key=id_val contains array of scenario agent info.
 * 
 * $agents[id_val] = array("name"=>agent name string,
 *                         "dot_label"=>label string used in dot file)
 */
$agents = array ();
/** @brief int \$num_agents: number of entries in $agents.
 *
 * Number of agents contained in scenario. NOTE: not used and can be removed.
 */
$num_agents = 0;

/** @brief array $qagnt_beliefs: key=id_val holds array of information
 *         contained in $qagnt_facts and $qagnt_rules.
 *
 * $qagnt_beliefs[id_val] = reference to an entry either in $qagnt_facts or
 *                          $qagnt_rules.
 */
$qagnt_beliefs = array ();
/** @brief int \$num_qagnt_beliefs: number of entries in $qagnt_beliefs.
 *
 * Number of beliefs reachable by agent who poses question either directly or
 * indirectly through other agents. NOTE: not used and can be removed.
 */
$num_qagnt_beliefs = 0;

/** @brief array $qagnt_facts: key=id_val stores array of information
 *         contained in $qagnt_facts_not_end_argument and
 *         $qagnt_facts_end_argument.
 *
 * $qagnt_facts[id_val] = reference to an entry either in
 *                  $qagnt_facts_not_end_argument or $qagnt_facts_end_argument.
 */
$qagnt_facts = array ();
/** @brief int \$num_qagnt_facts: number of entries in $qagnt_facts.
 *
 * Number of facts reachable by agent posing question either directly or
 * indirectly through other agents. NOTE: not used and can be removed.
 */
$num_qagnt_facts = 0;

/** @brief array $qagnt_rules: key=id_val stores array of information contained
 *         in $qagnt_rules_not_end_argument and $qagnt_rules_end_argument.
 *
 * $qagnt_rules[id_val] = reference to an entry either in
 *                  $qagnt_rules_not_end_argument or $qagnt_rules_end_argument.
 */
$qagnt_rules = array ();
/** @brief int \$num_qagnt_rules: number of entries in $qagnt_rules.
 *
 * Number of rules reachable by agent posing question either directly or
 * indirectly through other agents. NOTE: not used and can be removed.
 */
$num_qagnt_rules = 0;

/** @brief array $qagnt_facts_not_end_argument: key=id_val contains array of
 *         facts reachable by agent posing question that are not ends of
 *         arguments.
 *
 * $qagnt_facts_not_end_argument[id_val] = array("predicate"=>string,
 *    "constant"=>string, "is_negated"=>string, "logic_display"=>string,
 *    "num_paths"=>int, "levels"=>array(of size num_paths), "is_rule"=>0,
 *    "end_argument"=>0, "dot_label"=>string)
 *
 * NOTE: a fact can be reached by agent posing question from many different
 * paths through different agents. Hence key "num_paths" and corresponding
 * number of "levels".
 *
 * TODO (potential bug): There could be a case when the direct or indirect
 * belief levels from agent posing question are the same but the fact is
 * reached from 2 or more paths and this will not be caught.
 */
$qagnt_facts_not_end_argument = array ();
/** @brief int \$num_qagnt_facts_not_end_argument: number of entries in
 *         $qagnt_facts_not_end_argument.
 *
 * Number of facts reachable by agent posing question either directly or
 * indirectly through other agents that are not end of arguments. NOTE: not
 * used and can be removed.
 */
$num_qagnt_facts_not_end_argument = 0;

/** @brief array $qagnt_facts_end_argument: key=id_val contains array of facts
 *         reachable by agent posing question that are ends of arguments.
 *
 * $qagnt_facts_end_argument[id_val] = array ("predicate"=>string,
 *    "constant"=>string, "is_negated"=>string, "logic_display"=>string,
 *    "is_rule"=>0, "end_argument"=>1, "dot_label"=>string,
 *    "num_paths"=>int, "levels"=>array(of size num_paths),
 *    "num_statuses"=>int, "statuses"=>array(string))
 *
 * NOTE: statuses[i] can be 'IN', 'OUT', 'UNDEC'
 */
$qagnt_facts_end_argument = array ();
/** @brief int \$num_qagnt_facts_end_argument: number of entries in
 *         $qagnt_facts_end_argument.
 *
 * Number of facts reachable by agent posing question either directly or
 * indirectly through other agents that are end of arguments. NOTE: not used
 * and can be removed.
 */
$num_qagnt_facts_end_argument = 0;

/** @brief array $agents_assoc_qagnt_facts: key=id_val stores array of agentID's
 *         that have this fact as part of their beliefs either directly or
 *         indirectly.
 *
 * $agents_assoc_qagnt_facts[fact_id_val] = array(agent_ids)
 */
$agents_assoc_qagnt_facts = array ();

/** @brief array $qagnt_rules_not_end_argument: key=id_val contains array of
 *         rules reachable by agent posing question that are not ends of
 *         arguments.
 *
 * $qagnt_rules_not_end_argument[id_val] = array ("predicate"=>string,
 *    "constant"=>string, "is_negated"=>string, "inference_display"=>string,
 *    "level"=>string, "is_rule"=>1, "end_argument"=>0, "num_premises"=>int,
 *    "premises"=>array("predicate"=>string, "constant"=>string,
 *                      "is_negated"=>string, "logic_display"=>string),
 *    "premises_display"=>string, "rule_display"=>string,
 *    "inference_dot_label"=>string, "rule_dot_label"=>string)
 *
 * NOTE: inference is obtained by a rule from premises.
 */
$qagnt_rules_not_end_argument = array ();
/** @brief int \$num_qagnt_rules_not_end_argument: number of entries in
 *         $qagnt_rules_not_end_argument.
 *
 * Number of rules reachable by agent posing question either directly or
 * indirectly through other agents that are not end of arguments. NOTE: not
 * used and can be removed.
 */
$num_qagnt_rules_not_end_argument = 0;

/** @brief array $qagnt_rules_end_argument: key=id_val contains array of rules
 *        reachable by agent posing question that are ends of arguments.
 *
 * $qagnt_rules_end_argument[id_val] = array ("predicate"=>string,
 *    "constant"=>string, "is_negated"=>string, "inference_display"=>string,
 *    "is_rule"=>1, "end_argument"=>1, "level"=>string, "num_premises"=>int,
 *    "premises"=>array("predicate"=>string, "constant"=>string,
 *                      "is_negated"=>string, "logic_display"=>string),
 *    "premises_display"=>string, "rule_display"=>string,
 *    "num_statuses"=>int, "statuses"=>array(string),
 *    "inference_dot_label"=>string, "rule_dot_label"=>string)
 *
 * NOTE: statuses[i] can be 'IN', 'OUT', 'UNDEC'
 */
$qagnt_rules_end_argument = array ();
/** @brief int \$num_qagnt_rules_end_argument: number of entries in
 *         $qagnt_rules_end_argument.
 *
 * Number of rules reachable by agent posing question either directly or
 * indirectly through other agents that are end of arguments. NOTE: not used
 * and can be removed.
 */
$num_qagnt_rules_end_argument = 0;

/** @brief array $belief_arrows: key=fromID."_".toID contains array of arrow
 *               information between beliefs.
 *
 * $belief_arrows[fromID_toID] = array("from_id"=>string,
 *     "from_dot_label"=>string, "from_rule"=>string ("1" or "0"),
 *     "from_ref"=>(reference to $qagnt_beliefs[fromID]), "to_id"=>string,
 *     "to_dot_label"=>string, "to_ref"=>(reference to $qagnt_beliefs[toID]))
 */
$belief_arrows = array();
/** @brief int \$num_belief_arrows: number of entries in $belief_arrows.
 *         NOTE: not used and can be removed.
 */
$num_belief_arrows = 0;
/** @brief array $belief_arrows_from: key=fromID contains array of belief
 *         arrows' information that emanate/start from belief ID (fromID).
 *
 * $belief_arrows_from[fromID] = array(toID=>reference to
 *                                     $belief_arrows[fromID."_".toID])
 */
$belief_arrows_from = array();
/** @brief int \$num_belief_arrows_from: number of entries in
 *         $belief_arrows_from. NOTE: not used and can be removed.
 */
$num_belief_arrows_from = 0;
/** 
 * @brief array $belief_arrows_to: key=toID stores array of belief arrows'
 *        information that end at belief ID (toID).
 *
 * $belief_arrows_to[toID] = array(fromID=>reference to
 *                                 $belief_arrows[fromID."_".toID])
 */
$belief_arrows_to = array();
/** @brief int \$num_belief_arrows_to: number of entries in $belief_arrows_to.
 *         NOTE: not used and can be removed.
 */
$num_belief_arrows_to = 0;

/** @brief array $attack_arrows: key=fromID."_".toID stores array of arrow
 *         information regarding belief with id fromID that rebuts or
 *         undermines the belief with id toID.
 *
 * $attack_arrows[fromID_toID] = array ("from_id"=>string,
 *    "from_dot_label"=>string, "from_rule"=>string (0 or 1 if rule),
 *    "from_ref"=>(reference to $qagnt_beliefs[fromID]), "to_id"=>string,
 *    "to_dot_label"=>string, "to_rule"="string("0 or "1" if rule),
 *    "to_ref"=>(reference to $qagnt_beliefs[toID]),
 *    "attack_type"=>string("rebut" or "undermine"))
 */
$attack_arrows = array ();
/** @brief int \$num_attack_arrows: number of entries in $attack_arrows.
 *         NOTE: not used and can be removed.
 */
$num_attack_arrows = 0;

/** @brief array $agent_arrows: key=fromID."_".toID stores array of arrow
 *         information regarding agents with fromID that directly trust
 *         agents with toID.
 *
 * $agent_arrows[fromID_toID] = array("from_id"=>string,
 *     "from_dot_label"=>string, "from_ref"=>(reference to $agents[fromID]),
 *     "to_id"=>string, "to_dot_label"=>string, "to_ref"=>(reference to
 *     $agents[toID]), "level"=>string)
 */
$agent_arrows = array();
/** @brief int \$num_agent_arrows: number of entries in $agent_arrows.
 *         NOTE: not used and can be removed.
 */
$num_agent_arrows = 0;
/** @brief array $agent_arrows_from: key=fromID stores array of agent arrows'
 *         information that emanate/start from agent ID (fromID).
 *
 * $agent_arrows_from[fromID] = array(toID=>reference to
 *                                    $agent_arrows[fromID."_".toID])
 */
$agent_arrows_from = array();
/** @brief int \$num_agent_arrows_from: number of entries in
 *         $agent_arrows_from. NOTE: not used and can be removed.
 */
$num_agent_arrows_from = 0;
/** @brief array $agent_arrows_to: key=toID stores array of agent arrows'
 *         information that end at agent ID (toID).
 *
 * $agent_arrows_to[toID] = array(fromID=>reference to
 *                                $agent_arrows[fromID."_".toID])
 */
$agent_arrows_to = array();
/** @brief int \$num_agent_arrows_to: number of entries in $agent_arrows_to.
 *         NOTE: not used and can be removed.
 */
$num_agent_arrows_to = 0;

/** @brief array $agent_fact_arrows: key=fromID."_".toID stores array of
 *         arrow information connecting agent (with id fromID) to it's direct
 *         facts (with id toID).
 *
 * $agent_fact_arrows[fromID_toID] = array("from_id"=>string,
 *    "from_dot_label"=>string, "from_ref"=>(reference to $agents[fromID]),
 *    "to_id"=>string, "to_dot_label"=>string, "to_rule"=>string(0 or 1),
 *    "to_ref"=>(reference to $qagnt_beliefs[toID]), "level"=>string)
 *
 * NOTE: "to_rule" is always "0"
 */
$agent_fact_arrows = array();
/** @brief int \$num_agent_fact_arrows: number of entries in 
 *         $agent_fact_arrows. NOTE: not used and can be removed.
 */
$num_agent_fact_arrows = 0;
/** @brief array $agent_fact_arrows_from: key=fromID stores array of agent to
 *         fact arrows' information that start from agent ID (fromID).
 *
 * $agent_fact_arrows_from[fromID] = array(toID=>reference to
 *                                     $agent_fact_arrows[fromID."_".toID])
 */
$agent_fact_arrows_from = array();
/** @brief int \$num_agent_fact_arrows_from: number of entries in 
 *         $agent_fact_arrows_from. NOTE: not used and can be removed.
 */
$num_agent_fact_arrows_from = 0;
/** @brief array $agent_fact_arrows_to: key=toID stores array of agent to
 *         fact arrows' information that end at belief ID (toID).
 *
 * $agent_fact_arrows_to[toID] = array(fromID=>reference to
 *                                     $agent_fact_arrows[fromID."_".toID])
 */
$agent_fact_arrows_to = array();
/** @brief int \$num_agent_fact_arrows_to: number of entries in 
 *         $agent_fact_arrows_to. NOTE: not used and can be removed.
 */
$num_agent_fact_arrows_to = 0;

/** @brief array $agent_rule_arrows: key=fromID."_".toID stores array of
 *         arrow information connecting agent (with id fromID) to it's direct
 *         rules (with id toID).
 *
 * $agent_rule_arrows[fromID_toID] = array("from_id"=>string,
 *    "from_dot_label"=>string, "from_ref"=>(reference to $agents[fromID]),
 *    "to_id"=>string, "to_dot_label"=>string, "to_rule"=>string(0 or 1),
 *    "to_ref"=>(reference to $qagnt_beliefs[toID]), "level"=>string)
 *
 * NOTE: "to_rule" is always "1"
 */
$agent_rule_arrows = array();
/** @brief int \$num_agent_rule_arrows: number of entries in 
 *         $agent_rule_arrows. NOTE: not used and can be removed.
 */
$num_agent_rule_arrows = 0;
/** @brief array $agent_rule_arrows_from: key=fromID stores array of agent to
 *         rule arrows' information that start from agent ID (fromID).
 *
 * $agent_rule_arrows_from[fromID] = array(toID=>reference to
 *                                     $agent_rule_arrows[fromID."_".toID])
 */
$agent_rule_arrows_from = array();
/** @brief int \$num_agent_rule_arrows_from: number of entries in 
 *         $agent_rule_arrows_from. NOTE: not used and can be removed.
 */
$num_agent_rule_arrows_from = 0;
/** @brief array $agent_rule_arrows_to: key=toID stores array of agent to
 *         rule arrows' information that end at belief ID (toID).
 *
 * $agent_rule_arrows_to[toID] = array(fromID=>reference to
 *                                     $agent_rule_arrows[fromID."_".toID])
 */
$agent_rule_arrows_to = array();
/** @brief int \$num_agent_rule_arrows_to: number of entries in 
 *         $agent_rule_arrows_to. NOTE: not used and can be removed.
 */
$num_agent_rule_arrows_to = 0;

/** @brief array agent_argument_arrows:  
 */
$agent_argument_arrows = array();

/** @brief array fact_argument_arrows:  
 */
$fact_argument_arrows = array();



/** @brief array $arguments: key=argument_id stores array of argument
 *         information.
 *
 * $arguments[id_val] = array("level"=>string, "status"=>string,
 *     "conclusion_display"=>string, "num_agentIDs"=>int,
 *     "agentIDs"=>array(agent_ids),
 *     "num_beliefIDs"=>int, beliefIDs=>array(belief_ids))
 */
$arguments = array ();
/** @brief int \$num_arguments: number of entries in $arguments. NOTE: not
 *         used and can be removed.
 */
$num_arguments = 0;

/** @page datagen_db_impl Implementation Details: datagen_db.php
 *
 * * Create agents data structure: Fill in $agents and $num_agents.
 */

$sql="SELECT DISTINCT agentID, agentName FROM agents 
         INNER JOIN agent_trust on (trustingAgent = agentID or trustedAgent = agentID) 
         where sessionID = '".$sessionID."' and timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $agents[$row[0]] = array("name"=>$row[1], "dot_label"=>"agent".$row[0]);
        if ($debug) {
            printf("//agents[%s] = %s\n", $row[0], $agents[$row[0]]["name"]);
        }
        $num_agents++;
    }
}
mysqli_free_result($result);
if ($debug == 1) {
    printf("//num_agents=%d or %d\n", $num_agents, count($agents));
}

/** @page datagen_db_impl
 *
 * * Create facts data structure for the agentID that poses the question
 * (called "qagnt") that aren't ends of arguments.
 * Fill in $qagnt_facts_not_end_argument and $num_qagnt_facts_not_end_argument
 * as well as partially build $qagnt_facts, $qagnt_beliefs, $num_qagnt_facts,
 * and $num_qagnt_beliefs.
 */
$sql="select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, round(level*100),
        p.name, c.name, b.isNegated
        from beliefs b
        inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
        inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
        inner join predicates p on p.predicateID = pc.predicateID
        inner join constants c on pc.constantID = c.constantID 
        inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
        inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
        where ab.agentID = q.agentID and b.isRule = 0 and a.isSupported = 1
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
        if (array_key_exists($row[0], $qagnt_facts_not_end_argument)) {
            $num_paths = $qagnt_facts_not_end_argument[$row[0]]["num_paths"];
            $qagnt_facts_not_end_argument[$row[0]]["levels"][$num_paths] = $row[2];
            $qagnt_facts_not_end_argument[$row[0]]["num_paths"] = $num_paths+1;
        } else {
            $qagnt_facts_not_end_argument[$row[0]] = array ();
            $qagnt_facts_not_end_argument[$row[0]]["dot_label"] = "fact".$row[0];
            $qagnt_facts_not_end_argument[$row[0]]["logic_display"] = $row[1];
            $qagnt_facts_not_end_argument[$row[0]]["num_paths"] = 1;
            $qagnt_facts_not_end_argument[$row[0]]["levels"] = array($row[2]);
            $qagnt_facts_not_end_argument[$row[0]]["predicate"] = $row[3];
            $qagnt_facts_not_end_argument[$row[0]]["constant"] = $row[4];
            $qagnt_facts_not_end_argument[$row[0]]["is_negated"] = $row[5];
            $qagnt_facts_not_end_argument[$row[0]]["is_rule"] = 0;
            $qagnt_facts_not_end_argument[$row[0]]["end_argument"] = 0;
            $qagnt_facts[$row[0]] = & $qagnt_facts_not_end_argument[$row[0]];
            $qagnt_beliefs[$row[0]] = & $qagnt_facts_not_end_argument[$row[0]];
            $num_qagnt_facts_not_end_argument++;
            $num_qagnt_facts++;
            $num_qagnt_beliefs++;
        }
        if ($debug) {
            printf("//qagnt_facts_not_end_argument[%s]: is_negated=%s, pred=%s, const=%s, logic='%s', is_rule=%d, end_argument=%d, num_paths=%s, levels=(%s)\n",
                   $row[0],
                   $qagnt_facts_not_end_argument[$row[0]]["is_negated"],
                   $qagnt_facts_not_end_argument[$row[0]]["predicate"],
                   $qagnt_facts_not_end_argument[$row[0]]["constant"],
                   $qagnt_facts_not_end_argument[$row[0]]["logic_display"],
                   $qagnt_facts_not_end_argument[$row[0]]["is_rule"],
                   $qagnt_facts_not_end_argument[$row[0]]["end_argument"],
                   $qagnt_facts_not_end_argument[$row[0]]["num_paths"],
                   implode(", ", $qagnt_facts_not_end_argument[$row[0]]["levels"]));
            printf("//qagnt_facts[%s]: is_negated=%s, pred=%s, const=%s, logic='%s', is_rule=%d, end_argument=%d, num_paths=%s, levels=(%s)\n",
                   $row[0],
                   $qagnt_facts[$row[0]]["is_negated"],
                   $qagnt_facts[$row[0]]["predicate"],
                   $qagnt_facts[$row[0]]["constant"],
                   $qagnt_facts[$row[0]]["logic_display"],
                   $qagnt_facts[$row[0]]["is_rule"],
                   $qagnt_facts[$row[0]]["end_argument"],
                   $qagnt_facts[$row[0]]["num_paths"],
                   implode(", ", $qagnt_facts[$row[0]]["levels"]));
            printf("//qagnt_beliefs[%s]: is_negated=%s, pred=%s, const=%s, logic='%s', is_rule=%d, end_argument=%d, num_paths=%s, levels=(%s)\n",
                   $row[0],
                   $qagnt_beliefs[$row[0]]["is_negated"],
                   $qagnt_beliefs[$row[0]]["predicate"],
                   $qagnt_beliefs[$row[0]]["constant"],
                   $qagnt_beliefs[$row[0]]["logic_display"],
                   $qagnt_beliefs[$row[0]]["is_rule"],
                   $qagnt_beliefs[$row[0]]["end_argument"],
                   $qagnt_beliefs[$row[0]]["num_paths"],
                   implode(", ", $qagnt_beliefs[$row[0]]["levels"]));
        }
    }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_qagnt_facts_not_end_argument=%d or %d\n",
           $num_qagnt_facts_not_end_argument,
           count($qagnt_facts_not_end_argument));
    printf("//num_qagnt_facts=%d or %d\n", $num_qagnt_facts,
           count($qagnt_facts));
    printf("//num_qagnt_beliefs=%d or %d\n", $num_qagnt_beliefs,
           count($qagnt_beliefs));
}

/** @page datagen_db_impl
 *
 * * Create facts data structure for agentID posing question (qagnt) that are
 * argument conclusions, i.e., ends of arguments.
 * Fill in $qagnt_facts_end_argument and $num_qagnt_facts_end_argument as well
 * as add to $qagnt_facts, $qagnt_beliefs, $num_qagnt_facts, and
 * $num_qagnt_beliefs.
 */
$sql="select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, round(pa.level*100), max(pa.status), count(distinct pa.status) as argStatus,
        p.name, c.name, b.isNegated
        from beliefs b
        inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
        inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
        inner join predicates p on p.predicateID = pc.predicateID
        inner join constants c on pc.constantID = c.constantID 
        inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
        inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
        inner join parent_argument pa on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep 
        where ab.agentID = q.agentID and b.isRule = 0 and a.isSupported = 1
        and ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep."
        group by b.beliefID, b.isNegated, p.name, c.name, ab.level";    
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        if (array_key_exists($row[0], $qagnt_facts_end_argument)) {
            $num_paths = $qagnt_facts_end_argument[$row[0]]["num_paths"];
            $qagnt_facts_end_argument[$row[0]]["levels"][$num_paths] = $row[2];
            $qagnt_facts_end_argument[$row[0]]["num_paths"] = $num_paths+1;
        } else {
            $qagnt_facts_end_argument[$row[0]] = array ();
            $qagnt_facts_end_argument[$row[0]]["dot_label"] = "fact".$row[0];
            $qagnt_facts_end_argument[$row[0]]["logic_display"] = $row[1];
            $qagnt_facts_end_argument[$row[0]]["num_paths"] = 1;
            $qagnt_facts_end_argument[$row[0]]["levels"] = array($row[2]);
            // TODO: chk if statutes are updated properly. Do we have to update
            // when array_key_exists is TRUE???
            $qagnt_facts_end_argument[$row[0]]["statuses"] = array($row[3]);
            $qagnt_facts_end_argument[$row[0]]["num_statuses"] = $row[4];
            $qagnt_facts_end_argument[$row[0]]["predicate"] = $row[5];
            $qagnt_facts_end_argument[$row[0]]["constant"] = $row[6];
            $qagnt_facts_end_argument[$row[0]]["is_negated"] = $row[7];
            $qagnt_facts_end_argument[$row[0]]["is_rule"] = 0;
            $qagnt_facts_end_argument[$row[0]]["end_argument"] = 1;
            $qagnt_facts[$row[0]] = & $qagnt_facts_end_argument[$row[0]];
            $qagnt_beliefs[$row[0]] = & $qagnt_facts_end_argument[$row[0]];
            $num_qagnt_facts_end_argument++;
            $num_qagnt_facts++;
            $num_qagnt_beliefs++;
        }
        if($row[4] > 1) {
            $count = 0;
            $sql = "select status 
                    from parent_argument pa
                    inner join arguments a on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and a.timestep = pa.timestep
                    inner join beliefs b on a.beliefID = b.beliefID
                    where pa.sessionID = '".$sessionID."' and pa.timestep = ".$timestep." and b.beliefID = ".$row[0];
            $result2=mysqli_query($link,$sql);
            if ($result2) {
                $qagnt_facts_end_argument[$row[0]]["statuses"] = array();
                while ($row2 = mysqli_fetch_array($result2)) {
                    $qagnt_facts_end_argument[$row[0]]["statuses"][$count] = $row2[0];
                    $count=$count+1;
                }
                $qagnt_facts_end_argument[$row[0]]["num_statuses"] = $count;
            }
            mysqli_free_result($result2);
        }
        if ($debug) {
            printf("//qagnt_facts_end_argument[%s]:  is_negated=%s, pred=%s, const=%s, logic='%s', is_rule=%d, end_argument=%d, num_paths=%s, levels=(%s), num_statuses=%d, statuses=(%s)\n",
                   $row[0],
                   $qagnt_facts_end_argument[$row[0]]["is_negated"],
                   $qagnt_facts_end_argument[$row[0]]["predicate"],
                   $qagnt_facts_end_argument[$row[0]]["constant"],
                   $qagnt_facts_end_argument[$row[0]]["logic_display"],
                   $qagnt_facts_end_argument[$row[0]]["is_rule"],
                   $qagnt_facts_end_argument[$row[0]]["end_argument"],
                   $qagnt_facts_end_argument[$row[0]]["num_paths"],
                   implode(", ", $qagnt_facts_end_argument[$row[0]]["levels"]),
                   $qagnt_facts_end_argument[$row[0]]["num_statuses"],
                   implode(", ", $qagnt_facts_end_argument[$row[0]]["statuses"]));
            printf("//qagnt_facts[%s]:  is_negated=%s, pred=%s, const=%s, logic='%s', is_rule=%d, end_argument=%d, num_paths=%s, levels=(%s), num_statuses=%d, statuses=(%s)\n",
                   $row[0],
                   $qagnt_facts[$row[0]]["is_negated"],
                   $qagnt_facts[$row[0]]["predicate"],
                   $qagnt_facts[$row[0]]["constant"],
                   $qagnt_facts[$row[0]]["logic_display"],
                   $qagnt_facts[$row[0]]["is_rule"],
                   $qagnt_facts[$row[0]]["end_argument"],
                   $qagnt_facts[$row[0]]["num_paths"],
                   implode(", ", $qagnt_facts[$row[0]]["levels"]),
                   $qagnt_facts[$row[0]]["num_statuses"],
                   implode(", ", $qagnt_facts[$row[0]]["statuses"]));
            printf("//qagnt_beliefs[%s]:  is_negated=%s, pred=%s, const=%s, logic='%s', is_rule=%d, end_argument=%d, num_paths=%s, levels=(%s), num_statuses=%d, statuses=(%s)\n",
                   $row[0],
                   $qagnt_beliefs[$row[0]]["is_negated"],
                   $qagnt_beliefs[$row[0]]["predicate"],
                   $qagnt_beliefs[$row[0]]["constant"],
                   $qagnt_beliefs[$row[0]]["logic_display"],
                   $qagnt_beliefs[$row[0]]["is_rule"],
                   $qagnt_beliefs[$row[0]]["end_argument"],
                   $qagnt_beliefs[$row[0]]["num_paths"],
                   implode(", ", $qagnt_beliefs[$row[0]]["levels"]),
                   $qagnt_beliefs[$row[0]]["num_statuses"],
                   implode(", ", $qagnt_beliefs[$row[0]]["statuses"]));
        }
    }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_qagnt_facts_end_argument=%d or %d\n",
           $num_qagnt_facts_end_argument,
           count($qagnt_facts_end_argument));
    printf("//num_qagnt_facts=%d or %d\n",
           $num_qagnt_facts, count($qagnt_facts));
    printf("//num_qagnt_beliefs=%d or %d\n",
           $num_qagnt_beliefs, count($qagnt_beliefs));
}

/** @page datagen_db_impl
 *
 * * Create data structure that stores all agents that have a fact in their
 * beliefs either directly or indirectly. Fill agents_assoc_qagnt_facts.
 */
foreach ($qagnt_facts as $id=>$info) {
    $sql = "select distinct a.agentID from agents a
            inner join agent_has_beliefs ab on ab.agentID = a.agentID
            where ab.sessionID = '".$sessionID."' and ab.timestep = ".$timestep." and ab.beliefID = ".$id.";";
    $result=mysqli_query($link,$sql);
    if ($result) {
        $agents_assoc_qagnt_facts[$id] = array ();
        while ($row = mysqli_fetch_array($result)) {
            $agents_assoc_qagnt_facts[$id][] = $row[0];
        }
        printf("//agents_assoc_qagnt_facts[%s] = (%s)\n", $id,
               implode(", ", $agents_assoc_qagnt_facts[$id]));
    }
}

/** @page datagen_db_impl
 *
 * * Create rules data structure for agentID posing question that aren't
 * argument ends. Fill in $qagnt_rules_not_end_argument and
 * $num_qagnt_rules_not_end_argument as well as partially add to $qagnt_rules,
 * $qagnt_beliefs, $num_qagnt_rules, and $num_qagnt_beliefs.
 */
$sql="select distinct b.beliefID, CASE 
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, round(level*100),
        p.name, c.name, b.isNegated
        from beliefs b
        inner join agent_has_beliefs ab on b.beliefID = ab.beliefID  
        inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
        inner join predicates p on p.predicateID = pc.predicateID
        inner join constants c on pc.constantID = c.constantID 
        inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
        inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
        where ab.agentID = q.agentID and b.isRule = 1 and a.isSupported=1
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
        $qagnt_rules_not_end_argument[$row[0]] = array();
        $qagnt_rules_not_end_argument[$row[0]]["inference_dot_label"] = "inference".$row[0];
        $qagnt_rules_not_end_argument[$row[0]]["rule_dot_label"] = "rule".$row[0];
        $qagnt_rules_not_end_argument[$row[0]]["inference_display"] = $row[1];
        $qagnt_rules_not_end_argument[$row[0]]["level"] = $row[2];
        $qagnt_rules_not_end_argument[$row[0]]["predicate"] = $row[3];
        $qagnt_rules_not_end_argument[$row[0]]["constant"] = $row[4];
        $qagnt_rules_not_end_argument[$row[0]]["is_negated"] = $row[5];
        $qagnt_rules_not_end_argument[$row[0]]["is_rule"] = 1;
        $qagnt_rules_not_end_argument[$row[0]]["end_argument"] = 0;
        $qagnt_rules_not_end_argument[$row[0]]["num_premises"] = 0;
        $qagnt_rules_not_end_argument[$row[0]]["premises"] = array();
        $sql="select CASE 
            WHEN isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
            ELSE concat(p.name,'(',c.name,')') END predicate,
            p.name, c.name, b.isNegated
            from belief_has_premises b
            inner join predicate_has_constant pc on pc.predicateConstantID = b.premiseID
            inner join predicates p on p.predicateID = pc.predicateID
            inner join constants c on pc.constantID = c.constantID 
            where beliefID = ".$row[0].";";
        $return=mysqli_query($link,$sql);
        $premise='';
        $count=0;
        while($innerrow = mysqli_fetch_array($return)) {
            $qagnt_rules_not_end_argument[$row[0]]["premises"][$count]["logic_display"]=$innerrow[0];
            $qagnt_rules_not_end_argument[$row[0]]["premises"][$count]["predicate"]=$innerrow[1];
            $qagnt_rules_not_end_argument[$row[0]]["premises"][$count]["constant"]=$innerrow[2];
            $qagnt_rules_not_end_argument[$row[0]]["premises"][$count]["is_negated"]=$innerrow[3];
              if($count > 0){ $premise .= ", "; }
              $premise .= $innerrow[0];
              $count++;
        }
        mysqli_free_result($return);
        $qagnt_rules_not_end_argument[$row[0]]["num_premises"] = $count;
        $qagnt_rules_not_end_argument[$row[0]]["premises_display"] = $premise;
        $qagnt_rules_not_end_argument[$row[0]]["rule_display"] = $row[1]." :- ".$premise;
        $qagnt_rules[$row[0]] = & $qagnt_rules_not_end_argument[$row[0]];
        $qagnt_beliefs[$row[0]] = & $qagnt_rules_not_end_argument[$row[0]];
        if ($debug) {
            printf("//qagnt_rules_not_end_argument[%s]:, inference(is_negated=%s, pred=%s, const=%s), num_premises=%d, rule_display='%s', is_rule=%d, end_argument=%d, level=%s\n",
                   $row[0],
                   $qagnt_rules_not_end_argument[$row[0]]["is_negated"],
                   $qagnt_rules_not_end_argument[$row[0]]["predicate"],
                   $qagnt_rules_not_end_argument[$row[0]]["constant"],
                   $qagnt_rules_not_end_argument[$row[0]]["num_premises"],
                   $qagnt_rules_not_end_argument[$row[0]]["rule_display"],
                   $qagnt_rules_not_end_argument[$row[0]]["is_rule"],
                   $qagnt_rules_not_end_argument[$row[0]]["end_argument"],
                   $qagnt_rules_not_end_argument[$row[0]]["level"]);
            printf("//qagnt_rules[%s]:, inference(is_negated=%s, pred=%s, const=%s), num_premises=%d, rule_display='%s', is_rule=%d, end_argument=%d, level=%s\n",
                   $row[0],
                   $qagnt_rules[$row[0]]["is_negated"],
                   $qagnt_rules[$row[0]]["predicate"],
                   $qagnt_rules[$row[0]]["constant"],
                   $qagnt_rules[$row[0]]["num_premises"],
                   $qagnt_rules[$row[0]]["rule_display"],
                   $qagnt_rules[$row[0]]["is_rule"],
                   $qagnt_rules[$row[0]]["end_argument"],
                   $qagnt_rules[$row[0]]["level"]);
            printf("//qagnt_beliefs[%s]:, inference(is_negated=%s, pred=%s, const=%s), num_premises=%d, rule_display='%s', is_rule=%d, end_argument=%d, level=%s\n",
                   $row[0],
                   $qagnt_beliefs[$row[0]]["is_negated"],
                   $qagnt_beliefs[$row[0]]["predicate"],
                   $qagnt_beliefs[$row[0]]["constant"],
                   $qagnt_beliefs[$row[0]]["num_premises"],
                   $qagnt_beliefs[$row[0]]["rule_display"],
                   $qagnt_beliefs[$row[0]]["is_rule"],
                   $qagnt_beliefs[$row[0]]["end_argument"],
                   $qagnt_beliefs[$row[0]]["level"]);
        }
        $num_qagnt_rules_not_end_argument++;
        $num_qagnt_rules++;
        $num_qagnt_beliefs++;
    }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_qagnt_rules_not_end_argument=%d or %d\n",
           $num_qagnt_rules_not_end_argument,
           count($qagnt_rules_not_end_argument));
    printf("//num_qagnt_rules=%d or %d\n", $num_qagnt_rules,
           count($qagnt_rules));
    printf("//num_qagnt_beliefs=%d or %d\n", $num_qagnt_beliefs,
           count($qagnt_beliefs));
}

/** @page datagen_db_impl
 *
 * * Create rules data structure for agentID posing question that are argument
 * conclusions , i.e., ends of arguments.  Fill in $qagnt_rules_end_argument
 * and $num_qagnt_rules_end_argument as well as add to $qagnt_rules,
 * $qagnt_beliefs, $num_qagnt_rules, and $num_qagnt_beliefs.
 */
$sql="select distinct b.beliefID, CASE               
        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
        ELSE concat(p.name,'(',c.name,')') END predicate, round(pa.level*100),
        max(pa.status), count(distinct pa.status) as argStatus,
        p.name, c.name, b.isNegated
        from beliefs b
        inner join agent_has_beliefs ab on b.beliefID = ab.beliefID
        inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
        inner join predicates p on p.predicateID = pc.predicateID
        inner join constants c on pc.constantID = c.constantID 
        inner join arguments a on a.beliefID = b.beliefID and ab.sessionID = a.sessionID and ab.timestep=a.timestep
        inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
        inner join parent_argument pa on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep 
        where ab.agentID = q.agentID and b.isRule = 1 and a.isSupported = 1
        and ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep."
        group by b.beliefID, b.isNegated, p.name, c.name, pa.level";
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $qagnt_rules_end_argument[$row[0]] = array();
        $qagnt_rules_end_argument[$row[0]]["inference_dot_label"] = "inference".$row[0];
        $qagnt_rules_end_argument[$row[0]]["rule_dot_label"] = "rule".$row[0];
        $qagnt_rules_end_argument[$row[0]]["inference_display"] = $row[1];
        $qagnt_rules_end_argument[$row[0]]["level"] = $row[2];
        $qagnt_rules_end_argument[$row[0]]["statuses"] = array($row[3]);
        $qagnt_rules_end_argument[$row[0]]["num_statuses"] = $row[4];
        $qagnt_rules_end_argument[$row[0]]["predicate"] = $row[5];
        $qagnt_rules_end_argument[$row[0]]["constant"] = $row[6];
        $qagnt_rules_end_argument[$row[0]]["is_negated"] = $row[7];
        $qagnt_rules_end_argument[$row[0]]["is_rule"] = 1;
        $qagnt_rules_end_argument[$row[0]]["end_argument"] = 1;
        $qagnt_rules_end_argument[$row[0]]["num_premises"] = 0;
        $qagnt_rules_end_argument[$row[0]]["premises"] = array();
        $sql="select CASE 
              WHEN isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') 
              ELSE concat(p.name,'(',c.name,')') END predicate,
              p.name, c.name, b.isNegated
              from belief_has_premises b
              inner join predicate_has_constant pc on pc.predicateConstantID = b.premiseID
              inner join predicates p on p.predicateID = pc.predicateID
              inner join constants c on pc.constantID = c.constantID 
              where beliefID = ".$row[0].";";
        $return=mysqli_query($link,$sql);
        $premise='';
        $count=0;
        while($innerrow = mysqli_fetch_array($return)) {
            $qagnt_rules_end_argument[$row[0]]["premises"][$count]["logic_display"]=$innerrow[0];
            $qagnt_rules_end_argument[$row[0]]["premises"][$count]["predicate"]=$innerrow[1];
            $qagnt_rules_end_argument[$row[0]]["premises"][$count]["constant"]=$innerrow[2];
            $qagnt_rules_end_argument[$row[0]]["premises"][$count]["is_negated"]=$innerrow[3];
            if($count > 0){ $premise .= ", ";}
            $premise .= $innerrow[0];    
            $count++;
        }
        mysqli_free_result($return);
        $qagnt_rules_end_argument[$row[0]]["num_premises"] = $count;
        $qagnt_rules_end_argument[$row[0]]["premises_display"] = $premise;
        $qagnt_rules_end_argument[$row[0]]["rule_display"] = $row[1]." :- ".$premise;
          
        if($row[4] > 1) {
            $count = 0;
            $sql = "select status 
                    from parent_argument pa
                    inner join arguments a on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and a.timestep = pa.timestep
                    inner join beliefs b on a.beliefID = b.beliefID
                    where pa.sessionID = '".$sessionID."' and pa.timestep = ".$timestep." and b.beliefID = ".$row[0];
            $result2=mysqli_query($link,$sql);
            if ($result2) {
                $qagnt_rules_end_argument[$row[0]]["statuses"] = array();
                while ($row2 = mysqli_fetch_array($result2)) {
                    $qagnt_rules_end_argument[$row[0]]["statuses"][$count] = $row2[0];
                    $count=$count+1;
                }
                $qagnt_rules_end_argument[$row[0]]["num_statuses"] = $count;
            }
            mysqli_free_result($result2);
        }
        $qagnt_rules[$row[0]] = & $qagnt_rules_end_argument[$row[0]];
        $qagnt_beliefs[$row[0]] = & $qagnt_rules_end_argument[$row[0]];
        if ($debug) {
            printf("//qagnt_rules_end_argument[%s]: inference(is_negated=%s, pred=%s, const=%s), num_premises=%d, rule_display='%s', is_rule=%d, end_argument=%d, level=%s, num_statuses=%d, statuses=(%s)\n",
                   $row[0],
                   $qagnt_rules_end_argument[$row[0]]["is_negated"],
                   $qagnt_rules_end_argument[$row[0]]["predicate"],
                   $qagnt_rules_end_argument[$row[0]]["constant"],
                   $qagnt_rules_end_argument[$row[0]]["num_premises"],
                   $qagnt_rules_end_argument[$row[0]]["rule_display"],
                   $qagnt_rules_end_argument[$row[0]]["is_rule"],
                   $qagnt_rules_end_argument[$row[0]]["end_argument"],
                   $qagnt_rules_end_argument[$row[0]]["level"],
                   $qagnt_rules_end_argument[$row[0]]["num_statuses"],
                   implode(", ", $qagnt_rules_end_argument[$row[0]]["statuses"]));
            printf("//qagnt_rules[%s]: inference(is_negated=%s, pred=%s, const=%s), num_premises=%d, rule_display='%s', is_rule=%d, end_argument=%d, level=%s, num_statuses=%d, statuses=(%s)\n",
                   $row[0],
                   $qagnt_rules[$row[0]]["is_negated"],
                   $qagnt_rules[$row[0]]["predicate"],
                   $qagnt_rules[$row[0]]["constant"],
                   $qagnt_rules[$row[0]]["num_premises"],
                   $qagnt_rules[$row[0]]["rule_display"],
                   $qagnt_rules[$row[0]]["is_rule"],
                   $qagnt_rules[$row[0]]["end_argument"],
                   $qagnt_rules[$row[0]]["level"],
                   $qagnt_rules[$row[0]]["num_statuses"],
                   implode(", ", $qagnt_rules[$row[0]]["statuses"]));
            printf("//qagnt_beliefs[%s]: inference(is_negated=%s, pred=%s, const=%s), num_premises=%d, rule_display='%s', is_rule=%d, end_argument=%d, level=%s, num_statuses=%d, statuses=(%s)\n",
                   $row[0],
                   $qagnt_beliefs[$row[0]]["is_negated"],
                   $qagnt_beliefs[$row[0]]["predicate"],
                   $qagnt_beliefs[$row[0]]["constant"],
                   $qagnt_beliefs[$row[0]]["num_premises"],
                   $qagnt_beliefs[$row[0]]["rule_display"],
                   $qagnt_beliefs[$row[0]]["is_rule"],
                   $qagnt_beliefs[$row[0]]["end_argument"],
                   $qagnt_beliefs[$row[0]]["level"],
                   $qagnt_beliefs[$row[0]]["num_statuses"],
                   implode(", ", $qagnt_beliefs[$row[0]]["statuses"]));
        }
        $num_qagnt_rules_end_argument++;
        $num_qagnt_rules++;
        $num_qagnt_beliefs++;
    }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_qagnt_rules_end_argument=%d or %d\n",
           $num_qagnt_rules_end_argument, count($qagnt_rules_end_argument));
    printf("//num_qagnt_rules=%d or %d\n", $num_qagnt_rules,
           count($qagnt_rules));
    printf("//num_qagnt_beliefs=%d or %d\n", $num_qagnt_beliefs,
           count($qagnt_beliefs));
}

/** @page datagen_db_impl
 *
 * * Create data structure for arrows between beliefs: Fill in
 * $belief_arrows, $num_belief_arrows, $belief_arrows_from,
 * $num_belief_arrows_from, $belief_arrows_to, and $num_belief_arrows_to.
 */
$sql="select distinct case when b1.isRule = 1 then concat('inference',a.beliefID) else concat('fact',a.beliefID) end fromID, 
    case when b2.isRule = 1 then concat('rule',ab.beliefID) else concat('fact',ab.beliefID) end toID,
    b1.isRule, a.beliefID, ab.beliefID
    from arguments a
    inner join arguments ab on a.supportsArgumentID = ab.argumentID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
    inner join beliefs b1 on a.beliefID = b1.beliefID 
    inner join beliefs b2 on ab.beliefID = b2.beliefID
    inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
    inner join questions q2 on q2.sessionID = ab.sessionID and q2.timestep = ab.timestep and q2.isSupported = ab.isSupported
        where a.isSupported = 1 and ab.isSupported = 1
    and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
// TODO: what about checking that q.conclusionID = a.beliefID
//    order by a.questionID, a.supportsArgumentID";
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $from_to = $row[3]."_".$row[4];
        $belief_arrows[$from_to]["from_dot_label"] = $row[0];
        $belief_arrows[$from_to]["to_dot_label"] = $row[1];
        $belief_arrows[$from_to]["from_rule"] = $row[2];
        $belief_arrows[$from_to]["from_id"] = $row[3];
        $belief_arrows[$from_to]["to_id"] = $row[4];
        if ($row[2] == 0) {
            if (array_key_exists($row[3], $qagnt_facts)) {
                $belief_arrows[$from_to]["from_ref"] = & $qagnt_facts[$row[3]];
            }
            else
            {
                printf("ERROR: cannot find fact %s\n", $row[3]);
                // TODO: else exit??
            }
        } else {
            if (array_key_exists($row[3], $qagnt_rules)) {
                $belief_arrows[$from_to]["from_ref"] = & $qagnt_rules[$row[3]];
            }
            else
            {
                printf("ERROR: cannot find rule %s\n", $row[3]);
                // TODO: else exit??
            }
        }
        if (array_key_exists($row[4], $qagnt_rules)) {
            $belief_arrows[$from_to]["to_ref"] = & $qagnt_rules[$row[4]];
        }
        else
        {
            printf("ERROR: cannot find rule %s\n", $row[4]);
            // TODO: else exit??
        }
        if (array_key_exists($row[3], $belief_arrows_from)) {
            $belief_arrows_from[$row[3]][$row[4]] = & $belief_arrows[$from_to];
        } else {
            $belief_arrows_from[$row[3]] = array($row[4] => & $belief_arrows[$from_to]);
            $num_belief_arrows_from++;
        }
        if (array_key_exists($row[4], $belief_arrows_to)) {
            $belief_arrows_to[$row[4]][$row[3]] = & $belief_arrows[$from_to];
        } else {
            $belief_arrows_to[$row[4]] = array($row[3] => & $belief_arrows[$from_to]);
            $num_belief_arrows_to++;
        }
        if ($debug) {
            printf("//%s: %s(%s) -> %s(%s)\n", $from_to,
                   $belief_arrows[$from_to]["from_dot_label"],
                   ($belief_arrows[$from_to]["from_rule"] == 0)?$belief_arrows[$from_to]["from_ref"]["logic_display"]:$belief_arrows[$from_to]["from_ref"]["inference_display"],
                   $belief_arrows[$from_to]["to_dot_label"],
                   $belief_arrows[$from_to]["to_ref"]["inference_display"]);
        }
        $num_belief_arrows++;
    }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_belief_arrows=%d or %d\n", $num_belief_arrows,
           count($belief_arrows));
    foreach($belief_arrows_from as $from => $tos) {
        printf("//From(%s): (%s)\n", $from, implode(", ", array_keys($tos)));
    }
    printf("//num_belief_arrows_from=%d or %d\n", $num_belief_arrows_from,
           count($belief_arrows_from));
    foreach($belief_arrows_to as $to => $froms) {
        printf("//To(%s): (%s)\n", $to, implode(", ", array_keys($froms)));
    }
    printf("//num_belief_arrows_to=%d or %d\n", $num_belief_arrows_to,
           count($belief_arrows_to));
}

/** @page datagen_db_impl
 *
 * * Create data structure for arrows that denote attacks (rebut and undermine)
 * between beliefs. Fill in $attack_arrows and $num_attack_arrows.
 */
//Made attack type static to 'attack' should be paa.attackType
$sql="select distinct case when b.isRule = 1 then concat('inference',b.beliefID)
                  else concat('fact',b.beliefID) END fromID,
             case when b2.isRule = 1 then concat('inference',b2.beliefID)
                  else concat('fact',b2.beliefID) END toID, 'attack' as attackType, 
             case when b.isRule = 1 and b2.isRule = 1 then 'rebut'
                   when b.isRule = 1 and b2.isRule = 0 then 'undermine'
                   when b.isRule = 0 and b2.isRule = 0 then 'undermine'
                   ELSE 'rebut' END attackTypeOld,
              b.isRule, b.beliefID, b2.isRule, b2.beliefID
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
        $from_to = $row[5]."_".$row[7];
        $attack_arrows[$from_to]["from_dot_label"] = $row[0];
        $attack_arrows[$from_to]["to_dot_label"] = $row[1];
        $attack_arrows[$from_to]["attack_type"] = $row[2];
        $attack_arrows[$from_to]["from_rule"] = $row[4];    
        $attack_arrows[$from_to]["from_id"] = $row[5];    
        $attack_arrows[$from_to]["to_rule"] = $row[6];    
        $attack_arrows[$from_to]["to_id"] = $row[7];    
        if ($row[4] == 1) {
            if (array_key_exists($row[5], $qagnt_rules)) {
                $attack_arrows[$from_to]["from_ref"] = & $qagnt_rules[$row[5]];
            }
            // TODO: else exit???
        } else {
            if (array_key_exists($row[5], $qagnt_facts)) {
                $attack_arrows[$from_to]["from_ref"] = & $qagnt_facts[$row[5]];
            }
            // TODO: else exit???
        }
        if ($row[6] == 1) {
            if (array_key_exists($row[7], $qagnt_rules)) {
                $attack_arrows[$from_to]["to_ref"] = & $qagnt_rules[$row[7]];
            }
            // TODO: else exit???
        } else {
            if (array_key_exists($row[7], $qagnt_facts)) {
                $attack_arrows[$from_to]["to_ref"] = & $qagnt_facts[$row[7]];
            }
            // TODO: else exit???
        }
        if ($debug) {
            printf("//%s: %s(%s) -> %s(%s)\n",
                   $attack_arrows[$from_to]["attack_type"],
                   $attack_arrows[$from_to]["from_dot_label"],
                   ($attack_arrows[$from_to]["from_rule"] == 0)?$attack_arrows[$from_to]["from_ref"]["logic_display"]:$attack_arrows[$from_to]["from_ref"]["inference_display"],
                   $attack_arrows[$from_to]["to_dot_label"],
                   ($attack_arrows[$from_to]["to_rule"] == 0)?$attack_arrows[$from_to]["to_ref"]["logic_display"]:$attack_arrows[$from_to]["to_ref"]["inference_display"]);
        }
        $num_attack_arrows++;
    }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_attack_arrows=%d or %d\n", $num_attack_arrows,
           count($attack_arrows));
}

/** @page datagen_db_impl
 *
 * * Create data structure for arrows between agents: Fillin $agent_arrows,
 * $num_agent_arrows, $agent_arrows_from, $num_agent_arrows_from,
 * $agent_arrows_to, and $num_agent_arrows_to.
 */
$sql="select concat('agent',trustingAgent), concat('agent',trustedAgent),
          trustingAgent, trustedAgent, round(level*100)
          from agent_trust where sessionID = '".$sessionID."' and timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $from_to = $row[2]."_".$row[3];
        $agent_arrows[$from_to]["from_dot_label"] = $row[0];
        $agent_arrows[$from_to]["to_dot_label"] = $row[1];
        $agent_arrows[$from_to]["from_id"] = $row[2];
        $agent_arrows[$from_to]["to_id"] = $row[3];
        $agent_arrows[$from_to]["level"] = $row[4];
        if (array_key_exists($row[2], $agents)) {
            $agent_arrows[$from_to]["from_ref"] = & $agents[$row[2]];    
        }
        // TODO: else exit???
        if (array_key_exists($row[3], $agents)) {
            $agent_arrows[$from_to]["to_ref"] = & $agents[$row[3]];
        }
        if (array_key_exists($row[2], $agent_arrows_from)) {
            $agent_arrows_from[$row[2]][$row[3]] = & $agent_arrows[$from_to];
        } else {
            $agent_arrows_from[$row[2]] = array($row[3] => & $agent_arrows[$from_to]);
            $num_agent_arrows_from++;
        }
        if (array_key_exists($row[3], $agent_arrows_to)) {
            $agent_arrows_to[$row[3]][$row[2]] = & $agent_arrows[$from_to];
        } else {
            $agent_arrows_to[$row[3]] = array($row[2] => & $agent_arrows[$from_to]);
            $num_agent_arrows_to++;
        }
        // TODO: else exit???
        if ($debug) {
            printf("//%s(%s:%s) -> %s(%s:%s): level=%s\n",
                   $agent_arrows[$from_to]["from_dot_label"],
                   $agent_arrows[$from_to]["from_id"],
                   $agent_arrows[$from_to]["from_ref"]["name"],
                   $agent_arrows[$from_to]["to_dot_label"],
                   $agent_arrows[$from_to]["to_id"],
                   $agent_arrows[$from_to]["to_ref"]["name"],
                   $agent_arrows[$from_to]["level"]);
        }
        $num_agent_arrows++;
    }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_agent_arrows=%d or %d\n", $num_agent_arrows,
           count($agent_arrows));
    foreach ($agent_arrows_from as $from => $tos) {
        printf("//From(%s): (%s)\n", $from, implode(", ", array_keys($tos)));
    }
    printf("//num_agent_arrows_from=%d or %d\n", $num_agent_arrows_from,
           count($agent_arrows_from));
    foreach ($agent_arrows_to as $to => $froms) {
        printf("//To(%s): (%s)\n", $to, implode(", ", array_keys($froms)));
    }
    printf("//num_agent_arrows_to=%d or %d\n", $num_agent_arrows_to,
           count($agent_arrows_to));
}

/** @page datagen_db_impl
 *
 * * Create data structure for arrows between agents and their direct facts:
 * Fill in $agent_fact_arrows, $num_agent_fact_arrows,
 * $agent_fact_arrows_from, $num_agent_fact_arrows_from,
 * $agent_fact_arrows_to, and $num_agent_fact_arrows_to.
 */
$sql="select distinct concat('agent',ab.agentID),
    case when isRule = 1 then concat('rule',b.beliefID) else concat('fact',b.beliefID) end l,
    ab.agentID, isRule, b.beliefID, round(ab.level*100)
    from agent_has_beliefs ab
    inner join beliefs b on ab.beliefID = b.beliefID 
    inner join arguments a on a.beliefID = b.beliefID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
    inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
    where isInferred = 0 and a.isSupported = 1 and b.isRule = 0
    and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $from_to = $row[2]."_".$row[4];
        $agent_fact_arrows[$from_to]["from_dot_label"] = $row[0];
        $agent_fact_arrows[$from_to]["to_dot_label"] = $row[1];
        $agent_fact_arrows[$from_to]["from_id"] = $row[2];
        $agent_fact_arrows[$from_to]["to_rule"] = $row[3];
        $agent_fact_arrows[$from_to]["to_id"] = $row[4];
        $agent_fact_arrows[$from_to]["level"] = $row[5];
        if (array_key_exists($row[2], $agents)) {
            $agent_fact_arrows[$from_to]["from_ref"] = & $agents[$row[2]];    
        } else {
            printf("//ERROR: cannot find agent %s\n", $row[2]);
            // TODO: else exit???
        }
        // TODO: just use qagnt_beliefs
        if ($row[3] == 1) {
            if (array_key_exists($row[4], $qagnt_rules)) {
                $agent_fact_arrows[$from_to]["to_ref"] = & $qagnt_rules[$row[4]];    
            }
            // TODO: else exit???
        } else {
            if (array_key_exists($row[4], $qagnt_facts)) {
                $agent_fact_arrows[$from_to]["to_ref"] = & $qagnt_facts[$row[4]];    
            }
            // TODO: else exit???
        }
        if (array_key_exists($row[2], $agent_fact_arrows_from)) {
            $agent_fact_arrows_from[$row[2]][$row[4]] = & $agent_fact_arrows[$from_to];
        } else {
            $agent_fact_arrows_from[$row[2]] = array($row[4] => & $agent_fact_arrows[$from_to]);
            $num_agent_fact_arrows_from++;
        }
        if (array_key_exists($row[4], $agent_fact_arrows_to)) {
            $agent_fact_arrows_to[$row[4]][$row[2]] = & $agent_fact_arrows[$from_to];
        } else {
            $agent_fact_arrows_to[$row[4]] = array($row[2] => & $agent_fact_arrows[$from_to]);
            $num_agent_fact_arrows_to++;
        }
        if ($debug) {
            printf ("//%s(%s:%s) -> %s(%s:%s): level=%s\n",
                    $agent_fact_arrows[$from_to]["from_dot_label"],
                    $agent_fact_arrows[$from_to]["from_id"],
                    $agent_fact_arrows[$from_to]["from_ref"]["name"],
                    $agent_fact_arrows[$from_to]["to_dot_label"],
                    $agent_fact_arrows[$from_to]["to_id"],
                    ($agent_fact_arrows[$from_to]["to_rule"] == 1)?$agent_fact_arrows[$from_to]["to_ref"]["inference_display"]:$agent_fact_arrows[$from_to]["to_ref"]["logic_display"],
                    $agent_fact_arrows[$from_to]["level"]);
        }
        $num_agent_fact_arrows++;
    }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_agent_fact_arrows=%d or %d\n", $num_agent_fact_arrows,
           count($agent_fact_arrows));
    foreach ($agent_fact_arrows_from as $from => $tos) {
        printf("//From(%s): (%s)\n", $from, implode(", ", array_keys($tos)));
    }
    printf("//num_agent_fact_arrows_from=%d or %d\n",
           $num_agent_fact_arrows_from, count($agent_fact_arrows_from));
    foreach ($agent_fact_arrows_to as $to => $froms) {
        printf("//To(%s): (%s)\n", $to, implode(", ", array_keys($froms)));
    }
    printf("//num_agent_fact_arrows_to=%d or %d\n",
           $num_agent_fact_arrows_to, count($agent_fact_arrows_to));
}

/** @page datagen_db_impl
 *
 * * Create data structure for arrows between agents and their direct rules:
 * Fill in $agent_rule_arrows, $num_agent_rule_arrows,
 * $agent_rule_arrows_from, $num_agent_rule_arrows_from,
 * $agent_rule_arrows_to, and $num_agent_rule_arrows_to.
 */
$sql="select distinct concat('agent',ab.agentID),
    case when isRule = 1 then concat('rule',b.beliefID) else concat('fact',b.beliefID) end l,
    ab.agentID, isRule, b.beliefID, round(ab.level*100)
    from agent_has_beliefs ab
    inner join beliefs b on ab.beliefID = b.beliefID 
    inner join arguments a on a.beliefID = b.beliefID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
    inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
    where isInferred = 0 and a.isSupported = 1 and b.isRule = 1
    and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $from_to = $row[2]."_".$row[4];
        $agent_rule_arrows[$from_to]["from_dot_label"] = $row[0];
        $agent_rule_arrows[$from_to]["to_dot_label"] = $row[1];
        $agent_rule_arrows[$from_to]["from_id"] = $row[2];
        $agent_rule_arrows[$from_to]["to_rule"] = $row[3];
        $agent_rule_arrows[$from_to]["to_id"] = $row[4];
        $agent_rule_arrows[$from_to]["level"] = $row[5];
        if (array_key_exists($row[2], $agents)) {
            $agent_rule_arrows[$from_to]["from_ref"] = & $agents[$row[2]];    
        } else {
            printf("//ERROR: cannot find agent %s\n", $row[2]);
            // TODO: else exit???
        }
        // TODO: just use qagnt_beliefs
        if ($row[3] == 1) {
            if (array_key_exists($row[4], $qagnt_rules)) {
                $agent_rule_arrows[$from_to]["to_ref"] = & $qagnt_rules[$row[4]];    
            }
            // TODO: else exit???
        } else {
            if (array_key_exists($row[4], $qagnt_facts)) {
                $agent_rule_arrows[$from_to]["to_ref"] = & $qagnt_facts[$row[4]];    
            }
            // TODO: else exit???
        }
        if (array_key_exists($row[2], $agent_rule_arrows_from)) {
            $agent_rule_arrows_from[$row[2]][$row[4]] = & $agent_rule_arrows[$from_to];
        } else {
            $agent_rule_arrows_from[$row[2]] = array($row[4] => & $agent_rule_arrows[$from_to]);
            $num_agent_rule_arrows_from++;
        }
        if (array_key_exists($row[4], $agent_rule_arrows_to)) {
            $agent_rule_arrows_to[$row[4]][$row[2]] = & $agent_rule_arrows[$from_to];
        } else {
            $agent_rule_arrows_to[$row[4]] = array($row[2] => & $agent_rule_arrows[$from_to]);
            $num_agent_rule_arrows_to++;
        }
        if ($debug) {
            printf ("//%s(%s:%s) -> %s(%s:%s): level=%s\n",
                    $agent_rule_arrows[$from_to]["from_dot_label"],
                    $agent_rule_arrows[$from_to]["from_id"],
                    $agent_rule_arrows[$from_to]["from_ref"]["name"],
                    $agent_rule_arrows[$from_to]["to_dot_label"],
                    $agent_rule_arrows[$from_to]["to_id"],
                    ($agent_rule_arrows[$from_to]["to_rule"] == 1)?$agent_rule_arrows[$from_to]["to_ref"]["inference_display"]:$agent_rule_arrows[$from_to]["to_ref"]["logic_display"],
                    $agent_rule_arrows[$from_to]["level"]);
        }
        $num_agent_rule_arrows++;
    }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_agent_rule_arrows=%d or %d\n", $num_agent_rule_arrows,
           count($agent_rule_arrows));
    foreach ($agent_rule_arrows_from as $from => $tos) {
        printf("//From(%s): (%s)\n", $from, implode(", ", array_keys($tos)));
    }
    printf("//num_agent_rule_arrows_from=%d or %d\n",
           $num_agent_rule_arrows_from, count($agent_rule_arrows_from));
    foreach ($agent_rule_arrows_to as $to => $froms) {
        printf("//To(%s): (%s)\n", $to, implode(", ", array_keys($froms)));
    }
    printf("//num_agent_rule_arrows_to=%d or %d\n",
           $num_agent_rule_arrows_to, count($agent_rule_arrows_to));
}

/** @page datagen_db_impl
 *
 * * Create data structure for arguments.
 * Find agentIDs and beliefIDs for arguments. Fill in $arguments and
 * $num_arguments.
 */
$sql = "select pa.parentArgumentID, round(pa.level*100), pa.status, CASE
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
    $arguments[$row[0]] = array ();
    $arguments[$row[0]]["level"] = $row[1];
    $arguments[$row[0]]["status"] = $row[2];
    $arguments[$row[0]]["conclusion_display"] = $row[3];
    if ($debug) {
        printf ("//argument(%s): level=%s, status=%s, conclusion_display='%s', ",
                $row[0], $arguments[$row[0]]["level"],
                $arguments[$row[0]]["status"],
                $arguments[$row[0]]["conclusion_display"]);
    }
    $arguments[$row[0]]["num_agentIDs"] = 0;
    $arguments[$row[0]]["agentIDs"] = array ();
    $i = 0;
    // Get all agentIDs associated with this argument
    $sql = "select distinct ab.agentID
           from parent_argument pa
           inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
           inner join arguments a on paa.argumentID = a.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep
           inner join agent_has_beliefs ab on a.beliefID = ab.beliefID and ab.sessionID = a.sessionID and ab.timestep = a.timestep
           where pa.sessionID = '".$sessionID."' and pa.timestep = ".$timestep." and pa.parentArgumentID = ".$row[0];
    $result_agent=mysqli_query($link, $sql);
    if ($result_agent) {
        while ($row_agent = mysqli_fetch_array($result_agent)) {
            $arguments[$row[0]]["agentIDs"][$i] = $row_agent[0];
            $i++;
        }
        $arguments[$row[0]]["num_agentIDs"] = $i;
    }
    mysqli_free_result($result_agent);
    if ($debug) {
        printf ("num_agentIDs=%d, agentIDs=(%s), ",
                $arguments[$row[0]]["num_agentIDs"],
                implode(", ", $arguments[$row[0]]["agentIDs"]));
    }

    $arguments[$row[0]]["num_beliefIDs"] = 0;
    $arguments[$row[0]]["beliefIDs"] = array ();
    $i = 0;
    // Get all beliefIDs associated with this argument
    $sql = "select distinct a.beliefID
           from parent_argument pa
           inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID
           inner join arguments a on paa.argumentID = a.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep
           where pa.sessionID = '".$sessionID."' and pa.timestep = ".$timestep." and pa.parentArgumentID = ".$row[0];
    $result_belief=mysqli_query($link, $sql);
    if ($result_belief) {
        while ($row_belief = mysqli_fetch_array($result_belief)) {
            $arguments[$row[0]]["beliefIDs"][$i] = $row_belief[0];
            $i++;
        }
        $arguments[$row[0]]["num_beliefIDs"] = $i;
    }
    mysqli_free_result($result_belief);
    if ($debug) {
        printf ("num_beliefIDs=%d, beliefIDs=(%s)\n",
                $arguments[$row[0]]["num_beliefIDs"],
                implode(", ", $arguments[$row[0]]["beliefIDs"]));
    }

    $num_arguments++;
  }
}
mysqli_free_result($result);
if ($debug) {
    printf("//num_arguments=%d or %d\n", $num_arguments, count($arguments));
}


/** @page datagen_db_impl
 *
 * * Create data structure for arrows between agents and their direct facts that are argument ends:
 * Fill in $agent_fact_arrows, $num_agent_fact_arrows,
 * $agent_fact_arrows_from, $num_agent_fact_arrows_from,
 * $agent_fact_arrows_to, and $num_agent_fact_arrows_to.
 */
$sql="select distinct concat('agent',ab.agentID),
    case when b2.isRule = 1 then concat('inference',b2.beliefID) else concat('fact',b2.beliefID) end l2,
    ab.agentID, b2.isRule, b.beliefID, round(ab.level*100)
    from agent_has_beliefs ab
    inner join beliefs b on ab.beliefID = b.beliefID
    inner join arguments a on a.beliefID = b.beliefID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
    inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
    inner join parent_argument_has_argument paa on a.argumentID = paa.argumentID -- and a.sessionID = paa.sessionID and a.timestep = paa.timestep
    inner join parent_argument pa on paa.parentArgumentID = pa.parentArgumentID and a.sessionID = pa.sessionID and a.timestep = pa.timestep
    inner join arguments a2 on a2.argumentID = pa.argumentID and a2.sessionID = pa.sessionID and a2.timestep = pa.timestep
    inner join beliefs b2 on b2.beliefID = a2.beliefID
    where isInferred = 0 and a.isSupported = 1 and b.isRule = 0
    and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $from_to = $row[2]."_".$row[4];
        $agent_argument_arrows[$from_to]["from_dot_label"] = $row[0];
        $agent_argument_arrows[$from_to]["to_dot_label"] = $row[1];
        $agent_argument_arrows[$from_to]["from_id"] = $row[2];
        $agent_argument_arrows[$from_to]["to_rule"] = $row[3];
        $agent_argument_arrows[$from_to]["to_id"] = $row[4];
        $agent_argument_arrows[$from_to]["level"] = $row[5];
        if (array_key_exists($row[2], $agents)) {
            $agent_argument_arrows[$from_to]["from_ref"] = & $agents[$row[2]];    
        } else {
            printf("//ERROR: cannot find agent %s\n", $row[2]);
            // TODO: else exit???
        }
        // TODO: just use qagnt_beliefs
        if ($row[3] == 1) {
            if (array_key_exists($row[4], $qagnt_rules)) {
                $agent_argument_arrows[$from_to]["to_ref"] = & $qagnt_rules[$row[4]];    
            }
            // TODO: else exit???
        } else {
            if (array_key_exists($row[4], $qagnt_facts)) {
                $agent_argument_arrows[$from_to]["to_ref"] = & $qagnt_facts[$row[4]];    
            }
            // TODO: else exit???
        }
    }
}
mysqli_free_result($result);

/** @page datagen_db_impl
 *
 * * Create data structure for arrows between agents and their direct facts that are argument ends:
 * Fill in $agent_fact_arrows, $num_agent_fact_arrows,
 * $agent_fact_arrows_from, $num_agent_fact_arrows_from,
 * $agent_fact_arrows_to, and $num_agent_fact_arrows_to.
 */
$sql="select distinct 
    case when b.isRule = 1 then concat('rule',b.beliefID) else concat('fact',b.beliefID) end l,
    case when b2.isRule = 1 then concat('inference',b2.beliefID) else concat('fact',b2.beliefID) end l2,
    ab.agentID, b2.isRule, b.beliefID, round(ab.level*100)
    from agent_has_beliefs ab
    inner join beliefs b on ab.beliefID = b.beliefID 
    inner join arguments a on a.beliefID = b.beliefID  and a.sessionID = ab.sessionID and a.timestep=ab.timestep
    inner join questions q on q.sessionID = a.sessionID and q.timestep = a.timestep and q.isSupported = a.isSupported
    inner join parent_argument_has_argument paa on a.argumentID = paa.argumentID -- and a.sessionID = paa.sessionID and a.timestep = paa.timestep
    inner join parent_argument pa on paa.parentArgumentID = pa.parentArgumentID and a.sessionID = pa.sessionID and a.timestep = pa.timestep
    inner join arguments a2 on a2.argumentID = pa.argumentID and a2.sessionID = pa.sessionID and a2.timestep = pa.timestep
    inner join beliefs b2 on b2.beliefID = a2.beliefID
    where isInferred = 0 and a.isSupported = 1 and b.isRule = 0
    and a.sessionID = '".$sessionID."' and a.timestep=".$timestep;
$result=mysqli_query($link,$sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $from_to = $row[2]."_".$row[4];
        $fact_argument_arrows[$from_to]["from_dot_label"] = $row[0];
        $fact_argument_arrows[$from_to]["to_dot_label"] = $row[1];
        $fact_argument_arrows[$from_to]["from_id"] = $row[2];
        $fact_argument_arrows[$from_to]["to_rule"] = $row[3];
        $fact_argument_arrows[$from_to]["to_id"] = $row[4];
        $fact_argument_arrows[$from_to]["level"] = $row[5];
        if (array_key_exists($row[2], $agents)) {
            $fact_argument_arrows[$from_to]["from_ref"] = & $agents[$row[2]];    
        } else {
            printf("//ERROR: cannot find agent %s\n", $row[2]);
            // TODO: else exit???
        }
        // TODO: just use qagnt_beliefs
        if ($row[3] == 1) {
            if (array_key_exists($row[4], $qagnt_rules)) {
                $fact_argument_arrows[$from_to]["to_ref"] = & $qagnt_rules[$row[4]];    
            }
            // TODO: else exit???
        } else {
            if (array_key_exists($row[4], $qagnt_facts)) {
                $fact_argument_arrows[$from_to]["to_ref"] = & $qagnt_facts[$row[4]];    
            }
            // TODO: else exit???
        }
    }
}
mysqli_free_result($result);

/** @var $store
 * @brief array $store: associative array that stores all the variables that
 *         need to be exported to dotgen files. 
 *
 * $store stores all variables like $agents, $num_agents, $qagnt_beliefs, etc.
 * that need to be accessed by other dotgen files. The array $store is
 * serialized and then stored as a string in a local file
 * "graphs2/".$sessionID.".vars". In header.php, the string is read from the
 * file and $store is obtained by unserializing the string. Thus the data
 * structures within $store are available for use in dotgen files.
 */
$store = array ();
$store["agents"] = & $agents;
$store["num_agents"] = $num_agents;
$store["qagnt_beliefs"] = & $qagnt_beliefs;
$store["num_qagnt_beliefs"] = $num_qagnt_beliefs;
$store["qagnt_facts"] = & $qagnt_facts;
$store["num_qagnt_facts"] = $num_qagnt_facts;
$store["qagnt_rules"] = & $qagnt_rules;
$store["num_qagnt_rules"] = $num_qagnt_rules;
$store["qagnt_facts_not_end_argument"] = & $qagnt_facts_not_end_argument;
$store["num_qagnt_facts_not_end_argument"] = $num_qagnt_facts_not_end_argument;
$store["qagnt_facts_end_argument"] = & $qagnt_facts_end_argument;
$store["num_qagnt_facts_end_argument"] = $num_qagnt_facts_end_argument;
$store["agents_assoc_qagnt_facts"] = $agents_assoc_qagnt_facts;
$store["qagnt_rules_not_end_argument"] = & $qagnt_rules_not_end_argument;
$store["num_qagnt_rules_not_end_argument"] = $num_qagnt_rules_not_end_argument;
$store["qagnt_rules_end_argument"] = & $qagnt_rules_end_argument;
$store["num_qagnt_rules_end_argument"] = $num_qagnt_rules_end_argument;
$store["belief_arrows"] = & $belief_arrows;
$store["num_belief_arrows"] = $num_belief_arrows;
$store["belief_arrows_from"] = & $belief_arrows_from;
$store["num_belief_arrows_from"] = & $num_belief_arrows_from;
$store["belief_arrows_to"] = & $belief_arrows_to;
$store["num_belief_arrows_to"] = $num_belief_arrows_to;
$store["attack_arrows"] = & $attack_arrows;
$store["num_attack_arrows"] = $num_attack_arrows;
$store["agent_arrows"] = & $agent_arrows;
$store["num_agent_arrows"] = $num_agent_arrows;
$store["agent_arrows_from"] = & $agent_arrows_from;
$store["num_agent_arrows_from"] = $num_agent_arrows_from;
$store["agent_arrows_to"] = & $agent_arrows_to;
$store["num_agent_arrows_to"] = $num_agent_arrows_to;
$store["agent_fact_arrows"] = & $agent_fact_arrows;
$store["num_agent_fact_arrows"] = $num_agent_fact_arrows;
$store["agent_fact_arrows_from"] = & $agent_fact_arrows_from;
$store["num_agent_fact_arrows_from"] = $num_agent_fact_arrows_from;
$store["agent_fact_arrows_to"] = & $agent_fact_arrows_to;
$store["num_agent_fact_arrows_to"] = $num_agent_fact_arrows_to;
$store["agent_rule_arrows"] = & $agent_rule_arrows;
$store["num_agent_rule_arrows"] = $num_agent_rule_arrows;
$store["agent_rule_arrows_from"] = & $agent_rule_arrows_from;
$store["num_agent_rule_arrows_from"] = $num_agent_rule_arrows_from;
$store["agent_rule_arrows_to"] = & $agent_rule_arrows_to;
$store["num_agent_rule_arrows_to"] = $num_agent_rule_arrows_to;
$store["agent_argument_arrows"] = $agent_argument_arrows;
$store["fact_argument_arrows"] = $fact_argument_arrows;
$store["arguments"] = & $arguments; $store["num_arguments"] = $num_arguments;

$fp = file_put_contents("graphs2/".$sessionID.".vars",  serialize($store));
if ($fp == FALSE) {
    printf("//ERROR: on writing variables to file\n");
    // TODO: exit
}

?>
