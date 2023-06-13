<?php 
//rss switch
if($ccpage->subslug == "rss"){ 

	include($ccsite->ccroot . 'parts/blog-rss.php');
	
}else{

include('templates/dimestore/includes/header.php');

$ccpage->module->display();

include('templates/dimestore/includes/footer.php'); 

}?>