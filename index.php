<?php
	$url = 'https://regist.xn--b3caa1e2a7e2b0h2be.com/Register/';
	$timeout = 20;

	// create curl resource
	$ch = curl_init();
	// set url
	curl_setopt($ch, CURLOPT_URL, $url);

	//return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//enable headers
	curl_setopt($ch, CURLOPT_HEADER, 1);
	//get only headers
	curl_setopt($ch, CURLOPT_NOBODY, 1);
	// $output contains the output string
	$output = curl_exec($ch);

	// close curl resource to free up system resources
	curl_close($ch);

	$headers = [];
	$output = rtrim($output);
	$data = explode("\n",$output);
	$headers['status'] = $data[0];
	array_shift($data);

	foreach($data as $part){
	  //some headers will contain ":" character (Location for example), and the part after ":" will be lost, Thanks to @Emanuele
	  $middle = explode(":",$part,2);

	  //Supress warning message if $middle[1] does not exist, Thanks to @crayons
	  if ( !isset($middle[1]) ) { $middle[1] = null; }

	  $headers[trim($middle[0])] = trim($middle[1]);
	}
	// Print all headers as array
	echo "<pre>";
	#print_r($headers);
	echo "</pre>";

	if (preg_match("/close.html/i", $headers['Location'])) {
		header("refresh: $timeout;");
	} else {
		echo "Done. Please waiting to access to register page.";
		header("location: $url");
		$timeout = 0;
		exit;
	}
	echo 'ถ้ามองไม่เห็นอะไรใน frame ด้านล่างให้กด <a href="'.$url.'" target="_blank">ไปลงทะเบียนกันเลย</a>';
?>

<div id="countdown"></div>
<script>
var timeleft = <?php echo $timeout?>;
var downloadTimer = setInterval(function(){
  document.getElementById("countdown").innerHTML = "<h1>"+timeleft + " seconds remaining to register page</h1>";
  timeleft -= 1;
  if(timeleft <= 0){
    clearInterval(downloadTimer);
    document.getElementById("countdown").innerHTML = "Finished"
  }
}, 1000);
</script>
<br>
<iframe src="<?php echo $url?>" width="100%" height="100%"></iframe>

