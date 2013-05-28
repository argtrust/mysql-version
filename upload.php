<?php
	$allowedExts = array("xml");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	$path_parts = pathinfo($_FILES["file"]["name"]);
	$FileName = $path_parts["filename"];
	$uniqueID = uniqid('uploadfile_').".xml";
	if (($_FILES["file"]["size"] < 20000) && in_array($extension, $allowedExts)){
//				echo $_FILES["file"]["tmp_name"]; 
		      $moved = move_uploaded_file($_FILES["file"]["tmp_name"],
		      $_SERVER['DOCUMENT_ROOT'] . "/graphs2/".$uniqueID);
		      if($moved){
//				echo "moved successfully";
		      $new_xml = "graphs2/" .$uniqueID;
//		      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
//		      echo "Stored in: " . $new_xml;
		  }
		  else {
		  	$new_xml="junk";
		  }
	}
	else {
		echo "Invalid file";
	}
	header("Location: index.php?xmlfile=$new_xml");
//		      $_SERVER['DOCUMENT_ROOT'] . "/trust/graphs2/". $_FILES["file"]["name"]);
?>
