<?php 
//module.php - switchboard for managing module actions

$permission = false;
if($ccuser->authlevel == 2) $permission = true;
else{
	$stmt = $cc->prepare("SELECT * FROM cc_" . $tableprefix . "users_permissions WHERE userid=:userid AND moduleid=:moduleid");
	$stmt->execute(['userid' => $ccuser->id, 'moduleid' => $ccpage->module->id]);
	if($stmt->rowCount() < 1){
		
		echo '<main id="content"><div class="msg error f-c">' . $lang['You do not have permission to edit this module.'] . '</div></main>';
	}
	else $permission = true;
}
if($permission){
// include appropriate script for the action
switch($ccpage->moduletype){
	case "comic":
		match(getSlug(3)){
		    "add-post" => require_once('comic-post-add.php'),
		    "edit-post" => 	require_once('comic-post-edit.php'),
		    "manage-posts" => require_once('comic-post-manage.php'),
		    "delete-post" => require_once('comic-post-delete.php'),
		    "add-storyline" => require_once('comic-storyline-add.php'),
		    "edit-storyline" => require_once('comic-storyline-edit.php'),
		    "rearrange-storylines" => require_once('comic-storyline-rearrange.php'),
		    "delete-storyline" => require_once('comic-storyline-delete.php'),
		    "manage-options" => require_once('comic-options.php'),
		    default => 	require_once('comic-main.php'),
		};
		break;
	case "blog":
		match(getSlug(3)){
		    "add-post" => require_once('blog-post-add.php'),
		    "edit-post" => require_once('blog-post-edit.php'),
		    "delete-post" => require_once('blog-post-delete.php'),
		    "manage-options" => require_once('blog-options.php'),
		    default => require_once('blog-main.php'),
		};
		break;
	case "text":
		match(getSlug(3)){
		    "manage-options" => require_once('text-options.php'),
		    default => require_once('text-edit.php'),
		};
		break;
	case "gallery":
		match(getSlug(3)){
		    "add-image" => require_once('gallery-add.php'),
		    "rearrange-images" => require_once('gallery-rearrange.php'),
		    "edit-image" => require_once('gallery-edit.php'),
		    "delete-image" => require_once('gallery-delete.php'),
		    "manage-options" => require_once('gallery-options.php'),
		    "description" => require_once('gallery-description.php'),
		    default => require_once('gallery-main.php'),
		};
		break;
    }	
}

?>