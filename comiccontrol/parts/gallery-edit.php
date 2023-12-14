<?php //gallery-edit.php - handles editing existing images ?>



<?php



//create and output quick links

$links = array(

	array(

		'link' => $ccurl . $navslug . '/' . $ccpage->module->slug,

		'text' => str_replace('%s',$ccpage->title,$lang['Return to managing %s'])

	),

	array(

		'link' => $ccurl . $navslug . '/' . $ccpage->module->slug . '/add-image',

		'text' => $lang['Add another image']

	)

);

quickLinks($links);



?>



<main id="content">



<?php //include necessary libraries ?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js" type="text/javascript" /></script>



<?php 



//get current image

$query = "SELECT * FROM cc_" . $tableprefix . "galleries WHERE id=:id";

$stmt = $cc->prepare($query);

$stmt->execute(['id' => getSlug(4)]);

$thisimage = $stmt->fetch();



//submit page if posted

if(!empty($_POST['submitted'])){

	

	//set values for the query 

    if(!empty($_POST['image-finalfile'])){

	    $imgname = $_POST['image-finalfile'];
	    
	    $thumbname = $_POST['image-thumbnail'];
	    
	    $imgupdate = TRUE;
	   
    }else{

        $imgname = $thisimage['imgname'];

        $thumbname = $thisimage['thumbname'];
        
        $imgupdate = FALSE;

    }

	$caption = $_POST['image-caption'];

	$gallery = $ccpage->module->id;

	

	//create query

	$query = "UPDATE cc_" . $tableprefix . "galleries SET imgname=:imgname,thumbname=:thumbname,caption=:caption WHERE id=:id";

	$stmt = $cc->prepare($query);

	$stmt->execute(['imgname' => $imgname, 'thumbname' => $thumbname, 'caption' => $caption, 'id' => $thisimage['id']]);

	

	//continue if image successfully edited

	if($stmt->rowCount() > 0){

        //If the gallery image was changed, clean up the old unused images
			
	    if($imgupdate){
	        
	        unlink('../uploads/'.$thisimage['imgname']);
	        
		    unlink('../uploads/'.$thisimage['thumbname']);
		    
		}

		?>

		<div class="msg success f-c"><?=$lang['Your image was successfully edited.']?></div>

		<?php

		echo '<div class="cc-btn-row">';

		buildButton(

			"dark-bg",

			$ccurl . $navslug . '/' . $ccpage->module->slug . '/edit-image/' . $thisimage['id'],

			$lang['Edit this image again']

		);

		echo '</div>';

	}

		

	//output error message if failed

	else{

		?>

		<div class="msg error f-c"><?=$lang['There was an error editing your image.  Please try again.']?></div>

		<?php

	}

	

}else{



	//start the form ?>



	<form action="" method="post" enctype="multipart/form-data">

		

		<?php // image uploader area ?>

		<div class="currentfileholder"><button class="full-width dark-bg toggle-current-file"><span class="current-file-text"><?=$lang['View current file']?></span> <i class="fa fa-angle-down"></i></button>

			<div class="currentfile"><img src="<?=$ccsite->root . 'uploads/' . $thisimage['imgname']?>" /></div>

		</div>

		<?php buildImageInput($lang['Change file...'],false); 

		

		//build text editor for image caption

		buildTextEditor($lang['Image caption'],"image-caption",$lang['tooltip-gallerycaption'],$thisimage['caption']);

		?>

		<input type="hidden" value="submitted" name="submitted" />

		

		<?php //close out the form ?>

		<button class="full-width light-bg" style="margin-top:20px;" type="button" id="submitform"><?=$lang['Submit changes']?></button>

	</form>

	

	<script>

	//include script for showing/hiding current image

	$('.toggle-current-file').on('click',function(e){

		e.preventDefault();

		$(this).parent().find('.currentfile').slideToggle();

		$(this).find('.current-file-text').text(function(i, text){

			  return text === 'View current file' ? 'Hide current file' : 'View current file';

		});

		$(this).find('i').toggleClass('fa-angle-down fa-angle-up');

	});

	</script>

	<?php 

	

	//include relevant javascript

	$imgfolder = "uploads/";

	include('includes/form-submit-js.php');

	include('includes/img-upload-js.php');

	include('includes/content-editor-js.php');

}

?>



</main>
