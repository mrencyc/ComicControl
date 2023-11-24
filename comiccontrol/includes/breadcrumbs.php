<?php //breadcrumbs.php - outputs location header at top of backend pages ?>

<header id="navheader" class="dark-bg no-arrow">

	<?php

		$currentpage = getSlug(1);

		//header adding for modules since they have a special title format and extra slug

		if($currentpage == "modules"){

			//output the module title and type

			echo '<div class="header-block header-page has-subtitle"><span class="title">';
			echo '<a href="' . $ccurl . $navslug . '/' . getSlug(2) . '">' . $ccpage->title . '</a>';
			echo '</span><br /><span class="subtitle">';
			echo str_replace('%s',ucwords($ccpage->moduletype),$lang['%s Module']);
			echo '</span>';

			//output a caret if there's an action

			if(getSlug(3) != "") echo '</div><div style="display:inline-block; line-height:50px;"><i class="fa fa-caret-right"></i></div><div class="header-block">';

			//Output an action title if one is selected

			echo match(getSlug(3)){
				"add-post" => $lang['Add post'],
				"edit-post" => $lang['Edit post'],
		                "manage-posts" => $lang['Manage posts'],
        		        "delete-post" => $lang['Delete post'],
        		        "manage-storylines" => $lang['Manage storylines'],
        		        "add-storyline" => $lang['Add storyline'],
        		        "edit-storyline" =>  $lang['Edit storyline'],
				"rearrange-storylines" => $lang['Rearrange storylines'],
				"delete-storyline" => $lang['Delete storyline'],
				"manage-options" => $lang['Manage module options'],
				"add-image" =>  $lang['Add an image'],
				"edit-image" => $lang['Edit image'],
				"delete-image" => $lang['Delete image'],
				"rearrange-images" => $lang['Rearrange images'],
				default => "",
			};

			echo '</div>';

		}

		//if not a module, echo the title and action

		else{

		?>

		<div class="header-block">

		<?php

			//output the main title for the page

			echo match($currentpage){
				"image-library" =>  '<a href="' . $ccurl . $navslug . '/">' . $lang['Image Library'] . '</a>',
				"site-options" => '<a href="' . $ccurl . $navslug . '/">' . $lang['Site Options'] . '</a>',
				"users" =>  '<a href="' . $ccurl . $navslug . '/">' . $lang['Users'] . '</a>',
				"update-check" => '<a href="' . $ccurl . $navslug . '/">' . $lang['Check for Updates'] . '</a>',
				"upgrade" => '<a href="' . $ccurl . 'update-check/">' . $lang['Check for Updates'] . '</a>',
				"templates" => '<a href="' . $ccurl . $navslug . '/">' . $lang['Templates'] . '</a>',
				"manage-modules" => '<a href="' . $ccurl . $navslug . '/">' . $lang['Manage modules'] . '</a>',
				"plugins" => '<a href="' . $ccurl . $navslug . '/">' . $lang['Plugins'] . '</a>',
				default => '<a href="' . $ccurl . $navslug . '/">' . $lang['Home'] . '</a>',
			};

			//add a caret if there's an action

			if(getSlug(2) != "") echo '</div><div style="display:inline-block; line-height:50px;"><i class="fa fa-caret-right"></i></div><div class="header-block">';
    
            //output the action title if one is selected    
    
    		echo match(getSlug(2)){
			"add-user" => $lang['Add a user'],
			"edit-user" => $lang['Edit user'],
			"delete-user" => $lang['Delete user'],
			"permissions-user" => $lang['Manage Permissions'],
			"add-module" =>  $lang['Add a module'],
			"delete-module" => $lang['Delete module'],
			"delete-image" => $lang['Delete image'],
			default => '',
    		};

			echo '</div>';

		}

	?>

	<?php //output logout button for desktop version ?>

	<div class="header-block dark-bg" id="logout"><a href="<?=$ccurl?>logout"><?=$lang['Logout']?></a></div>

</header>
