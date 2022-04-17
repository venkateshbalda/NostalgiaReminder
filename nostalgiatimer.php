<?php
     //sql db connection
     #$con = mysqli_connect("sql113.epizy.com","epiz_31093480","FCH7F3A7YX","epiz_31093480_timerqr") or die("connection isnot established");
     $con = mysqli_connect("localhost","root","","data") or die("connection isnot established");

     //getting the parameter from the current url
     if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
          $url = "https://";   
     else  
          $url = "http://";      
     $url.= $_SERVER['HTTP_HOST'];     
     $url.= $_SERVER['REQUEST_URI'];    
     $url_components = parse_url($url);
     parse_str($url_components['query'], $params);
     $urlparameter=$params['parameter'];  
 
     //extract data from sql db using the parameter from the url
     $get_data = "select * from data where parameter='$urlparameter'";
     $run_data = mysqli_query($con,$get_data);
     $check = mysqli_num_rows($run_data);
     if ($check==0) {
		echo $urlparameter." doesn't exist, check again ot try a new one";
		exit();
	}
     $row_data=mysqli_fetch_array($run_data);
     $parameter = $row_data['parameter'];
     $date = $row_data['date'];
     $sid = $row_data['sid'];
     $message = $row_data['message'];
?>

<html>
     <head>
          <title>nostalgia timer</title>
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <script src="https://cdn.jsdelivr.net/npm/fireworks-js@latest/dist/fireworks.js"></script>
          <script src="/fireworks.js"></script>

          <style>p{text-align:center;font-size:60px;margin-top:0px;color:white;}</style>
          
          <p><?php echo $message ?></p><br>
     </head>
     <body id="root" style="background: #000;">
          <p id="demo"></p>
          <script>
               var countDownDate = new Date('<?php echo $date; ?>').getTime();
               var x = setInterval(function() {
               var now = new Date().getTime();
               var distance = now - countDownDate ;
               var years = Math.floor(distance / (1000 * 60 * 60 * 24 * 365));
               var days = Math.floor((distance % (1000 * 60 * 60 * 24 * 365)) / (1000 * 60 * 60 * 24));
               var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
               var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
               var seconds = Math.floor((distance % (1000 * 60)) / 1000);
               document.getElementById("demo").innerHTML = years + "y " + days + "d " + hours + "h "
               + minutes + "m " + seconds + "s ";
               }, 1000);
               
    const root = document.getElementById('root')
    const fireworks = new Fireworks(root)
    fireworks.start()
          </script>
     </body>
</html>
          
<?php
     //sql disconnection
     $con->close();
?>
