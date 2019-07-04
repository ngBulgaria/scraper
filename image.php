<?php 

//copy('https://bio-herba.com/products_photos/100106/63188767_big.jpg', 'file.jpg');
$text =  urlencode("https://bio-herba.com/bg/Листинг-на-продукти-в-категория/2542201/Хранителни добавки.html");
echo $text;
$text = urldecode("https%3A%2F%2Fbio-herba.com%2Fbg%2F%D0%9B%D0%B8%D1%81%D1%82%D0%B8%D0%BD%D0%B3-%D0%BD%D0%B0-%D0%BF%D1%80%D0%BE%D0%B4%D1%83%D0%BA%D1%82%D0%B8-%D0%B2-%D0%BA%D0%B0%D1%82%D0%B5%D0%B3%D0%BE%D1%80%D0%B8%D1%8F%2F2542201%2F%D0%A5%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D0%B");
echo "<br>".$text;
?>
