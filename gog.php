<!DOCTYPE html>
<style>
#top-bar {
  position: fixed;
  top: 0px;
  left: 95%;
  z-index: 999;
  width: 5%;
  height: 20px;
  bbackground:#F0F0F0;  
  bbackground:white;  
   -webkit-box-shadow: 0 0 5px black;
    -moz-box-shadow:    0 0 5px black;
    bbox-shadow:         0 0 5px black;
}
</style>
<html lang="en">
<div id=top-bar><a href="datayoung.com" rel="publisher">datayoung</a></div>
<?
$url = $_GET["url"];
if (!$url) $url = "http://www.google.com";
fopen("cookies.txt", "w");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,0);
    curl_setopt( $ch, CURLOPT_COOKIESESSION, true );
	curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //redirect follow
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_COOKIEFILE,'cookies.txt');
    curl_setopt($ch,CURLOPT_COOKIEJAR,'cookies.txt');
 $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => 0,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i        
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => 1     // Disabled SSL Cert checks
 );	
curl_setopt_array($ch, $options);		
$data = curl_exec($ch);
curl_close($ch);
echo $data;
if (!$data) echo file_get_contents($url);
?>
</html>