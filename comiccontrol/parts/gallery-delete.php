<?php //gallery-delete.php - handles deleting existing images ?>

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

<?php

//get selected image
$query = "SELECT * FROM cc_" . $tableprefix . "galleries WHERE id=:id";
$stmt = $cc->prepare($query);
$stmt->execute(['id' => getSlug(4)]);
$thisimage = $stmt->fetch();

//if the image wasn't found, throw an error
if(empty($thisimage)){
	echo '<div class="msg error f-c">' . $lang['No image was found with this information.'] . '</div>';
}

//otherwise, proceed
else{
	
	//delete the image if confirmed
	if(getSlug(5) == "confirmed"){
		
		$stmt = $cc->prepare("DELETE FROM cc_" . $tableprefix . "galleries WHERE id=:id");
		$stmt->execute(['id' => $thisimage['id']]);
		?>
		
		<div class="msg success f-c"><?=$lang['This image has been deleted.']?></div>
		
		<?php
		
		
	}else{
	
		//prompt user to delete image ?>

		<div class="msg prompt f-c"><?=$lang['Are you sure you want to delete this image? This action cannot be undone.']?></div>
		<?php

		echo '<div class="cc-btn-row">';
		buildButton(
			"light-bg",
			$ccurl . $navslug.'/'.$ccpage->module->slug.'/delete-image/' . $thisimage['id'] . '/confirmed',
			$lang['Yes']
		);
		buildButton(
			"dark-bg",
			$ccurl . $navslug.'/'.$ccpage->module->slug."/",
			$lang['No']
		);
		echo '</div>';
		
	}

}
?>

</main>