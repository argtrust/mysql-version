#!/usr/bin/python
# -*- coding: utf-8 -*-

#import _mysql
import MySQLdb as mdb
import sys, getopt
import json
import xml.etree.cElementTree as et
import argparse
import re
import itertools
from decimal import *

def node_text(n):
	try:
            return et.tostring(n, method='html', with_tail=False)
        except TypeError:
            return str(n)

def resetDB(connection,cursor):
		try:
			cursor.execute("truncate table agent_has_beliefs;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table agent_trust;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table agents;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table arguments;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table belief_has_premises;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table beliefs;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table constants;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table inferred_beliefs;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table inferred_trust;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table predicate_has_constant;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table predicates;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table question_has_status;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table questions;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table statuses;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table argument_attacks_argument;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table question_attacks_arguments;")
			connection.commit()
		except:
			connection.rollback()

def removeArguments(connection,cursor):
		try:
			cursor.execute("truncate table arguments;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete from questions where isAttack = 1;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("update questions set isSupported = 0, isProcessed = 0;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table argument_attacks_argument;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table question_attacks_arguments;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table inferred_beliefs;")
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("truncate table inferred_trust;")
			connection.commit()
		except:
			connection.rollback()

def clearSessionToReargue(connection, cursor, sessionID, timestep):

		try:
			cursor.execute("delete from arguments where sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete from questions where isAttack = 1 and sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("update questions set isSupported = 0, isProcessed = 0 where sessionID = %s and timestep =  %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete from argument_attacks_argument where sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete from question_attacks_arguments where sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete from inferred_beliefs where sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete from inferred_trust where sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete paa.* from parent_argument pa inner join parent_argument_has_argument paa where pa.parentArgumentID = paa.parentArgumentID and sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete from parent_argument where sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete from agent_has_beliefs where isInferred = 1 and sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			cursor.execute("delete from agent_trust where isInferred = 1 and sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()
		try:
			sql = "delete paa.* "
			sql =+ " from parent_argument_attacks_argument paa "
			sql =+ "inner join parent_argument pa on fromParentArgID = parentArgumentID " 
			sql =+ "where sessionID = %s and timestep = %s; "
			cursor.execute(sql, (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()

		try:
			sql = "delete paa.* "
			sql =+ " from parent_argument_has_argument paa "
			sql =+ "inner join parent_argument pa on pa.parentArgumentID = paa.parentArgumentID " 
			sql =+ "where sessionID = %s and timestep = %s; "
			cursor.execute(sql, (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()

		try:
			cursor.execute("delete from parent_argument where sessionID = %s and timestep = %s;", (sessionID, timestep))
			connection.commit()
		except:
			connection.rollback()

def getPredicateID(connection,cursor,predicateName):
	cursor.execute("select * from predicates where LOWER(name) =  LOWER(ltrim(rtrim(%s)));", (predicateName))
	if cursor.rowcount == 0:
		try:
			cursor.execute("Insert INTO predicates (name) values(ltrim(rtrim(%s)));", (predicateName))
			connection.commit()
			return cursor.lastrowid
		except:
			connection.rollback()
	else:
		for aid in cursor.fetchall():
			return aid[0]

def getConstantID(connection,cursor,constantName):
	cursor.execute("select * from constants where LOWER(name) =  LOWER(ltrim(rtrim(%s)));", (constantName))
	if cursor.rowcount == 0:
		try:
			cursor.execute("Insert INTO constants (name) values(ltrim(rtrim(%s)));", (constantName))
			connection.commit()
			return cursor.lastrowid
		except mdb.Error, e:
			connection.rollback()
    		print "Error %d: %s" % (e.args[0], e.args[1])
	else:
		for aid in cursor.fetchall():
			return aid[0]
	
def getAgentID(connection,cursor,agentName):
	cursor.execute("select * from agents where LOWER(agentName) =  LOWER(ltrim(rtrim(%s)));", (agentName))
	if cursor.rowcount == 0:
		try:
			cursor.execute("Insert INTO agents (agentName) values(ltrim(rtrim(%s)));", (agentName))
			connection.commit()
			return cursor.lastrowid
		except:
			connection.rollback()
	else:
		for aid in cursor.fetchall():
			return aid[0]

def getPredicateHasConstantID(connection,cursor,PredicateText):
	foundPredicate = 0
	predicateID = -1
	constantID = -1
	result = [0,-1]
	for l in re.compile("\(|\)|\s").split(PredicateText):
		if foundPredicate == 0:
			if l == "NOT":
				result[0] = 1
			elif len(l) > 0:
				predicateID = getPredicateID(connection,cursor,l)
				foundPredicate = 1
		elif len(l) > 0:
			constantID = getConstantID(connection,cursor,l)
	if predicateID > 0 and constantID > 0:
		cursor.execute("select predicateConstantID from predicate_has_constant where predicateID =  %s and constantID = %s;", (predicateID,constantID))
		if cursor.rowcount == 0:
			try:
				cursor.execute("Insert INTO predicate_has_constant (predicateID,constantID) values(%s,%s);", (predicateID,constantID))
				connection.commit()
				result[1] = cursor.lastrowid
			except:
				connection.rollback()
		else:
			for aid in cursor.fetchall():
				result[1] = aid[0]
	return result

def getBeliefID(connection,cursor,isNegated,conclusionID,isRule):
	cursor.execute("select beliefID from beliefs where conclusionID =  %s and isNegated = %s and isRule = %s;", (conclusionID,isNegated,isRule))
	#Insert record for every rule
	if isRule == 1 or cursor.rowcount == 0:
		try:
			cursor.execute("Insert INTO beliefs (conclusionID,isNegated,isRule) values(%s,%s,%s);", (conclusionID,isNegated,isRule))
			connection.commit()
			return cursor.lastrowid
		except:
			connection.rollback()
	else:
		for aid in cursor.fetchall():
			return aid[0]

def getAgentHasBeliefsID(con,cursor,agentID,beliefID,level,isInferred,sessionID,timestep):
	try:
		cursor.execute("Insert INTO agent_has_beliefs (agentID,beliefID,level,isInferred,sessionID,timestep) values(%s,%s,%s,%s,%s,%s);", (agentID,beliefID,level,isInferred,sessionID,timestep))
		con.commit()
		return cursor.lastrowid
	except:
		con.rollback()

def getAgentBeliefsText(con,cursor,agentID,beliefID,sessionID,timestep,scenariotext):
	try:
		cursor.execute("Insert INTO agent_belief_text (agentID,beliefID,sessionID,timestep,scenario_text) values(%s,%s,%s,%s,%s);", (agentID,beliefID,sessionID,timestep,scenariotext))
		con.commit()
		return cursor.lastrowid
	except:
		con.rollback()

def getPremiseID(con,cursor,beliefID,isNegated,premiseID):
	try:
		cursor.execute("Insert INTO belief_has_premises (beliefID,premiseID,isNegated) values(%s,%s,%s);", (beliefID,premiseID,isNegated))
		con.commit()
		return cursor.lastrowid
	except:
		con.rollback()
	
def getQuestionID(connection,cursor,agentID,isNegated,conclusionID,isAttack,sessionID,timestep):
	cursor.execute("select questionID from questions where agentID =  %s and conclusionID = %s and isNegated=%s and sessionID=%s and timestep=%s;", (agentID,conclusionID,isNegated,sessionID,timestep))
	if cursor.rowcount == 0:
		try:
			cursor.execute("Insert INTO questions (agentID,conclusionID,isAttack,isProcessed,isSupported,isNegated,sessionID,timestep) values(%s,%s,%s,0,0,%s,%s,%s);", (agentID,conclusionID,isAttack,isNegated,sessionID,timestep))
			connection.commit()
			return [cursor.lastrowid,1]
		except mdb.Error, e:
			print "Error %d: %s" % (e.args[0], e.args[1])
			connection.rollback()
	else:
		for aid in cursor.fetchall():
			return [aid[0],0]

def getQuestionHasAttacksID(connection,cursor,questionID,argumentID,sessionID,timestep):
	cursor.execute("select questionArgumentID from question_attacks_arguments where questionID =  %s and argumentID = %s and sessionID=%s and timestep=%s;", (questionID,argumentID,sessionID,timestep))
	if cursor.rowcount == 0:
		try:
			cursor.execute("Insert INTO question_attacks_arguments (questionID,argumentID,sessionID,timestep) values(%s,%s,%s,%s);", (questionID,argumentID,sessionID,timestep))
			connection.commit()
			return cursor.lastrowid
		except mdb.Error, e:
			print "Error %d: %s" % (e.args[0], e.args[1])
			connection.rollback()
	else:
		for aid in cursor.fetchall():
			return aid[0]

	
def inferTrusts(connection,cursor,agentID,startingAgentID,sessionID,timestep):

	getcontext().prec = 2
	cursor.execute("select trustingAgent,trustedAgent,level,isInferred from agent_trust where trustingAgent = %s and NOT trustedAgent = %s and sessionID=%s and timestep=%s;", (agentID,startingAgentID,sessionID,timestep))
	for trust_rel in cursor.fetchall():
		inferTrusts(connection,cursor,trust_rel[1],startingAgentID,sessionID,timestep)
		cursor.execute("select trustingAgent,trustedAgent,level,isInferred,trustID from agent_trust where trustingAgent = %s and NOT trustedAgent in (%s,%s) and sessionID = %s and timestep = %s;", (trust_rel[1],agentID,startingAgentID,sessionID,timestep))
		for second_trust_rel in cursor.fetchall():
			inferredLevel = trust_rel[2]*second_trust_rel[2]
			try:
				cursor.execute("insert into agent_trust (trustingAgent,trustedAgent,level,isInferred,sessionID,timestep) values(%s,%s,%s,%s,%s,%s);", (agentID,second_trust_rel[1],inferredLevel,1,sessionID,timestep))
				trustID = cursor.lastrowid
				connection.commit()
				cursor.execute("insert into inferred_trust (inferredTrustID,appliedTrustID,sessionID,timestep) values(%s,%s,%s,%s);", (trustID,second_trust_rel[3],sessionID,timestep))
				connection.commit()
			except:
				connection.rollback()

def recursiveTrust(connection,cursor,agentFromID,agentToID):
	getcontext().prec = 2
	cursor.execute("select trustingAgent,trustedAgent,level,isInferred from agent_trust where trustingAgent = %s and trustedAgent = %s;", (agentFromID,agentToID))
	if cursor.rowcount == 0:
		cursor.execute("select trustingAgent,trustedAgent,level,isInferred from agent_trust where trustingAgent = %s and NOT trustedAgent = %s;", (agentFromID,startingAgentID))

	else:
		for aid in cursor.fetchall():
			return aid[2]


def inferBeliefs(connection,cursor,agentID,sessionID,timestep):
	getcontext().prec = 2

	cursor.execute("select agentBeliefID, agentID, beliefID, ab.level, at.level from agent_has_beliefs ab inner join agent_trust at on trustedAgent = agentID and ab.sessionID = at.sessionID and ab.timestep = at.timestep where trustingAgent= %s and ab.sessionID = %s and ab.timestep = %s;", (agentID,sessionID,timestep))
	for belief in cursor.fetchall():
		inferredLevel = belief[3]*belief[4]
		try:
			cursor.execute("insert into agent_has_beliefs (agentID,beliefID,level,isInferred,sessionID,timestep) values(%s,%s,%s,%s,%s,%s);", (agentID,belief[2],inferredLevel,1,sessionID,timestep))
			agentBeliefID = cursor.lastrowid
			connection.commit()
    			cursor.execute("insert into inferred_beliefs (inferredBeliefID,appliedBeliefID,sessionID,timestep) values(%s,%s,%s,%s);", (agentBeliefID,belief[0],sessionID,timestep))
			connection.commit()
		except mdb.Error, e:
			print "Error %d: %s" % (e.args[0], e.args[1])
			connection.rollback()
			
def argue(connection,cursor,conclusionID,isNegated,agentID,questionID,supportsArgumentID,sessionID,timestep):
	sql = " select b.beliefID, b.isRule, ab.agentBeliefID "
	sql += "from beliefs b "
	sql += "inner join agent_has_beliefs ab on b.beliefID = ab.beliefID "
	sql += "where ab.agentID = %s and b.conclusionID = %s "
	sql += " and b.isNegated = %s and ab.sessionID=%s and ab.timestep=%s;"
#	cursor.execute("select b.beliefID, b.isRule from beliefs b inner join agent_has_beliefs ab on b.beliefID = ab.beliefID where ab.agentID = %s and b.conclusionID = %s and b.isNegated = %s and ab.sessionID=%s and ab.timestep=%s;", (agentID,conclusionID,isNegated,sessionID,timestep))
	cursor.execute(sql, (agentID,conclusionID,isNegated,sessionID,timestep))
	for conclusion in cursor.fetchall():
		try:
			cursor.execute("insert into arguments (beliefID,questionID,supportsArgumentID,isLeaf,isSupported,sessionID,timestep) values(%s,%s,%s,%s,%s,%s,%s);", (conclusion[0],questionID,supportsArgumentID,0,0,sessionID,timestep))
			argumentID = cursor.lastrowid
			connection.commit()
			#Insert counter arguments
			
			if conclusion[1] == 1:
				cursor.execute("select premiseID, isNegated from belief_has_premises where beliefID = %s;", (conclusion[0]))
				for premise in cursor.fetchall():
					argue(connection,cursor,premise[0], premise[1],agentID,questionID,argumentID,sessionID,timestep)

			#NEED TO KICK OFF RECURSIVE CALL ON COUNTER ARGUMENTS
			#BUT ONLY IF HASN'T BEEN PROCESSED OTHERWISE CAN END UP IN INFINITE LOOP
			if isNegated == 0:
				questionInfo = getQuestionID(connection,cursor,agentID,1,conclusionID,1,sessionID,timestep)
				if questionInfo[1] == 1:
					argue(connection,cursor,conclusionID,1,agentID,questionInfo[0],-1,sessionID,timestep)
				getQuestionHasAttacksID(connection,cursor,questionInfo[0],argumentID,sessionID,timestep)
			else:
				questionInfo = getQuestionID(connection,cursor,agentID,0,conclusionID,1,sessionID,timestep)
				if questionInfo[1] == 1:
					argue(connection,cursor,conclusionID,0,agentID,questionInfo[0],-1,sessionID,timestep)
				getQuestionHasAttacksID(connection,cursor,questionInfo[0],argumentID,sessionID,timestep)

			
		except mdb.Error, e:
			print "Error %d: %s" % (e.args[0], e.args[1])
			connection.rollback()
		
		#insert current argument
		#push negative question as attack

			

def getAllArguments(connection,cursor,sessionID,timestep, argumentID):
	# select arguments/beliefs from step -1
		
	sql = "select argumentID, beliefID, supportsArgumentID from arguments where sessionID = %s and timestep = %s and isSupported = 1 and  argumentID = %s;"
	cursor.execute(sql,(sessionID,timestep,argumentID))
	for conclusion in cursor.fetchall():
		sql = "select premiseID, bp.isNegated from belief_has_premises bp inner join beliefs b on b.beliefID = bp.beliefID where b.beliefID = %s"
		cursor.execute(sql,(conclusion[1]))
		
		if cursor.rowcount == 0:
			return [[argumentID]]
		else:
			#DECLARATIVE STATEMENT
			# LIST SHOULD BE ME + PARENTS + SIBLINGS
			siblings = [[]]
			for premise in cursor.fetchall():
				sql = "select argumentID, a.beliefID "
				sql += "from arguments a "
				sql += "inner join beliefs b on b.beliefID = a.beliefID "
				sql += "where sessionID = %s and timestep = %s and isSupported = 1 and supportsArgumentID = %s and b.conclusionID = %s and b.isNegated = %s;"
				cursor.execute(sql,(sessionID,timestep,conclusion[0],premise[0],premise[1]))
				parents = []
				for arg in cursor.fetchall():
					#parents is a list of lists that got me here.
					temp = getAllArguments(connection,cursor,sessionID,timestep,arg[0])
					for parent in temp:
#						parent.append(argumentID)
						parents.append(parent)

				newList = []
				for sibling in siblings:
					for parent in parents:
						newList.append(sibling + parent)
				siblings = list(newList)
			for sibling in siblings:
				sibling.append(argumentID)
			return siblings

def createParentArgs(connection,cursor,sessionID,timestep):
	sql = "select argumentID, questionID from arguments where supportsArgumentID = -1 and isSupported = 1 and sessionID = %s and timestep = %s;"
	cursor.execute(sql,(sessionID,timestep))
	for argument in cursor.fetchall():
		listOfArgs = getAllArguments(connection,cursor,sessionID,timestep,argument[0])
		for l in listOfArgs:
			cursor.execute("insert into parent_argument (argumentID, questionID,sessionID,timestep) values (%s,%s,%s,%s)", (argument[0],argument[1],sessionID,timestep))
			con.commit()
			parentID = cursor.lastrowid
			for a in l:
				cursor.execute("insert into parent_argument_has_argument (parentArgumentID, argumentID) values (%s,%s)", (parentID,a))
				con.commit()
						


def forwardChain(connection,cursor,sessionID,timestep):
	sql = "update arguments a "
	sql += "set isSupported = 0 "
	sql += "where a.sessionID = %s and a.timestep = %s; "
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()

#-- Have a belief and it is a fact, therefore it is supported.
	sql = "update arguments a "
	sql += "inner join agent_has_beliefs ab on ab.beliefID = a.beliefID and a.sessionID = ab.sessionID and a.timestep = ab.timestep "
	sql += "inner join beliefs b on b.beliefID = ab.beliefID "
	sql += "set isSupported = 1 "
	sql += "where b.isRule = 0 and a.sessionID = %s and a.timestep = %s; "
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()

	sql = "update arguments  "
	sql += "set isSupported = 1 "
	sql += "where sessionID = %s and timestep = %s and beliefID in ( "
	sql += "select b.beliefID "
	sql += "from beliefs b "
	sql += "inner join belief_has_premises bp on b.beliefID = bp.beliefID "
	sql += "inner join agent_has_beliefs ab on ab.beliefID = b.beliefID "
	sql += "inner join predicate_has_constant pc on b.conclusionID = predicateConstantID "
	sql += "inner join constants c on c.constantID = pc.constantID "
	sql += "inner join predicates p on p.predicateID = pc.predicateID "
	sql += "left outer join (select distinct b2.beliefID, conclusionID, isNegated "
	sql += "                  from beliefs b2  "
	sql += "                  inner join agent_has_beliefs ab2 on ab2.beliefID = b2.beliefID "
	sql += "                  inner join arguments a2 on a2.beliefID = b2.beliefID and ab2.sessionID = a2.sessionID and ab2.timestep = a2.timestep "
	sql += "                  where ab2.sessionID = %s and ab2.timestep = %s and a2.isSupported = 1) as ij "
	sql += " on bp.premiseID = ij.conclusionID and bp.isNegated = ij.isNegated "
	sql += "where ab.sessionID = %s and ab.timestep = %s "
	sql += "group by b.beliefID, p.name, c.name "
	sql += "having count(bp.beliefPremiseID) = SUM(case when ij.beliefID is null THEN 0 else 1 end) "
	sql += "); "
	temp = 1
	while temp > 0:
		cursor.execute(sql,(sessionID,timestep,sessionID,timestep,sessionID,timestep))
		temp = cursor.rowcount
		connection.commit()

	sql = "update questions "
	sql += "set isSupported = 0 "
	sql += "where sessionID = %s and timestep = %s; "
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()

	sql = "update questions q "
	sql += "inner join beliefs b on b.conclusionID = q.conclusionID and b.isNegated = q.isNegated "
	sql += "inner join arguments a on a.sessionID = q.sessionID and a.timestep = q.timestep and a.beliefID = b.beliefID  "
	sql += "set q.isSupported = 1 "
	sql += "where a.isSupported = 1 and q.sessionID = %s and q.timestep = %s; "
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()

	#Even if question is supported, if it is only supporting an unsupported argument 	
	sql = "	update questions "
	sql += "set isSupported = 0 where questionID in ( "
	sql += "select qa.questionID "
	sql += "from question_attacks_arguments qa  "
	sql += "inner join arguments a on a.argumentID = qa.argumentID and qa.sessionID = a.sessionID and qa.timestep = a.timestep "
	sql += "where qa.sessionID = %s and qa.timestep = %s "
	sql += "group by qa.questionID "
	sql += "having sum(a.isSupported) = 0);"
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()

	sql = "	update arguments a "
	sql += "inner join questions q on q.questionID = a.questionID and q.sessionID = a.sessionID and q.timestep = a.timestep "
	sql += "set a.isSupported = 0 "
	sql += "where q.sessionID = %s and q.timestep = %s and q.isSupported = 0; "
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()
		
	
def insertAttacksOld(connection,cursor,sessionID,timestep):
	sql = "	insert into parent_argument_attacks_argument (fromParentArgID, toParentArgID) "
	sql += "	select pa.parentArgumentID, pa2.parentArgumentID "
	sql += "	from arguments a "
	sql += "	inner join parent_argument pa"
 	sql += "	 on pa.argumentID = a.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep "
	sql += "	inner join questions q on a.questionID = q.questionID and q.sessionID = a.sessionID and q.timestep = a.timestep "
	sql += "	left outer join question_attacks_arguments qa on qa.questionID = q.questionID and q.sessionID = qa.sessionID and q.timestep = qa.timestep "
	sql += "	left outer join parent_argument pa2 "
	sql += "	  on pa2.argumentID = qa.argumentID and pa2.sessionID = qa.sessionID and pa2.timestep = qa.timestep "
	sql += "	where pa.sessionID = %s and pa.timestep = %s and pa2.parentArgumentID is not null;"
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()
	
	setArgumentStatus(connection,cursor,sessionID,timestep)
def insertAttacks(connection,cursor,sessionID,timestep):
	sql = "	insert into parent_argument_attacks_argument (fromParentArgID, toParentArgID) "
	sql += "select distinct pa.parentArgumentID, ab.parentArgumentID "
	sql += "from parent_argument pa "
	sql += "inner join arguments a2 on a2.argumentID = pa.argumentID and pa.sessionID = a2.sessionID and pa.timestep = a2.timestep "
	sql += "inner join beliefs b2 on a2.beliefID = b2.beliefID "
	sql += "inner join ( "
	sql += "            select distinct pa.parentArgumentID, paa.argumentID, a2.beliefID, b2.conclusionID, b2.isNegated, pa.sessionID, pa.timestep "
	sql += "            from parent_argument pa "
	sql += "            inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID "
	sql += "            inner join arguments a2 on a2.argumentID = paa.argumentID and pa.sessionID = a2.sessionID and pa.timestep = a2.timestep "
	sql += "            inner join beliefs b2 on a2.beliefID = b2.beliefID "
	sql += "            where pa.sessionID = %s and pa.timestep = %s  "
	sql += ") ab on b2.conclusionID = ab.conclusionID and ab.parentArgumentID != pa.parentArgumentID and b2.isNegated != ab.isNegated "
	sql += "where pa.sessionID = %s and pa.timestep = %s ; "
	cursor.execute(sql,(sessionID,timestep,sessionID,timestep))
	connection.commit()
	
	# Set attack types
	sql = " update parent_argument_attacks_argument paa "
	sql += "inner join parent_argument pa1 on paa.fromParentArgID = pa1.parentArgumentID "
	sql += "inner join arguments a1 on a1.argumentID = pa1.argumentID "
	sql += "inner join beliefs b1 on b1.beliefID = a1.beliefID "
	sql += "inner join parent_argument pa2 on paa.toParentArgID = pa2.parentArgumentID and pa1.sessionID = pa2.sessionID and pa1.timestep = pa2.timestep "
	sql += "inner join arguments a2 on a2.argumentID = pa2.argumentID "
	sql += "inner join beliefs b2 on b2.beliefID = a2.beliefID "
	sql += "set attackType = case when b1.conclusionID = b2.conclusionID "
	sql += "                and b1.isNegated != b2.isNegated THEN 'rebut' "
	sql += "            when b1.conclusionID != b2.conclusionID  "
	sql += "                and b1.isNegated != b2.isNegated THEN 'undermine' "
	sql += "            else 'undermine' end "
	sql += "where pa1.sessionID = %s and pa1.timestep = %s ; "
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()

	#assign belief levels to each parent argument
	# Using weakest link method
	sql = "update parent_argument pa "
	sql += "inner join (select pa.parentArgumentID, min(ab.level) theLevel "
	sql += "from parent_argument pa "
	sql += "inner join parent_argument_has_argument paa on pa.parentArgumentID = paa.parentArgumentID "
	sql += "inner join arguments a on paa.argumentID = a.argumentID and pa.sessionID = a.sessionID and pa.timestep = a.timestep "
	sql += "inner join agent_has_beliefs ab on ab.beliefID = a.beliefID and ab.sessionID = a.sessionID and ab.timestep = a.timestep "
	sql += "where pa.sessionID = %s and pa.timestep = %s " 
	sql += "group by pa.parentArgumentID) ij on ij.parentArgumentID = pa.parentArgumentID "
	sql += "set pa.level = ij.theLevel; "
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()

	setArgumentStatus(connection,cursor,sessionID,timestep)

def setArgumentStatus(connection,cursor,sessionID,timestep):
	sql = "	update parent_argument_attacks_argument paa "
	sql += "inner join parent_argument pa1 on paa.fromParentArgID = pa1.parentArgumentID "
	sql += "set isIncluded = 1 "
	sql += "where pa1.sessionID = %s and pa1.timestep = %s; "
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()

	sql = "update parent_argument_attacks_argument paa "
	sql += "inner join parent_argument pa1 on paa.fromParentArgID = pa1.parentArgumentID "
	sql += "inner join parent_argument pa2 on paa.toParentArgID = pa2.parentArgumentID "
	sql += "set isIncluded = 2 "
	sql += "where pa1.sessionID = %s and pa1.timestep = %s  "
	sql += "and pa1.level < pa2.level;"
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()

	
	sql = "update parent_argument pa "
	sql += "set pa.status = %s "
	sql += "where pa.sessionID = %s and pa.timestep = %s;"
	cursor.execute(sql,("UNK",sessionID,timestep))
	connection.commit()

	sql = "update parent_argument pa "
	sql += "left outer join parent_argument_attacks_argument paa on pa.parentArgumentID = paa.toParentArgID and paa.isIncluded = 1 "
	sql += "set pa.status = 'IN' "
	sql += "where pa.sessionID = %s and pa.timestep = %s and paa.fromParentArgID is null; "
	cursor.execute(sql,(sessionID,timestep))
	connection.commit()
	
	for i in range(3): 
		sql = "	update parent_argument pa1 "
		sql += "inner join parent_argument_attacks_argument paa1 on pa1.parentArgumentID = paa1.fromParentArgID and paa1.isIncluded = 1 "
		sql += "inner join parent_argument pa2 on pa2.parentArgumentID = paa1.toParentArgID "
		sql += "set pa2.status = 'OUT' "
		sql += "where pa1.sessionID = %s and pa1.timestep = %s and pa1.status = 'IN';"
		cursor.execute(sql,(sessionID,timestep))
		connection.commit()
	
		sql = "update parent_argument pa "
		sql += "inner join ( "
		sql += "select paa.toParentArgID "
		sql += "from parent_argument pa "
		sql += "inner join parent_argument_attacks_argument paa on paa.toParentArgID = pa.parentArgumentID "
		sql += "inner join parent_argument pa2 on paa.fromParentArgID = pa2.parentArgumentID "
		sql += "where pa.sessionID = %s and pa.timestep = %s and pa.status = 'UNK' "
		sql += "and paa.isIncluded = 1 "
		sql += "group by paa.toParentArgID "
		sql += "having count(distinct pa2.status) = 1 and max(pa2.status) = 'OUT') ij on ij.toParentArgID = pa.parentArgumentID "
		sql += "set pa.status = 'IN'; "
		cursor.execute(sql,(sessionID,timestep))
		connection.commit()

	sql = "update parent_argument pa "
	sql += "set pa.status = %s "
	sql += "where pa.sessionID = %s and pa.timestep = %s and pa.status = 'UNK';"
	cursor.execute(sql,("UNDEC",sessionID,timestep))
	connection.commit()
	
	
def loadNewFile(inputfile,con,cursor,sessionID,timestep):
	file = open(inputfile,'r')
	#convert to string:
	data = file.read()
	#close file because we dont need it anymore:
	file.close()
	tree=et.fromstring(data)

#	resetDB(con,cursor)
	
	for el in tree.findall('domain/constant'):
		getConstantID(con,cursor,el.text)
		
	for el in tree.findall('domain/predicate'):
		getPredicateID(con,cursor,el.text)

	for el in tree.findall('trustnet/agent'):
		getAgentID(con,cursor,el.text)
		

	for el in tree.findall('scenario'):
#		print et.tostring(el)
#		print el
#		print '------------------------------'
#		print el.text
#		''.join(node_text(n) for n in el.xpath('/node()'))
		try:
			cursor.execute("Insert INTO scenarios (sessionID,timestep,scenario_text) values(%s,%s,%s);", (sessionID,timestep,et.tostring(el)))
			con.commit()
		except:
			con.rollback()

	for el in tree.findall('trustnet/trust'):
		trusterID = -1
		trustedID = -1
		level = -1
		textAboutTrust=''
		for t in el.findall('truster'):
			trusterID = getAgentID(con,cursor,t.text)
		for t in el.findall('trustee'):
			trustedID = getAgentID(con,cursor,t.text)
		for t in el.findall('level'):
			level = t.text
		for t in el.findall('scenarioText'):
			textAboutTrust = t.text
		try:
			cursor.execute("Insert INTO agent_trust (trustingAgent,trustedAgent,level,isInferred,sessionID,timestep) values(%s,%s,%s,%s,%s,%s);", (trusterID,trustedID,level,0,sessionID,timestep))
			con.commit()
		except:
			con.rollback()
		try:
			cursor.execute("Insert INTO agent_trust_text (trustingAgent,trustedAgent,sessionID,timestep,scenario_text) values(%s,%s,%s,%s,%s);", (trusterID,trustedID,sessionID,timestep,textAboutTrust))
			con.commit()
		except:
			con.rollback()

	for el in tree.findall('beliefbase/belief'):
		agentID = -1
		level = -1
		beliefID = -1
		for t in el.findall('agent'):
			agentID = getAgentID(con,cursor,t.text)
		for t in el.findall('level'):
			level = t.text
		for t in el.findall('fact'):
			isRule = 0
			isInferred = 0
			predicateHasConstant = getPredicateHasConstantID(con,cursor,t.text)
			if(predicateHasConstant[1] > 0):
				beliefID = getBeliefID(con,cursor,predicateHasConstant[0],predicateHasConstant[1],isRule)
				getAgentHasBeliefsID(con,cursor,agentID,beliefID,level,isInferred,sessionID,timestep)
			else:
				print "predicate has constant returned -1"
				sys.exit(1)
		for t in el.findall('rule'):
			isRule = 1
			isInferred = 0
			for c in t.findall('conclusion'):
				predicateHasConstant = getPredicateHasConstantID(con,cursor,c.text)
				if(predicateHasConstant[1] > 0):
					beliefID = getBeliefID(con,cursor,predicateHasConstant[0],predicateHasConstant[1],isRule)
					getAgentHasBeliefsID(con,cursor,agentID,beliefID,level,isInferred,sessionID,timestep)
				else:
					print "predicate has constant returned -1"
					sys.exit(1)
			for p in t.findall('premise'):
				predicateHasConstant = getPredicateHasConstantID(con,cursor,p.text)
				getPremiseID(con,cursor,beliefID,predicateHasConstant[0],predicateHasConstant[1])
		for t in el.findall('scenarioText'):
		    getAgentBeliefsText(con,cursor,agentID,beliefID,sessionID,timestep,t.text)

	for el in tree.findall('query'):
		agentID = -1
		isAttack = 0
		isRule = 0
		for a in el.findall('agent'):
			agentID = getAgentID(con,cursor,a.text)
		for q in el.findall('question'):
			predicateHasConstant = getPredicateHasConstantID(con,cursor,q.text)
		questionID = getQuestionID(con,cursor,agentID,predicateHasConstant[0],predicateHasConstant[1],isAttack,sessionID,timestep)	
	
	cursor.execute("select agentID from questions where sessionID = %s and timestep = %s;", (sessionID, timestep))
	for agent in cursor.fetchall():
		inferTrusts(con,cursor,agent[0],agent[0],sessionID,timestep)
		
	cursor.execute("select agentID from agents;")
	for agent in cursor.fetchall():
		inferBeliefs(con,cursor,agent[0],sessionID,timestep)
	
	# Need to dedupe the beliefs and trusts
		
	#argue question
	argue(con,cursor,predicateHasConstant[1],predicateHasConstant[0],agentID,questionID[0],-1,sessionID,timestep)
	
	forwardChain(con,cursor,sessionID,timestep)

def reloadArgument(con,cursor,sessionID,timestep):

	cursor.execute("select questionID, agentID,conclusionID,isNegated,isAttack from questions where isAttack = 0 and sessionID=%s and timestep=%s;",(sessionID,timestep))
	if cursor.rowcount == 0:
		try:
			print "nothing to argue"
		except mdb.Error, e:
			print "Error %d: %s" % (e.args[0], e.args[1])
			con.rollback()
	else:
		for aid in cursor.fetchall():
			clearSessionToReargue(con, cursor, sessionID, timestep)
			cursor.execute("select agentID from questions where sessionID = %s and timestep = %s;", (sessionID, timestep))
			for agent in cursor.fetchall():
				inferTrusts(con,cursor,agent[0],agent[0],sessionID,timestep)
		
			cursor.execute("select agentID from agents;")
			for agent in cursor.fetchall():
				inferBeliefs(con,cursor,agent[0],sessionID,timestep)
	
			# Need to dedupe the beliefs and trusts
		
			#argue question
			argue(con,cursor,aid[2],aid[3],aid[1],aid[0],-1,sessionID,timestep)
	
			forwardChain(con,cursor,sessionID,timestep)
			

def parse_args():
	p = argparse.ArgumentParser(description="process an RSS feed and update the database")
	p.add_argument( '-i', '--input', dest='inputfile',  help="Input XML File", required=False )
	p.add_argument( '-s', '--session', dest='sessionID',  help="SessionID", required=False )
	p.add_argument( '-t', '--timestep', dest='timestep',  help="timestep", required=False )
	p.add_argument( '-u', '--userid', dest='userid',  help="userid", required=False )
	return p.parse_args()
	

con = None
try:

   	args = parse_args()	
#   	inputfile = parseArgs(sys.argv[1:])
#	con = mdb.connect('jsalvitdbinstance.cku3opv9prdt.us-east-1.rds.amazonaws.com', 'jsalvit', 'c00l2heads', 'trust',charset='utf8')
#	con = mdb.connect('localhost', 'root', '', 'trust',charset='utf8')
	con = mdb.connect('localhost', 'trust_user', 'trust1234', 'trust',charset='utf8')
#	print inputfile
	cursor = con.cursor()

	if(args.inputfile):
		sessionID = "-1";
		cursor.execute("select uuid();")
		for uuid in cursor.fetchall():
			sessionID = uuid[0]

		timestep = 1
		if(not args.userid):
			args.userid = 'Anonymous'
		cursor.execute("insert into user_session(sessionID,date,current_timestep,userid) values (%s,NOW(),%s,%s);",(sessionID,timestep,args.userid))
		con.commit()
#		resetDB(con,cursor)
		loadNewFile(args.inputfile,con,cursor,sessionID,timestep)
		createParentArgs(con,cursor,sessionID,timestep)
		insertAttacks(con,cursor,sessionID,timestep)
		print sessionID
	else:
#		cursor.execute("select max(argumentID) from arguments where sessionID = %s and timestep = %s;",(args.sessionID,args.timestep))
#		value = cursor.fetchone()
#		if value[0] > 0:
		reloadArgument(con,cursor,args.sessionID,args.timestep)
		createParentArgs(con,cursor,args.sessionID,args.timestep)
		insertAttacks(con,cursor,args.sessionID,args.timestep)
	
except mdb.Error, e:
  
    print "Error %d: %s" % (e.args[0], e.args[1])
    sys.exit(1)

finally:
    
    if cursor:
		cursor.close()
    if con:
        con.close()
