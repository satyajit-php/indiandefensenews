<?php
$date=date('d-m-Y');
$days_ago = date('d-m-Y', strtotime('-2 days', strtotime($date)));
$file='/var/www/html/backup/indiandefence_news_'.$days_ago.'.sql';
 if (file_exists($file)) {
	 //echo "hi";
        unlink($file);
    } 
$filename='indiandefence_news_'.date('d-m-Y').'.sql';
$result=exec('mysqldump indiandefence --password=defencepass --user=root --single-transaction >/var/www/html/backup/'.$filename.' 2>&1',$output);
