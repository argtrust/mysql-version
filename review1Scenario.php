<?php
    include 'settings.php';
    $link = mysqli_connect($dbHost,$dbUser,$dbPass, $dbName);
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    if(!array_key_exists('sessionID', $_GET)){
        include 'header.php';
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

    <title>Review Scenario - ArgTrust</title>

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
            <li><a href="index_new.php" onclick="return confirm('Resetting will cause the scenario to be cleared, which includes the text of the scenario as well as the trust and belief levels you have entered. Are you sure you want to reset the scenario?');">Reset</a></li>
            <li class="active"><a href="review1Scenario.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Scenario</a></li>
            <li><a href="review2Trust.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Trust</a></li>
            <li><a href="review3Beliefs.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Beliefs</a></li>
            <li><a href="review4Rules.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Review Rules</a></li>
            <li><a href="review5TrustBeliefs.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Trust + Beliefs</a></li>
            <li><a href="review6Graph.php?sessionID=<?php echo $sessionID;?>&timestep=<?php echo $timestep;?>">Complete Graph</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


    <div class="container">
        <?php
            $sql = "select scenario_text from scenarios where sessionID = '".$sessionID."' and timestep = ".$timestep.";";
//            echo $sql;
            $result=mysqli_query($link,$sql);

            if ($result) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<h1>The Scenario</h1>";
                    echo $row[0];
                }
                mysqli_free_result($result);
            }else{
                    echo "<h1>Scenario Text Not Loaded</h1>";
            }
        ?>


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

  </body>
</html>
