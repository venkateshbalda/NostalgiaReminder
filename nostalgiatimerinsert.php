<!DOCTYPE html>
<html>
<?php
	#$con = mysqli_connect("sql113.epizy.com","epiz_31093480","FCH7F3A7YX","epiz_31093480_timerqr") or die("connection isnot established");
   $con = mysqli_connect("localhost","root","","data") or die("connection isnot established");
?>
<head>
	<title>create the qr</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
  
</head>
<body onLoad="hide()">
	<div id="newform">   
	<form method="post" action="">	
	<input type="text" name="parameter" placeholder="enter your parameter and unique" required="required"><br>
	<input type="text" name="message" placeholder="enter your message that can show up" required="required"><br>
	<input type="date" name="date" placeholder="enter the date" required="required"><br>
	<button name="insert">Insert</button>
	</form>
	</div>
<?php
if (isset($_POST['insert'])) {
	//$sid = mysqli_real_escape_string($con,$_POST['sid']);
	$parameter = mysqli_real_escape_string($con,$_POST['parameter']);
	$date = mysqli_real_escape_string($con,$_POST['date']);
	$message = mysqli_real_escape_string($con,$_POST['message']);

	$get_data = "select * from data where parameter='$parameter'";
	$run_data = mysqli_query($con,$get_data);
	$check = mysqli_num_rows($run_data);

	if ($check==1) {
		echo $parameter." already exists, try a new one";
		exit();
	}

			
	else{
		$insert = "insert into data (`parameter`,`date`,`message`) values ('$parameter','$date','$message')";
		$run_insert = mysqli_query($con,$insert);
		if($run_insert){
		//$_SESSION['user_email'] =$email;
		//echo "http://awebsite.great-site.net/nostalgiatimer.php?parameter=".$parameter;
		$newurl = "http://awebsite.great-site.net/nostalgiatimer.php?parameter=".$parameter;					
?>
	<a href="<?php echo $newurl ?>"> <?php echo $newurl ?></a>
	<a id="download" download="<?php echo $parameter ?>.png"><br>
		<button type="button" onClick="download()">Download</button><br>
		<canvas id="myCanvas" width="720" height="450">Your browser does not support Canvas.</canvas>
	</a>
	<script>
		var qr;
		(function() {
			qr = new QRious({
			element: document.getElementById('myCanvas'),
			size: 500,
			value: '<?php echo $newurl ?>'
				});
		})(); 
		function hide(){  
			var div = document.getElementById("newform");  
			if (qr !== "none") 
			{  
				div.style.display = "none";  
			}   
		}
		function download() {
			var download = document.getElementById("download");
			var image = document.getElementById("myCanvas").toDataURL("image/png")
				.replace("image/png", "image/octet-stream");
			download.setAttribute("href", image);
			//download.setAttribute("download","archive.png");
		}

		</script>
<?php
				}
			}
		}
        $con->close();
?>		
	</body>
</html>