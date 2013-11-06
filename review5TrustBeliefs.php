<?php
//    putenv('PATH=/usr/local/bin:');
    include 'settings.php';
    $link = mysqli_connect($dbHost,$dbUser,$dbPass, $dbName);
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if(!array_key_exists('sessionID', $_GET)){
        die('Did not find session ID');
    }else{
        $sessionID=$_GET['sessionID'];
    }
    if(array_key_exists('timestep', $_GET) && $timestep > 0){
        $timestep=$_GET['$timestep'];
    }else{
        $timestep=1;
    }
    exec("python testZML_C.py -s ".$sessionID . " -t ".$timestep);

    ob_start();
    include 'datagen_db.php';
    $contents = ob_get_contents();
    ob_end_clean();
    $fp = file_put_contents("graphs2/".$sessionID.".debug",$contents);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Trust + Beliefs - ArgTrust</title>

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
            <li class="active"><a href="review5TrustBeliefs.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Trust + Beliefs</a></li>
            <li><a href="review6Graph.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Complete Graph</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div id=changedStatus></div>
    <div class="container" id="mainContainer">
        <ul id="mainContainerUL">

        </ul>
    </div>
    <div id="debug_output" class="debug_output">
    </div>
    </div> <!-- /container -->


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

		document.observe('dom:loaded', function() {
            <?php

                $sql = "select distinct concat('belief',b.beliefID) as beliefName,
                        CASE WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))') ELSE concat(p.name,'(',c.name,')') END predicate,
                        ab.level as currentLevel,
                        ab2.level as parentLevel,
                        p.name,
                        c.name,
                        b.isNegated,
                        a.agentName as currentAgentName,
                        concat('agent',ab.agentID) as currentAgentID,
                        a2.agentName as parentAgentName,
                        concat('agent',ab2.agentID) as parentAgentID,
                        att.level as trustLevel
                        from agent_trust att
                        inner join agent_has_beliefs ab on ab.agentID = att.trustingAgent and att.sessionID = ab.sessionID and att.timestep = ab.timestep
                        inner join agent_has_beliefs ab2 on ab2.agentID = att.trustedAgent and att.sessionID = ab2.sessionID and att.timestep = ab2.timestep and ab.beliefID = ab2.beliefID
                        inner join beliefs b on b.beliefID = ab2.beliefID
                        inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
                        inner join predicates p on p.predicateID = pc.predicateID
                        inner join constants c on pc.constantID = c.constantID
                        inner join agents a on a.agentID = ab.agentID
                        inner join agents a2 on a2.agentID = ab2.agentID
                        where ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep.";
                ";

            $result=mysqli_query($link,$sql);
            if ($result) {
                while ($row = mysqli_fetch_array($result)) {
                    //generate gv file
                        ob_start();
                        $trustLevel = $row[11] * 100;
                        $childBLevel = $row[2] * 100;
                        $parentBLevel = $row[3] * 100;

                        echo "digraph g { graph [bb=\"\", style=\"filled, rounded\", fillcolor=whitesmoke]; rankdir=LR; ";
                        echo "node [shape=oval, ";
                        echo "  style=filled, ";
                        echo "  fillcolor=lavender, ";
                        echo "  fontname=arial]; ";
                        echo "edge [color=blue]; ";
                        printf("%s [label=%s];",
                           $row[8], $row[7]);
                        printf("%s [label=%s];",
                           $row[10], $row[9]);
                        printf("%s -> %s [color=yellow, label=\"%s\"];\n",
                           $row[8], $row[10],$trustLevel);
                        printf("%s -> %s [label=\"%s\"];\n",
                           $row[10], $row[0],$parentBLevel);
                        printf("%s [label=\"%s:%s\", shape=box, fillcolor=lightcyan ];\n",
                           $row[0], $row[1], $childBLevel);
                        echo "}";
                        $contents = ob_get_contents();
                        ob_end_clean();
                        $fp = file_put_contents("graphs2/trustbelief_".$sessionID."_".$row[0].".dot",$contents);
                        $output = exec("dot graphs2/trustbelief_".$sessionID."_".$row[0].".dot -Txdot -o graphs2/trustbelief_".$sessionID."_".$row[0].".gv");
                    //add div object to the document using JS
                    //load graphviz
                        $sessionIDNoDash = str_replace("-", "", $sessionID);
                        echo "jQuery('#mainContainer').append('<div  class=jumbotron><table width=100%><tr><td>Since <b>".$row[7]."</b> trusts <b>".$row[9]."</b> with level <b>".$trustLevel."</b>, and <b>".$row[9]."</b> believes <b>".$row[1]."</b> with level <b>".$parentBLevel."</b>, <b>".$row[7]."</b> believes <b>".$row[1]."</b> with level <b>".$childBLevel."</b>.</td><td><div class=individualGraphs id=belief_".$sessionIDNoDash."_".$row[0]." ></div><br /><br /><br /></td></tr>";
                        echo "</table></div>');\n";
                        echo "myBeliefGraph_".$sessionIDNoDash."_".$row[0]." = new Canviz('belief_".$sessionIDNoDash."_".$row[0]."');";
                        echo "myBeliefGraph_".$sessionIDNoDash."_".$row[0].".setScale(1);";
                        echo "myBeliefGraph_".$sessionIDNoDash."_".$row[0].".load('graphs2/trustbelief_".$sessionID."_".$row[0].".gv');";
                }
               }
            ?>
		});


    </script>
    <script type="text/javascript" src="menu.js"></script>
  </body>
</html>
