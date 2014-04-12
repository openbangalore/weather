<?php
$db_path ='metar_db.sqlite';
$data_url = 'http://aviationweather.gov/adds/metars/?station_ids=VOB&std_trans=standard&chk_metars=on&hoursStr=most+recent+only&submitmet=Submit';

$ch = curl_init ($data_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$data=curl_exec($ch);
curl_close ($ch);

$dom = new domDocument; 
$dom->loadHTML($data);
$dom->preserveWhiteSpace = false; 
$fonts = $dom->getElementsByTagName('font'); 
foreach ($fonts as $row) 
{
    //print $row->nodeValue;
    $val = $row->nodeValue;
    $db = new PDO('sqlite:/media/thej/data2/weather/metar/metar_db.sqlite');
    $sql = "insert into metar(data) values(?)";
    $stmt = $db->prepare($sql);
    $fill_array = array($val);
    $stmt->execute($fill_array);
    echo $stmt->errorCode().'<br><br>';
    echo $stmt->rowCount();

}

?>