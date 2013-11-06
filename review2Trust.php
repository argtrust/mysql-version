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
//	echo "python testZML_A.py -s ".$sessionID . " -t ".$timestep;

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

    <title>Arg Trust System</title>

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
            <li class="active"><a href="review2Trust.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Trust</a></li>
            <li><a href="review3Beliefs.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Beliefs</a></li>
            <li><a href="review4Rules.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Rules</a></li>
            <li><a href="review5TrustBeliefs.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Trust + Beliefs</a></li>
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

/*
foreach ($agents as $agent_id => $agent_info) {
    printf("%s [label=%s, href=\"javascript:void(0)\", onclick=\"get_id('\L', '\N')\"];\n",
           $agent_info["dot_label"], $agent_info["name"]);
}
*/
            $sql = "select concat('agent',atu.trustingAgent), concat('agent',atu.trustedAgent),
                    atu.trustingAgent, atu.trustedAgent, level,
                    a.agentName, a2.agentName, case when att.scenario_text is null then '' else att.scenario_text end tt
                    from agent_trust atu
                    inner join agents a on a.agentID =  atu.trustingAgent
                    inner join agents a2 on a2.agentID =  atu.trustedAgent
                    left outer join agent_trust_text att on att.trustingAgent = atu.trustingAgent and att.trustedAgent = atu.trustedAgent and atu.sessionID = att.sessionID and atu.timestep = att.timestep
                    where atu.sessionID = '".$sessionID."' and atu.timestep=".$timestep.";
            ";
            echo "\n";
//            echo $sql;
            echo "\n";
            $result=mysqli_query($link,$sql);
            if ($result) {
                while ($row = mysqli_fetch_array($result)) {

                    //generate gv file
                        $newLevel = $row[4] * 100;
                         ob_start();
                        echo "digraph g { graph [bb=\"\", style=\"filled, rounded\", fillcolor=whitesmoke]; rankdir=LR; ";
                        echo "node [shape=oval, ";
                        echo "  style=filled, ";
                        echo "  fillcolor=lavender, ";
                        echo "  fontname=arial]; ";
                        echo "edge [color=blue]; ";
                        printf("%s [label=%s];",
                           $row[0], $row[5]);
                        printf("%s [label=%s];",
                           $row[1], $row[6]);
                        printf("%s -> %s [color=yellow];\n",
                           $row[0], $row[1],$newLevel);
                        echo "}";
                        $contents = ob_get_contents();
                        ob_end_clean();
                        $fp = file_put_contents("graphs2/trust_".$sessionID."_".$row[0]."_".$row[1].".dot",$contents);
                        $output = exec("dot graphs2/trust_".$sessionID."_".$row[0]."_".$row[1].".dot -Txdot -o graphs2/trust_".$sessionID."_".$row[0]."_".$row[1].".gv");
                    //add div object to the document using JS
                    //load graphviz
                        $sessionIDNoDash = str_replace("-", "", $sessionID);
                        echo "jQuery('#mainContainer').append('<div  class=jumbotron><table width=100%><tr><td>".$row[7]."</td><td><div class=individualGraphs id=trust_".$sessionIDNoDash."_".$row[0]."_".$row[1]." ></div><br /><br /><br /></td></tr>";
                        echo "<tr><td>&nbsp;</td><td>Trust Level: <input type=text id=display_".$sessionIDNoDash."_".$row[0]."_".$row[1]." value=".$newLevel." disabled/> <div id=slider_".$sessionIDNoDash."_".$row[0]."_".$row[1]."></td></tr>";
                        echo "</table></div>');\n";
                        echo "trust_".$sessionIDNoDash."_".$row[0]."_".$row[1]." = new Canviz('trust_".$sessionIDNoDash."_".$row[0]."_".$row[1]."');\n";
                        echo "trust_".$sessionIDNoDash."_".$row[0]."_".$row[1].".setScale(1);\n";
                        echo "trust_".$sessionIDNoDash."_".$row[0]."_".$row[1].".load('graphs2/trust_".$sessionID."_".$row[0]."_".$row[1].".gv');\n";
                        echo "jQuery( '#slider_".$sessionIDNoDash."_".$row[0]."_".$row[1]."' ).slider({ value: ".$newLevel.", min: 0, max: 100, step: 5, ";
                        echo "    change: function(event, ui) {";
                        echo "        jQuery('#display_".$sessionIDNoDash."_".$row[0]."_".$row[1]."' ).val(ui.value);";
                        echo " jQuery('#changedStatus').load('updateBelief.php?type=trust&sessionID=".$sessionID."&timestep=".$timestep."&fromID=".$row[0]."&toID=".$row[1]."&level='+ui.value, function(){})";
                        echo "}});";
                }
                }
            ?>
		});


    </script>
    <script type="text/javascript" src="menu.js"></script>
  </body>
</html>
