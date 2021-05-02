
<?php //$cityId = ""; ?>
<?php
if (!isset($_GET['city']))
{
	$cityId="" ;
} 
else 
{
	$cityId = $_GET['city'];
}
?>


<script type="text/javascript">
		function showDiv() 
		{
			if ('<?php echo $cityId; ?>' != '')
			{
				document.getElementById('content').style.display = "block";
			}
		}
</script>

<!doctype html>
<html>
<head>
<title>Tourist Guide</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
.title{
	text-align: center;
	background-color: transparent;
	width: 100%;
	padding: 14px 20px;
	margin: 8px 0;
	font-size: 32px;
}
input[type=submit] {
	width: 50%;
	background-color: #4CAF50;
	color: white;
	padding: 14px 20px;
	margin: 8px 0;
	border: none;
	border-radius: 4px;
	cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

input[type=text], select {
	width: 50%;
	padding: 12px 20px;
	margin: 8px 0;
	display: inline-block;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-sizing: border-box;
}

body {
	background: url("img/bg1.jpg") no-repeat;
    font-family: Arial;
    font-size: 0.95em;
    color: black;
}

.content{
	height: auto;
	width: auto;
	
}
.report-container {
    width: auto;
    margin: 0 auto;
}

.weather-icon {
    vertical-align: middle;
    margin-right: 20px;
}

.weather-forecast {
    color: #212121;
    font-size: 1.2em;
    font-weight: bold;
    margin: 20px 0px;
}

span.min-temperature {
    margin-left: 15px;
    color: #929292;
}

.time {
    line-height: 25px;
	text-align: center;
}

.inner {
	overflow: hidden;
	width: 1000px;
	margin: 0 auto;
}

.child {
	float: left;
	background-color: transparent;
	width: 200px;
	height: 300px;
}

.venue-container {
    border: #E0E0E0 1px solid;
    padding: 20px 40px 40px 40px;
    border-radius: 2px;
    width: 300px;
	height: 100px;
	background-color: transparent;
	backdrop-filter: blur(6px);
	float: left;
}

.location-container{
	width: auto;
    margin: 0 auto;	
}

.place-container{
	overflow: hidden;
	width: 2000px;
	margin: 0 auto;
}

.place-title{
	background-color:white;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-sizing: border-box;
}

.place-details{
	background-color:#4CAF50;
	border-radius: 4px;
	box-sizing: border-box;
	color: white;
}
</style>

</head>
<body onload="showDiv()">
	<div class="title"><h1>Tourist Guide</h1></div>
	<div style="text-align: center";>
		<form method="get" name="form" action="index.php">
			<input type="text" name ="city" id="city" placeholder="Enter City">
			<input type="submit" value="Search">
		</form>
	</div>
	<div id="content" style="display:none" class="content">
	
		<?php

		
		$apiKey = "a4945535770fd1f1f61c8d2267f9c39b";
		$googleApiUrl = "http://api.openweathermap.org/data/2.5/forecast?q=" . $cityId . "&lang=en&units=metric&cnt=5&APPID=" . $apiKey;
		 
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);

		curl_close($ch);
		$data = json_decode($response,true);
		$currentTime = time();
		$count = 0;

		$clientId= "CMGHJKKCZDZLHYNBF3AZJSFSRYWUGTU5B4VLHTAFPRSMGW4S";
		$clientSecret= "IQDV2GCDIFR42WBS1AAGK5AVX1QNAMWEXJMVMRKDQRGSCD5V";
		$ver = '20210101';
		$host = "https://api.foursquare.com/v2/venues/explore?client_id=" . $clientId . "&client_secret=" . $clientSecret . "&near=" . $cityId . "&limit=10&v=" . $ver . "";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $host);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);

		curl_close($ch);
		$place = json_decode($response,true);

		?>
	
	
		<div>
			<h2 style="text-align: center;"><?php echo $data['city']['name']; ?> Weather Status</h2>
			<div class="report-container">
				<div class="inner">
					<?php foreach($data['list'] as $day => $value): ?>
						<div class="child">
							<div class="time">
								<div><?php echo date("l", strtotime("+" . $count . "day", $currentTime)); ?></div>
								<div><?php echo date("jS F, Y", strtotime("+" . $count . "day", $currentTime)); ?></div>
								<div><?php echo ucwords($value['weather'][0]['description']); ?></div>
							</div>
							<div class="weather-forecast">
								<img
									src="http://openweathermap.org/img/w/<?php echo $value['weather'][0]['icon']; ?>.png"
									class="weather-icon" /> 
									<?php echo $value['main']['temp_max']; ?>&deg;C
									
							</div>
							<div class="time">
								<div>Humidity: <?php echo $value['main']['humidity']; ?> %</div>
								<div>Wind: <?php echo $value['wind']['speed'] ?> km/h</div>
							</div>
						</div>
						<?php $count++; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	
		<h2 style="text-align: center;"><?php echo $data['city']['name']; ?> Venues to Visit</h2>
		<div class="location-container">
			<div class="place-container">
				<?php foreach($place['response']['groups'][0]['items'] as $loc => $venue): ?>
					<div class="venue-container">
						<div class="place-title"><b><?php echo $venue['venue']['name']; ?> </b></div>
						<div class="place-details">Category: <?php echo $venue['venue']['categories'][0]['name']; ?> </div>
						<div class="place-details">Address: <?php echo $venue['venue']['location']['address']; ?> </div>
						<div class="place-details">Longitude: <?php echo $venue['venue']['location']['lng']; ?> </div>
						<div class="place-details">Latitude: <?php echo $venue['venue']['location']['lat']; ?> </div>
						<a href="https://foursquare.com/v/<?php echo $venue['venue']['id']; ?>" target="_blank">View Details</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	
	
</body>
</html>