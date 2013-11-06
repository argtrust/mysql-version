#!/usr/bin/python
# -*- coding: utf-8 -*-

#import _mysql
import MySQLdb as mdb
import sys, getopt
import json
import xml.etree.cElementTree as et
import argparse
import re
from decimal import *

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
	

con = None
try:

#	con = mdb.connect('jsalvitdbinstance.cku3opv9prdt.us-east-1.rds.amazonaws.com', 'jsalvit', 'c00l2heads', 'trust',charset='utf8')
#	con = mdb.connect('localhost', 'root', '', 'trust',charset='utf8')
	con = mdb.connect('localhost', 'trust_user', 'trust1234', 'trust',charset='utf8')
	cursor = con.cursor()
	resetDB(con,cursor)
			
except mdb.Error, e:
  
    print "Error %d: %s" % (e.args[0], e.args[1])
    sys.exit(1)

finally:
    
    if cursor:
		cursor.close()
    if con:
        con.close()
