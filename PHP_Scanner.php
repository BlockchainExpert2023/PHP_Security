<?php

$client_ip = "192.168.1.1";

//echo "<img src=x onerror=\"alert(require('child_process').execSync('calc').toString());\">";

error_reporting(0);

class Ipscanner
{
    var $timeout;
    function banner(){
        echo "------------------------------------\r\n";
        echo "--        SIMPLE IP SCANNER       --\r\n";
        echo "------------------------------------\r\n";
        echo "[Scan] ".$this->ip."\r\n\n";
    }
    function pesan($pesan){
        echo "[".date("H:i:s")."] ".$pesan."\r\n";
    }
    function scan($ip)
    {
        $this->ip = $ip;
        $ip     = explode("-", $ip);
        $start  = explode(".", $ip[0]);
        $this->banner();
 
        for ($i=0; $i <3; $i++) {
            $ips .= $start[$i].".";
        }
        echo $this->timeout;
        for ($i=$start[3]; $i <$ip[1]+1; $i++) {
            $ch = curl_init($ips.$i);  
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT ,0);
            curl_setopt ($ch, CURLOPT_TIMEOUT, 2);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);  
            $data = curl_exec($ch);  
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
            curl_close($ch);  
            if($httpcode>=200 && $httpcode<300){  
                $this->pesan($ips.$i." -> Live");
                $live[] = $ips.$i;
            } else {  
                $this->pesan($ips.$i." -> Die");
                $die[] = $ips.$i;
            }
        }
        echo "---- [ IP LIVE ] ----\r\n";
        foreach ($live as $key => $ip) {
            echo " > ".$ip."\r\n";
        }
        }
 
}
 
$ipscanner = new Ipscanner;
$ipscanner->scan($client_ip);

ini_set('max_execution_time', 0);
ini_set('memory_limit', -1);

$host = $client_ip;
//$ports = array(21, 25, 80, 81, 110, 143, 443, 587, 2525, 3306);
$ports = array(80);

foreach ($ports as $port)
{
    $connection = @fsockopen($host, $port, $errno, $errstr, 2);

    if (is_resource($connection))
    {
        echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";

        fclose($connection);
    }
    else
    {
        echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
    }
}

?>
