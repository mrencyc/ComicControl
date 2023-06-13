<?php 
//rss switch
if($ccpage->subslug == "rss"){ 

	include($ccsite->ccroot . 'parts/blog-rss.php');
	
}else{

include('templates/dimestore/includes/header.php');

include('templates/dimestore/Test.html');

include('templates/dimestore/includes/footer.php'); 

}?>