<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title><?= $title; ?></title>
        <style>
            html, body, #map-canvas {
                height: 100%;
                margin: 0px;
                padding: 0px;
				font-family:Tahoma, Geneva, sans-serif;
				font-size:12px;
            }
			#wrapper{ position:relative; width:100%; height:100%; }
            #panel {
                position: absolute;
                bottom: 0px;
                left: 50%;
                z-index: 5;
                background-color: #fff;
                padding: 5px;
                border: 1px solid #999;
				width:90%;
				margin-left:-45%;
				text-align:center;
            }
			
			h1{
				position:absolute;
				left:50%;
				top:10px;
				z-index:5;
				text-align:center;
				width:100%;
				margin-left:-50%;
				text-transform:uppercase;
			}
			
			input{ padding:5px; }
			
			form{ display:inline-block; }
			
			.textfield{ width:200px; font-size:14px; }
			
			.link-btn{ padding:5px; border:1px solid #a4a4a4; background-color:#E8E8E8; text-decoration:none; color:#000; }
			.link-btn:hover{ border-color:#666; }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script type="text/javascript">
		
            var geocoder;
            var map;
			var lat;
			var lng;
			var markers = [];
			
            function initialize(){
                
                var latlng = new google.maps.LatLng(-36.848445,174.763456);
                var mapOptions = {
                    zoom: 12,
                    center: latlng
                }
               map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            }

            function codeAddress(){
                
                var address = $('#address').val();
				
				geocoder = new google.maps.Geocoder();
                
                geocoder.geocode({'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        
						lat = results[0].geometry.location.lat();
						lng = results[0].geometry.location.lng();
						
						var ll = lat+","+lng;
						
						deleteMarkers();
						
						$.getJSON("<?= base_url(); ?>twitter/get", {address:address, ll:ll}, function(data){
							
							/*
							var marker = new google.maps.Marker({
								position: results[0].geometry.location,
								map: map
							});
							*/
							$.each(data, function(i, item) {
								
								var infowindow = new google.maps.InfoWindow({
									content: item.text+' - '+item.created_at
								});
								
								var marker = new google.maps.Marker({
									position: new google.maps.LatLng(item.lat, item.lng),
									icon: item.profile_image_url,
									map: map
								});
								
								markers.push(marker);
								
								google.maps.event.addListener(marker, 'click', function(){
									infowindow.open(map,this);
								});
								
							});
							
						});
						
						$("span").html(address);
						
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }
			
			function setAllMap(map) {
				for (var i = 0; i<markers.length; i++) {
					markers[i].setMap(map);
				}
			}
			
			function clearMarkers(){
				setAllMap(null);
			}
			
			function deleteMarkers(){
				clearMarkers();
				markers = [];
			}
			
            google.maps.event.addDomListener(window, 'load', initialize);

        </script>
        <script type="text/javascript">
			$(document).ready(function(){
				codeAddress();
			});
		</script>
    </head>
    <body>
    	<div id="wrapper">
            <h1>TWEET ABOUT <span><?= $default_keyword; ?></span></h1>
            <div id="panel">
            	<form onSubmit="codeAddress(); return false;">
                    <input id="address" type="textbox" value="<?= $default_keyword; ?>" class="textfield">
                    <input type="submit" value="submit">
                </form>
                <a href="history" class="link-btn">view history</a>
            </div>
            <div id="map-canvas"></div>
        </div>
    </body>
</html>