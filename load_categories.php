<?php
ini_set('max_execution_time', 12000); // 1200 (seconds) = 200 Minutes
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



	$page = file_get_contents('https://bio-herba.com/bg/%D0%9B%D0%B8%D1%81%D1%82%D0%B8%D0%BD%D0%B3-%D0%BD%D0%B0-%D0%BF%D1%80%D0%BE%D0%B4%D1%83%D0%BA%D1%82%D0%B8-%D0%B2-%D0%BA%D0%B0%D1%82%D0%B5%D0%B3%D0%BE%D1%80%D0%B8%D1%8F/2542201/%D0%A5%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D0%B5%D0%BB%D0%BD%D0%B8%20%D0%B4%D0%BE%D0%B1%D0%B0%D0%B2%D0%BA%D0%B8.html');
	$page= mb_convert_encoding($page, 'HTML-ENTITIES', "UTF-8");
	$doc = new DOMDocument;
	libxml_use_internal_errors(true);
    $doc->loadHTML($page);
    $a = $doc->getElementsByTagName('a');
    $i=0;
	foreach($a as $list) {
		if(strpos($list->getAttribute('href'),"Листинг") && !strpos($list->getAttribute('href'),"iii.html")) {
			$i++;
			echo $list->getAttribute('href');
			echo "<br />";
			$link = $list->getAttribute('href');
			$link = str_replace("https://bio-herba.com/bg/", "", $link);
			$link = urlencode($link);
			$sql = "INSERT INTO categories (category, link, added, updated)
			VALUES ('$list->nodeValue', '$link', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())";;

			if ($conn->query($sql) === TRUE) {
			    echo "New record created successfully";
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
			/*
			$category = file_get_contents($link);
			$category = mb_convert_encoding($category, 'HTML-ENTITIES', "UTF-8");
			$categoryDoc = new DOMDocument;
			$categoryDoc->loadHTML($category);
			$pages = $categoryDoc->getElementsByTagName('a');
			foreach ($pages as $page) {
				
				if(1 === preg_match('~[0-9]~', $page->nodeValue) && strpos($page->getAttribute('href'),"Листинг") && strpos($page->getAttribute('href'),"iii.html")){
				
				echo "&nbsp;&nbsp;&nbsp;&nbsp; - ";	
				echo $page->getAttribute('href') . " - " . $page->nodeValue;
				echo "<br />";
				$productLink = $page->getAttribute('href');
				$productLink = str_replace(" ", "%20", $productLink);
				$product = file_get_contents($productLink);
				$product = mb_convert_encoding($product, 'HTML-ENTITIES', "UTF-8");
				$productDoc = new DOMDocument;
				$productDoc->loadHTML($product);
				$products = $productDoc->getElementsByTagName('a');
				foreach ($pages as $prod) {
					if(strpos($prod->getAttribute('href'), "Детайли")){
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - > ";	
						echo $prod->getAttribute('href');
						echo "<br />";

					}
					}
				}
								
			//sleep(2);

			}*/

		}
	}
	$conn->close();
	echo $i;
?>