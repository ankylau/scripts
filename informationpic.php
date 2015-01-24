<?php
/*
 *echo "hello";
 */
$u_agent = $_SERVER['HTTP_USER_AGENT'];
$bname = 'Unknown';
$platform = 'Unknown';
$version = '';
if (preg_match('/linux/i', $u_agent)){
    $platform = 'Linux';
}
elseif (preg_match('/macintosh|mac os x/i', $u_agent)){
    $platform = 'mac';
}
elseif (preg_match('/windows|win32/i', $u_agent)){
    $platform = 'windows';
}
if(preg_match('/MSIE/i', $u_agent)&&!preg_match('/Opera/i', $u_agent))
{
    $bname = 'Internet Explorer';
    $ub = 'MSIE';
}
elseif(preg_match('/Firefox/i',$u_agent))
{
    $bname = 'Mozilla Firefox';
    $ub = 'Firefox';
}
elseif(preg_match('/Chrome/i',$u_agent))
{
    $bname = 'Google Chrome';
    $ub = 'Chrome';
}
elseif(preg_match('/Safari/i',$u_agent))
{
    $bname = 'Apple Safari';
    $ub = 'Safari';
}
elseif(preg_match('/Opera/i',$u_agent))
{
    $bname = 'Opera';
    $ub = 'Opera';
}
$known = array('Version', $ub, 'other');
$pattern = '#(?<browser>'.join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
if (!preg_match_all($pattern, $u_agent, $matches)) {

}

$i = count($matches['browser']);
if ($i != 1) {
    if (strripos($u_agent, "Version") < strripos($u_agent,$ub)){
    $version = $matches['version'][0];
    }
    else {
    $version = $matches['version'][1];
    }
}
else {
    $version = $matches['version'][0];
}
if($version == null || $version=="") {
    $version="?";
}
$ua = [
    'userAgent' => $u_agent,
    'name'      => $bname,
    'version'   => $version,
    'platform'  => $platform,
    'pattern'   => $pattern
];

$browser = "Your browser: ".$ua['name']." ".$ua['version']." on ".$ua['platform'];
$img_number = imagecreate(850,60);
$backcolor = imagecolorallocate($img_number,125,185,222);
$textcolor = imagecolorallocate($img_number,255,255,255);

imagefill($img_number,0,0,$backcolor);


$agent=$_SERVER['HTTP_USER_AGENT'];
$ip=$_SERVER['REMOTE_ADDR'];
$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$url = "http://api.netimpact.com/qv1.php?key=uiWMSWCvUGimIahk&qt=geoip&d=json&q=$ip";
$d = file_get_contents($url);
$details = json_decode($d);
$data = explode(',' , $d);
$info = array(
    'country_code' => $data[6] ,
    'country_name' => $data[2] ,
    'region_name' => $data[1] ,
    'city' => $data[0] ,
    'latitude' => $data[4] ,
    'longitude' => $data[5] ,
    'isp' => $data[3] ,
);
$messages = "Dear friends from $data[0], $data[1], $data[2]($data[4], $data[5]).";
$message2 = "Using $agent";
$time = date('Y-m-d H:i:s');
Imagestring($img_number,10,5,0,$messages,$textcolor);
Imagestring($img_number,10,5,20,$browser,$textcolor);
Imagestring($img_number,10,5,40,$time,$textcolor);

header("Content-type: image/jpeg");
imagejpeg($img_number);
?>
