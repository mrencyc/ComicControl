<?php 

//rss switch

if($ccpage->subslug == "rss"){ 



	include($ccsite->ccroot . 'parts/rss.php');

	

}else{



include('templates/basic/includes/header.php');



$ccpage->module->display();



include('templates/basic/includes/footer.php'); 



}?>
