<?php
    include 'settings.php';
    if($isLocal == 1){
        putenv('PATH=/usr/local/bin:');
    }
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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Review Beliefs - ArgTrust</title>

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
            <li class="active"><a href="review3Beliefs.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Beliefs</a></li>
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

                $sql = "select distinct concat('fact',b.beliefID) as beliefName, CASE
                        WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))')
                        ELSE concat(p.name,'(',c.name,')') END predicate,
                        ab.level as currentLevel,
                        p.name, c.name, b.isNegated,
                        a.agentName as currentAgentName, concat('agent',ab.agentID) as currentAgentID, case when abt.scenario_text is null then '' else abt.scenario_text end sct
                        from beliefs b
                        inner join agent_has_beliefs ab on b.beliefID = ab.beliefID and ab.isInferred = 0 and isRule = 0
                        inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
                        inner join predicates p on p.predicateID = pc.predicateID
                        inner join constants c on pc.constantID = c.constantID
						inner join agents a on a.agentID = ab.agentID
						left outer join agent_belief_text abt on b.beliefID = abt.beliefID and ab.timestep = abt.timestep and ab.sessionID = abt.sessionID and a.agentID = abt.agentID
                        where ab.sessionID = '".$sessionID."' and ab.timestep=".$timestep.";
                ";
            echo "\n";
//            echo $sql;
            echo "\n";
            $result=mysqli_query($link,$sql);
            if ($result) {
                while ($row = mysqli_fetch_array($result)) {
                    //generate gv file
                        ob_start();
                        echo "digraph g { graph [bb=\"\", style=\"filled, rounded\", fillcolor=whitesmoke]; rankdir=LR; ";
                        echo "node [shape=oval, ";
                        echo "  style=filled, ";
                        echo "  fillcolor=lavender, ";
                        echo "  fontname=arial]; ";
                        echo "edge [color=blue]; ";
                        $newLevel = $row[2] * 100;
                        printf("%s [label=%s];",
                           $row[7], $row[6]);
                        printf("%s -> %s \n",
                           $row[7], $row[0],$newLevel);
                        printf("%s [label=\"%s\", shape=box, fillcolor=lightcyan ];\n",
                              $row[0], $row[1]);
                        echo "}";
                        $contents = ob_get_contents();
                        ob_end_clean();
                        $fp = file_put_contents("graphs2/belief_".$sessionID."_".$row[0].".dot",$contents);
                        $output = exec("dot graphs2/belief_".$sessionID."_".$row[0].".dot -Txdot -o graphs2/belief_".$sessionID."_".$row[0].".gv");
                    //add div object to the document using JS
                    //load graphviz
                        $sessionIDNoDash = str_replace("-", "", $sessionID);
                        echo "jQuery('#mainContainer').append('<div  class=jumbotron><table width=100%><tr><td>".$row[8]."</td><td><div class=individualGraphs id=belief_".$sessionIDNoDash."_".$row[0]." ></div><br /><br /><br /></td></tr>";
                        echo "<tr><td>&nbsp;</td><td>Belief Level: <input type=text id=display_".$sessionIDNoDash."_".$row[0]." value=".$newLevel." disabled/> <div id=slider_".$sessionIDNoDash."_".$row[0]."></td></tr>";
                        echo "</table></div>');\n";
                        echo "myBeliefGraph_".$sessionIDNoDash."_".$row[0]." = new Canviz('belief_".$sessionIDNoDash."_".$row[0]."');";
                        echo "myBeliefGraph_".$sessionIDNoDash."_".$row[0].".setScale(1);";
                        echo "myBeliefGraph_".$sessionIDNoDash."_".$row[0].".load('graphs2/belief_".$sessionID."_".$row[0].".gv');";
                        echo "jQuery( '#slider_".$sessionIDNoDash."_".$row[0]."' ).slider({ value: ".$newLevel.", min: 0, max: 100, step: 5, ";
                        echo "    change: function(event, ui) {";
                        echo "        jQuery('#display_".$sessionIDNoDash."_".$row[0]."' ).val(ui.value);";
                        echo " jQuery('#changedStatus').load('updateBelief.php?type=fact&sessionID=".$sessionID."&timestep=".$timestep."&agentID=".$row[7]."&factID=".$row[0]."&level='+ui.value, function(){})";
                        echo "}});";
                }
                }
            ?>
		});


    </script>
    <script type="text/javascript" src="menu.js"></script>
  </body>
</html>
