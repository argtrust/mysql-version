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
		
	for el in tree.findall('trustnet/trust'):
		trusterID = -1
		trustedID = -1
		level = -1
		for t in el.findall('truster'):
			trusterID = getAgentID(con,cursor,t.text)
		for t in el.findall('trustee'):
			trustedID = getAgentID(con,cursor,t.text)
		for t in el.findall('level'):
			level = t.text
		try:
			cursor.execute("Insert INTO agent_trust (trustingAgent,trustedAgent,level,isInferred,sessionID,timestep) values(%s,%s,%s,%s,%s,%s);", (trusterID,trustedID,level,0,sessionID,timestep))
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
	p.add_argument( '-a', '--agent', dest='fromAgent',  help="fromAgent", required=False )
	p.add_argument( '-b', '--agent2', dest='toAgent',  help="toAgent", required=False )
	p.add_argument( '-l', '--level', dest='level',  help="trust level", required=False )
	p.add_argument( '-e', '--belief', dest='belief',  help="belief", required=False )
	p.add_argument( '-p', '--premise', dest='premise',  help="premise", required=False )
	p.add_argument( '-c', '--conclusion', dest='conclusion',  help="conclusion", required=False )
	p.add_argument( '-q', '--question', dest='question',  help="question", required=False )
	return p.parse_args()
	

con = None
try:

   	args = parse_args()	
#   	inputfile = parseArgs(sys.argv[1:])
#	con = mdb.connect('jsalvitdbinstance.cku3opv9prdt.us-east-1.rds.amazonaws.com', 'jsalvit', 'c00l2heads', 'trust',charset='utf8')
        con = mdb.connect('localhost', 'root', '', 'trust',charset='utf8')
#	print inputfile
	cursor = con.cursor()

	if(args.toAgent):
		trusterID = getAgentID(con,cursor,args.fromAgent)
		trustedID = getAgentID(con,cursor,args.toAgent)
		level = args.level
		try:
			cursor.execute("Insert INTO agent_trust (trustingAgent,trustedAgent,level,isInferred,sessionID,timestep) values(%s,%s,%s,%s,%s,%s);", (trusterID,trustedID,level,0,args.sessionID,args.timestep))
			con.commit()
		except:
			con.rollback()
	elif(args.belief):
		agentID = getAgentID(con,cursor,args.fromAgent)
		isRule = 0
		isInferred = 0
		predicateHasConstant = getPredicateHasConstantID(con,cursor,args.belief)
		if(predicateHasConstant[1] > 0):
			beliefID = getBeliefID(con,cursor,predicateHasConstant[0],predicateHasConstant[1],isRule)
			getAgentHasBeliefsID(con,cursor,agentID,beliefID,args.level,isInferred,args.sessionID,args.timestep)
			print beliefID
		else:
			print "predicate has constant returned -1"
			sys.exit(1)
	elif(args.premise):
		isRule = 1
		isInferred = 0
		agentID = getAgentID(con,cursor,args.fromAgent)
		predicateHasConstant = getPredicateHasConstantID(con,cursor,args.conclusion)
		if(predicateHasConstant[1] > 0):
			beliefID = getBeliefID(con,cursor,predicateHasConstant[0],predicateHasConstant[1],isRule)
			getAgentHasBeliefsID(con,cursor,agentID,beliefID,args.level,isInferred,args.sessionID,args.timestep)
		else:
			print "predicate has constant returned -1"
			sys.exit(1)
		for p in args.premise.split(','):
			predicateHasConstant = getPredicateHasConstantID(con,cursor,p)
			getPremiseID(con,cursor,beliefID,predicateHasConstant[0],predicateHasConstant[1])
	elif(args.question):
		isAttack = 0
		isRule = 0
		agentID = getAgentID(con,cursor,args.fromAgent)
		predicateHasConstant = getPredicateHasConstantID(con,cursor,args.question)
		questionID = getQuestionID(con,cursor,agentID,predicateHasConstant[0],predicateHasConstant[1],isAttack,args.sessionID,args.timestep)	

	
except mdb.Error, e:
  
    print "Error %d: %s" % (e.args[0], e.args[1])
    sys.exit(1)

finally:
    
    if cursor:
		cursor.close()
    if con:
        con.close()
