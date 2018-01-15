<?php 


 
 
//curl ini
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER,0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT,20);
curl_setopt($ch, CURLOPT_REFERER, 'http://www.bing.com/');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8');
curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // Good leeway for redirections.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Many login forms redirect at least once.
curl_setopt($ch, CURLOPT_COOKIEJAR , "cookie.txt");

//curl get
$x='error';
$url='https://www.instagram.com/explore/tags/fireworksnight/?__a=1';
$url = "https://www.instagram.com/graphql/query/?query_id=17882293912014529&tag_name=fireworksnight&first=10";
$url = "https://www.instagram.com/graphql/query/?query_id=17882293912014529&tag_name=fireworksnight&first=11";

//$url.= "&after=J0HWUqg-gAAAF0HWUlIzAAAAFiAA" ; 

//$url = "https://www.instagram.com/graphql/query/?query_id=17880160963012870&id=1507585768&first=12";

echo ' Results for :'.$url .'<hr>';

curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_URL, trim($url));
$exec=curl_exec($ch);
$x=curl_error($ch);

echo '<pre>';
print_r( json_decode( $exec));
exit;


?>