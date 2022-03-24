<?php 

 $file=fopen("log.txt","w+");
 echo fwrite($file,date('YmdHis',time()));
 fclose($file);


 ?>