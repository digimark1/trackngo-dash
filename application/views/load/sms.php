<!DOCTYPE html>
<html>
  <head>
    <title>Smith Track'n Go location</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  </head>
  <body onLoad="getLocation()">
  <?php 
	   date_default_timezone_set("America/New_York");
	  
  ?>
   <div id="demo"></div>
   <div id="demo2"></div>
   <div id="demo3"></div>
    <script>
	
			var x = document.getElementById("demo");
			
			function getLocation() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition);
				} else { 
					alert("Geolocation is not supported by this browser.");
				}
			};
			
			function showPosition(position) {
				$("#demo").html("Latitude: " + position.coords.latitude +"Longitude: " + position.coords.longitude);
							//alert(cc);
							var loadid = '<?php echo $loadid ?>';
							var date = '<?php echo date("Y-m-d H:i:s") ?>';
							$("#demo2").html(loadid+' '+date);       
							$.ajax({
								type: "POST",
								url: 'https://lean-staffing.com/trackngo/load/insert_trace/'+loadid,
								async: true,
								data: {
									driver_latitude: position.coords.latitude,//,
									driver_longitude: position.coords.longitude,//
									driver_date: date
								},
								dataType: "json",
								success: function (o) {
									//$("#saletbl tr:last-child").focus()
									alert('great');
									//saveMsg(o.date, o.time, o.city, o.state, o.comment, o.entered_by);
									
								},
								error: function(o){
									alert('error');
									}
							});
							$("#demo3").html(loadid+' '+date);  
     			};
    </script>

  </body>
</html>