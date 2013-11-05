			jQuery(function(){
			    jQuery.contextMenu({
			        selector: '#canviz',
			        trigger:'left',
			        callback: function(key, options) {
			            var m = "clicked: " + key;
			            var id = jQuery(this).attr('id');
			            window.console && console.log(m) || alert(id);
			        },
			        items: {
			        "fold1a": {
			                "name": "New Node",
			                icon: "add",
			                "items": {
			                    "fold2": {
			                        "name": "Agent",
			                        "items": {
			                            addAgentLabel: {
							                name: "From Agent Name",
							                type: 'text',
							                value: "Ex: Jon"
							            },
			                            addAgentLabel2: {
							                name: "To Agent Name",
							                type: 'text',
							                value: "Ex: Mary"
							            },
							            addAgentTrust: {
							                name: "Trust Level",
							                type: 'text',
							                value: "Ex: .75"
							            },
							            sep4: "---------",
							            addagent: {
							                name: "Add Agent",
							                callback: function(key, options) {
							                	//var id = jQuery(this).attr('id');
								                var label = document.getElementsByName("context-menu-input-addAgentLabel")[0].value.toString();
												var toTrust = document.getElementsByName("context-menu-input-addAgentLabel2")[0].value.toString();
												var trust = document.getElementsByName("context-menu-input-addAgentTrust")[0].value.toString();
												//_gaq.push(['_trackEvent', 'AddAgent', mySessionID, label, trust);
								                window.location.assign("add_node.php?type=agent&fromAgent=" + label + "&toAgent=" + toTrust + "&trust=" + trust+"&sessionID="+mySessionID+"&timestep="+myTimestep);
							            	}
		            					}
				                    }
			                    },
			                    "fold3": {
			                        "name": "Fact",
			                        "items": {
			                        	/*addFactAgent: {
									        name: "Agent",
									        type: 'select',
									        options: {me: 'Me', uav: 'UAV', recon: 'Recon', informant:'Informant'},
								            selected: me
							        	},*/
							        	addFactAgent: {
									        name: "Agent",
							                type: 'text',
							                value: "Ex: UAV"
								        },
			                            addFactLabel: {
							                name: "Fact",
							                type: 'text',
							                value: "Ex: Increased(Gunfire)"
							            },
							            addFactTrust: {
							                name: "Belief Level",
							                type: 'text',
							                value: ".5"
						            	},
							            sep4: "---------",
							            addfact: {
							                name: "Add Fact",
							                callback: function(key, options) {
							                	//var id = jQuery(this).attr('id');
							                	/*var e = document.getElementsByName("context-menu-input-addFactAgent");
												var agent = e[0].options[e[0].selectedIndex].text;
							                	alert(agent);*/
							                	var agent = document.getElementsByName("context-menu-input-addFactAgent")[0].value.toString();
								                var label = document.getElementsByName("context-menu-input-addFactLabel")[0].value.toString();
												var trust = document.getElementsByName("context-menu-input-addFactTrust")[0].value.toString();
												//_gaq.push(['_trackEvent', 'AddFact', mySessionID, label, trust);
								                window.location.assign("add_node.php?type=fact&agent=" + agent + "&belief=" + label + "&trust=" + trust+"&sessionID="+mySessionID+"&timestep="+myTimestep);
							            	}

						            	}

				                    }
			                    },
			                    "fold4": {
			                        "name": "Rule",
			                        "items": {
			                        	/*addRuleAgent: {
									        name: "Agent",
									        type: 'select',
									        options: {1: 'Me', 2: 'UAV', 3: 'Recon', 4:'Informant'},
								            selected: 1
							        	},*/
							        	addRuleAgent: {
									        name: "Agent",
							                type: 'text',
							                value: "Ex: UAV"
								        },
			                            addRulePremise: {
							                name: "Premise",
							                type: 'text',
							                value: "Ex: Increased(Gunfire)"
							            },
							            addRuleConclusion: {
							                name: "Conclusion",
							                type: 'text',
							                value: "Ex: NOT Safe(Mission)"
							            },
							            addRuleTrust: {
							                name: "Belief Level",
							                type: 'text',
							                value: ".5"
						            	},
							            sep4: "---------",
							            addrule: {
							                name: "Add Rule",
							                callback: function(key, options) {
							                	//var id = jQuery(this).attr('id');
							                	var agent = document.getElementsByName("context-menu-input-addRuleAgent")[0].value.toString();
								                var premise = document.getElementsByName("context-menu-input-addRulePremise")[0].value.toString();
												var conclusion = document.getElementsByName("context-menu-input-addRuleConclusion")[0].value.toString();
												var trust = document.getElementsByName("context-menu-input-addRuleTrust")[0].value.toString();
												//_gaq.push(['_trackEvent', 'AddRule', mySessionID, conclusion, trust);
								                window.location.assign("add_node.php?type=rule&agent=" + agent + "&premise=" + premise + "&conclusion=" + conclusion + "&trust=" + trust+"&sessionID="+mySessionID+"&timestep="+myTimestep);
		            						}
		            					}
				                    }
			                    },
			                    "fold5": {
			                        "name": "Question",
			                        "items": {
			                            addQuestionAgent: {
							                name: "Agent",
							                type: 'text',
							                value: "Ex: Recon"
							            },
							            addQuestion: {
							                name: "Question",
							                type: 'text',
							                value: "Ex: InArea(HVT)"
							            },
							            sep4: "---------",
							            addQuestionButton: {
							                name: "Add Question",
							                callback: function(key, options) {
							                	//var id = jQuery(this).attr('id');
								                var agent = document.getElementsByName("context-menu-input-addQuestionAgent")[0].value.toString();
												var question = document.getElementsByName("context-menu-input-addQuestion")[0].value.toString();
												//_gaq.push(['_trackEvent', 'AddQuestion', mySessionID, question, 1);
								                window.location.assign("add_node.php?type=question&agent=" + agent + "&question=" + question+"&sessionID="+mySessionID+"&timestep="+myTimestep);
							            	}
		            					}
				                    }
			                    }
			                }
			            },
			            "sep": "---------",
			            "cancel": {
			                name: "Cancel",
			                icon: "quit",
			                callback: function(key, options) {

						    }
			        }
			    }
			});
		});

			jQuery(function(){
			    jQuery.contextMenu({
			        selector: '#canviz div a',
			        trigger: 'left',
			        callback: function(key, options) {
			            var m = "clicked: " + key;
			            var id = jQuery(this).attr('id');
			            window.console && console.log(m) || alert(id);
			        },
			        items: {
			            "delete": {name: "Delete Node", icon: "delete", callback: function(key, options) {
						                    //var m = "delete was clicked";
						                    //window.console && console.log(m) || alert(m);
						                    var id = jQuery(this).attr('id');
											//_gaq.push(['_trackEvent', 'DeleteNode', mySessionID, id);
						                    window.location.assign("delete_node.php?nodeID=" + id+"&sessionID="+mySessionID+"&timestep="+myTimestep);
						                }},
/*			            "fold1": {
			                "name": "Edit Node",
			                icon: "edit",
			                "items": {
						            editLabel: {
						                name: "Description",
						                type: 'text',
						                value: "UAV"
						            },
						            editTrust: {
						                name: "Trust Level",
						                type: 'text',
						                value: ".5"
						            },
						            sep4: "---------",
						            editnode: {
						                name: "Edit Node",
						                callback: function(key, options) {
						                	var id = jQuery(this).attr('id');
							                var label = document.getElementsByName("context-menu-input-editLabel")[0].value.toString();
											var trust = document.getElementsByName("context-menu-input-editTrust")[0].value.toString();
											//alert(trust);
							                window.location.assign("edit_node.php?nodeID=" + id + "&label=" + label + "&trust=" + trust);
							            }
	            					}
			                }
			            },*/
			            "sep1": "---------",
			            "fold1a": {
			                "name": "New Node",
			                icon: "add",
			                "items": {
			                    "fold2": {
			                        "name": "Agent",
			                        "items": {
			                            addAgentLabelNode: {
							                name: "From Agent Name",
							                type: 'text',
							                value: "Ex: Jon"
							            },
			                            addAgentLabel2Node: {
							                name: "To Agent Name",
							                type: 'text',
							                value: "Ex: Mary"
							            },
							            addAgentTrustNode: {
							                name: "Trust Level",
							                type: 'text',
							                value: "Ex: .75"
							            },
							            sep4: "---------",
							            addagentNode: {
							                name: "Add Agent",
							                callback: function(key, options) {
							                	//var id = jQuery(this).attr('id');
								                var label = document.getElementsByName("context-menu-input-addAgentLabelNode")[0].value.toString();
												var toTrust = document.getElementsByName("context-menu-input-addAgentLabel2Node")[0].value.toString();
												var trust = document.getElementsByName("context-menu-input-addAgentTrustNode")[0].value.toString();
												//_gaq.push(['_trackEvent', 'AddAgent', mySessionID, label, trust);
								                window.location.assign("add_node.php?type=agent&fromAgent=" + label + "&toAgent=" + toTrust + "&trust=" + trust+"&sessionID="+mySessionID+"&timestep="+myTimestep);
							            	}
		            					}
				                    }
			                    },
			                    "fold3": {
			                        "name": "Fact",
			                        "items": {
			                        	/*addFactAgent: {
									        name: "Agent",
									        type: 'select',
									        options: {me: 'Me', uav: 'UAV', recon: 'Recon', informant:'Informant'},
								            selected: me
							        	},*/
							        	addFactAgentNode: {
									        name: "Agent",
							                type: 'text',
							                value: "Ex: UAV"
								        },
			                            addFactLabelNode: {
							                name: "Fact",
							                type: 'text',
							                value: "Ex: Increased(Gunfire)"
							            },
							            addFactTrustNode: {
							                name: "Belief Level",
							                type: 'text',
							                value: ".5"
						            	},
							            sep4: "---------",
							            addfactNode: {
							                name: "Add Fact",
							                callback: function(key, options) {
							                	//var id = jQuery(this).attr('id');
							                	/*var e = document.getElementsByName("context-menu-input-addFactAgent");
												var agent = e[0].options[e[0].selectedIndex].text;
							                	alert(agent);*/
							                	var agent = document.getElementsByName("context-menu-input-addFactAgentNode")[0].value.toString();
								                var label = document.getElementsByName("context-menu-input-addFactLabelNode")[0].value.toString();
												var trust = document.getElementsByName("context-menu-input-addFactTrustNode")[0].value.toString();
												//_gaq.push(['_trackEvent', 'AddFact', mySessionID, label, trust);
								                window.location.assign("add_node.php?type=fact&agent=" + agent + "&belief=" + label + "&trust=" + trust+"&sessionID="+mySessionID+"&timestep="+myTimestep);
							            	}

						            	}

				                    }
			                    },
			                    "fold4": {
			                        "name": "Rule",
			                        "items": {
			                        	/*addRuleAgent: {
									        name: "Agent",
									        type: 'select',
									        options: {1: 'Me', 2: 'UAV', 3: 'Recon', 4:'Informant'},
								            selected: 1
							        	},*/
							        	addRuleAgentNode: {
									        name: "Agent",
							                type: 'text',
							                value: "Ex: UAV"
								        },
			                            addRulePremiseNode: {
							                name: "Premise",
							                type: 'text',
							                value: "Ex: Increased(Gunfire)"
							            },
							            addRuleConclusionNode: {
							                name: "Conclusion",
							                type: 'text',
							                value: "Ex: NOT(Safe(Mission))"
							            },
							            addRuleTrustNode: {
							                name: "Belief Level",
							                type: 'text',
							                value: ".5"
						            	},
							            sep4: "---------",
							            addruleNode: {
							                name: "Add Rule",
							                callback: function(key, options) {
							                	//var id = jQuery(this).attr('id');
							                	var agent = document.getElementsByName("context-menu-input-addRuleAgentNode")[0].value.toString();
								                var premise = document.getElementsByName("context-menu-input-addRulePremiseNode")[0].value.toString();
												var conclusion = document.getElementsByName("context-menu-input-addRuleConclusionNode")[0].value.toString();
												var trust = document.getElementsByName("context-menu-input-addRuleTrustNode")[0].value.toString();
												//_gaq.push(['_trackEvent', 'AddRule', mySessionID, conclusion, trust);
								                window.location.assign("add_node.php?type=rule&agent=" + agent + "&premise=" + premise + "&conclusion=" + conclusion + "&trust=" + trust+"&sessionID="+mySessionID+"&timestep="+myTimestep);
		            						}
		            					}
				                    }
			                    },
			                    "fold5": {
			                        "name": "Question",
			                        "items": {
			                            addQuestionAgentNode: {
							                name: "Agent",
							                type: 'text',
							                value: "Ex: Recon"
							            },
							            addQuestionNode: {
							                name: "Question",
							                type: 'text',
							                value: "Ex: InArea(HVT)"
							            },
							            sep4: "---------",
							            addquestionNodeButton: {
							                name: "Add Question",
							                callback: function(key, options) {
							                	//var id = jQuery(this).attr('id');
								                var agent = document.getElementsByName("context-menu-input-addQuestionAgentNode")[0].value.toString();
												var question = document.getElementsByName("context-menu-input-addQuestionNode")[0].value.toString();
												//_gaq.push(['_trackEvent', 'AddQuestion', mySessionID, question, 1);
								                window.location.assign("add_node.php?type=question&agent=" + agent + "&question=" + question+"&sessionID="+mySessionID+"&timestep="+myTimestep);
							            	}
		            					}
				                    }
			                    }
			                }
			            },
			            "sep": "---------",
			            "cancel": {
			                name: "Cancel",
			                icon: "quit",
			                callback: function(key, options) {

						    }
			        }
			     }
			});
		});