<?php
	include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Fixed Top Navbar Example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-fixed-top.css" rel="stylesheet">

    <link href="./jQuery-contextMenu-master/src/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
    <link href="./jQuery-contextMenu-master/prettify/prettify.sunburst.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link href="style_new.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Arg Trust</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index_new.php">Reset</a></li>
            <li><a href="review1Scenario.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Scenario</a></li>
            <li><a href="review2Trust.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Trust</a></li>
            <li><a href="review3Beliefs.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Beliefs</a></li>
            <li><a href="review4Rules.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Rules</a></li>
            <li><a href="review5TrustBeliefs.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Trust + Beliefs</a></li>
            <li class="active"><a href="review6Graph.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Complete Graph</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div id="graphContainer" class="container">
        <div class="graph">
            <div id="canviz"></div>
        </div>
        <div id="rightNav">
            <?php
                include 'right_nav.php';
            ?>
        </div>
        <div id="debug_output" style="display:none"></div>
    </div>



<!-- Google Analytics -->
<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-43820596-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  <?php
	if (isset($_COOKIE["userID"])){
		?>
		_gaq.push(['_trackEvent', 'PageLoad', '<?php echo $sessionID; ?>', <?php echo $timestep; ?>]);
		<?php
	}
  ?>

</script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>

    <script src="./jQuery-contextMenu-master/src/jquery.ui.position.js"></script>
    <script src="./jQuery-contextMenu-master/src/jquery.contextMenu.js"></script>
    <script src="./jQuery-contextMenu-master/prettify/prettify.js"></script>
    <script src="./jQuery-contextMenu-master/screen.js"></script>

    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

    <script type="text/javascript" src="./prototype/prototype.js"></script>
    <script type="text/javascript" src="./path/path.js"></script>
    <script type="text/javascript" src="canviz.js"></script>
   <script type="text/javascript" src="x11colors.js"></script>
    <script type="text/javascript" src="scripts_common.js"></script>

    <script>
		var mySessionID = "<?php echo $sessionID;?>";
		var myTimestep = "<?php echo $timestep;?>";
		var val = "<?php echo $graphDetail;?>";
		var myCanviz;
		var graphScale = .5;
		document.observe('dom:loaded', function() {
			myCanviz = new Canviz('canviz');
			myCanviz.setScale(graphScale);
			if(mySessionID.length > 0){
				myCanviz.load("graphs2/<?php echo $sessionID; ?>.gv");
				//alert("canviz height= "+ document.getElementById('canviz_canvas_1').height + " window height =" + window.innerHeight);

			}
		});

		function updategraph(graphType, graphID, graphDetail){
			_gaq.push(['_trackEvent', 'UpdateGraph', graphType, '<?php echo $sessionID; ?>', <?php echo $timestep; ?>]);
			_gaq.push(['_trackEvent', 'UpdateGraph_'+graphType, graphDetail, '<?php echo $sessionID; ?>', <?php echo $timestep; ?>]);
			url = "review6Graph.php?sessionID=<?php echo $sessionID; ?>&timestep=<?php echo $timestep; ?>";
			if((graphType == 'agent') && (graphDetail==2))
				window.location.href=url+"&agentID="+graphID+"&graphDetail="+graphDetail;
			else if((graphType == 'agent') && (graphDetail==1))
				window.location.href=url+"&agentID="+graphID+"&graphDetail="+graphDetail;
			else if(graphType == 'agent')
				window.location.href=url+"&agentID="+graphID+"&graphDetail="+graphDetail;
			else if((graphType == 'belief') && (graphDetail==2))
				window.location.href=url+"&beliefID="+graphID+"&graphDetail="+graphDetail;
			else if(graphType == 'belief')
				window.location.href=url+"&beliefID="+graphID+"&graphDetail="+graphDetail;
			else if(graphType == 'rule')
				window.location.href=url+"&ruleID="+graphID+"&graphDetail="+graphDetail;
			else if((graphType == 'argument') && (graphDetail==2))
				window.location.href=url+"&argumentID="+graphID+"&graphDetail="+graphDetail;
			else if((graphType == 'argument') && (graphDetail==1))
				window.location.href=url+"&argumentID="+graphID+"&graphDetail="+graphDetail;
			else if((graphType == 'argument') && (graphDetail==0))
				window.location.href=url+"&argumentID="+graphID+"&graphDetail="+graphDetail;
			else if(graphType == 'argument')
				window.location.href=url+"&argumentID="+graphID+"&graphDetail="+graphDetail;
			else if((graphType == 'conclusion') && (graphDetail==3))
				window.location.href=url+"&conclusionID="+graphID+"&graphDetail="+graphDetail;
			else
				window.location.href=url+"&graphDetail="+graphDetail;

		};

		function get_graphType() {
			var agent = "<?php echo $agentID;?>";
			var belief = "<?php echo $beliefID;?>";
			var rule = "<?php echo $ruleID;?>";
			var argument = "<?php echo $argumentID;?>";
			var graphType = '';
			if(argument != '') {
				graphType = 'argument';
				return [graphType, argument];
			}
			else if (agent != '') {
				graphType = 'agent';
				return [graphType, agent];
			}
			else if(belief != '') {
				graphType = 'belief';
				return [graphType, belief];
			}
			else if(rule != '') {
				graphType = 'rule';
				return [graphType, rule];
			}
			else
				return [graphType, ''];

		};

		function change_scale(inc) {
			graphScale+=inc;
			myCanviz.setScale(graphScale);
			myCanviz.draw()
		};


        jQuery.noConflict();

        jQuery(function() {
            var valMap = ['high-level', 'mid-level', 'low-level', 'expert'];
            jQuery( "#slider" ).slider({
                value: Number(val),
                min: 0,
                max: valMap.length - 1,
                step: 1,
                slide: function(event, ui) {
                    //var detail = valMap[ui.value];
                    //jQuery('#detail').val(detail);
                    var graph = get_graphType();
                    var graphType = graph[0];
                    var graphID = graph[1];
                    updategraph(graphType, graphID, ui.value);
                }
            });
            jQuery('#detail').val(valMap[jQuery("#slider").slider("value")]);
        });

        function get_id(label, name) {
            jQuery("a[title='"+label+"']").attr('id', name);
        };


    </script>
    <script type="text/javascript" src="menu.js"></script>
  </body>
</html>
