<?php
$ftp_server = "166.62.0.1";
$ftp_user_name = "nutritest";
$ftp_user_pass = "Nutri@123";
$pathloc = "/hd"; 
$storepathloc = "hd/downloaded/"; 
$search_productname = "mail.png"; 
$connection = ftp_connect($ftp_server);
if($connection){
  if(ftp_login($connection, $ftp_user_name, $ftp_user_pass)){
    ftp_pasv($connection, TRUE); 
    $max_level =1;
    $files = array();
    if($max_level < 0) return $files;
    if($pathloc !== '/' && $pathloc[strlen($pathloc) - 1] !== '/') $pathloc .= '/';
    $files_list = ftp_nlist($connection, $pathloc);
	echo "<pre>";
	print_r($files_list);
    $count = 1;
    foreach($files_list as $assetfiles){
        if ($search_productname == $assetfiles) {
			
			echo $local_file = "D:/wamp/www/afdc/downloaded/".$assetfiles;
			echo "<br >";
			echo $source_dir = "/var/chroot/home/content/67/11716167/html/nutritest/hd/".$assetfiles;
            if (ftp_get($connection, $local_file, $source_dir, FTP_BINARY)) {
			  echo "successfully";
			} else {
			  echo "problem";
			}
		   
		}
    }
	
    ftp_close($connection);
 }
} 

?>
