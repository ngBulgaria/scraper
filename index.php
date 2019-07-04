<?php
ini_set('max_execution_time', 12000); // 12000 (seconds) = 200 Minutes
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bio_herba";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit();
} else {
    printf("Current character set: %s\n", $conn->character_set_name());
}

$sql = "SELECT category,page FROM pages";
if ($result = $conn->query($sql) ) {
			    echo "scraping";
			    $i=0;
	while($row = $result->fetch_array())
	{	
		$i++;
		echo "<br>";
		$link = "https://bio-herba.com/bg/" . $row['page'];
		$link = str_replace("%2F", "/", $link);
		$link = str_replace("+", "%20", $link);
		echo $link."<br>";
		$page = file_get_contents($link);
		$page= mb_convert_encoding($page, 'HTML-ENTITIES', "UTF-8");
		$doc = new DOMDocument;
		libxml_use_internal_errors(true);
	    $doc->loadHTML($page);
	    $a = $doc->getElementsByTagName('a');
	    $cat = $row['category'];
	    $unique = Array();
	    $c=0;
		foreach($a as $list) {
			if(strpos($list->getAttribute('href'),"Детайли")) {
				
				if(!in_array($list->getAttribute('href'),$unique))
					{
						$c++;
						$link = $list->getAttribute('href');
						$link = str_replace(" ", "%20", $link);
						array_push($unique, $link);
						echo $link;
						$link = str_replace("https://bio-herba.com/bg/", "", $link);
						$link = str_replace("%20", " ", $link);
						$link = urlencode($link);
						$sql = "INSERT INTO product_pages (category, page, added )
						VALUES ('$cat', '$link', CURRENT_TIMESTAMP())";

						if ($conn->query($sql) === TRUE) {
						    echo "New record created successfully";
						} else {
						    echo "Error: " . $sql . "<br>" . $conn->error;
						}

						echo "<br />";

					}

				
			}

		}
		if($c==0)
		{
			$link = $row['link'];
			$sql = "INSERT INTO pages (category, page, added )
						VALUES ('$cat', '$link', CURRENT_TIMESTAMP())";

						if ($conn->query($sql) === TRUE) {
						    echo "Special New record created successfully";
						} else {
						    echo "Error: " . $sql . "<br>" . $conn->error;
						}
		}
		
	}
} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
echo $i;
	$conn->close();

?>