<div id="content">



<?php



if($ccuser->authlevel != 2){

	echo '<div class="msg error f-c">' . $lang['You do not have permission to access this page.'] . '</div>';

}else{

//set template currently being edited

$template = "";

$template = $_POST['page-template'];



//if template was submitted, save teh changes

if(!empty($_POST['templatechange'])){

	

	//save the changes to the file

	if(file_put_contents('../templates/' . $_POST['templatechange'], $_POST['templatecontent'])){

		echo '<div class="msg success">' . $lang['This template has been successfully saved.'] . '</div>';

	}

	

	//if there was an error, show it

	else{

		echo '<div class="msg error">' . $lang['There was an error saving this template.  Please try again.'] . '</div>';

	}

	

	$template  = $_POST['templatechange'];

	

}



//output template editing message

?>

<p><?=$lang['Use the editor below to edit the code for your template files.  You can also use the dropdown to change to a different template file to edit.']?></p>





<?php

echo '<form name="templatechoose" action="" method="post" id="templatechoose">';



//get available template files

$templatefiles = array();

$templatefiles = recurseDirectories("../templates/",$templatefiles);

$temparr = array();

foreach($templatefiles as $file){

	$tempstr = substr($file, 13);

	if(substr($tempstr, -1) != "." && substr($tempstr,-1) != "/" && (substr($tempstr,-4) == ".css" || substr($tempstr,-4) == ".php" || substr($tempstr,-3) == ".js")){

		$temparr[$tempstr] = $tempstr;

	}

}

$templatefiles = $temparr;



$forminputs = array();



//build form for switching between template files

array_push($forminputs,

	array(

		array(

			'type' => "select",

			'label' => $lang['Page template'],

			'tooltip' => $lang['tooltip-changetemplate'],

			'name' => "page-template",

			'regex' => "select",

			'options' => $templatefiles,

			'current' => $template

		)

	)

);



buildForm($forminputs);



if($template == ""){

	$template = array_shift($templatefiles);

}



$templatestr = file_get_contents('../templates/' . $template);



//close out the template switching form

echo '</form>';



//start the form for editing the template content

echo '<p><h2 class="formheader" id="formheader">' . $template . '</h2></p>';

echo '<form name="templateedit" action="" method="post" id="templateedit">';

echo '<div id="editor">' . htmlentities($templatestr) . '</div>';



//output hidden textarea containing text from Ace editor

echo '<input type="hidden" name="templatecontent" value="this should be blank" id="templatecontent" />';



//output hidden input marker to check if the template was submitted

echo '<input type="hidden" value="' . $template . '" name="templatechange" />';



//close out the template editing form

?>

<button class="full-width light-bg" style="margin-top:20px;" type="submit" id="submitform"><?=$lang['Submit changes']?></button>

</form>



<script src="js/ace/ace.js" type="text/javascript" charset="utf-8"></script>

<script>

    //script to load and configure Ace editor

    var editor = ace.edit("editor");

    editor.setTheme("ace/theme/cloud9_day");

    

    //set editor mode by filename 

    var filename = document.getElementById('formheader').innerHTML;

    var extension = filename.split('.').pop();

    switch(extension) {

        case "php":

            editor.session.setMode("ace/mode/php");

            break;

        case "css":

            editor.session.setMode("ace/mode/css");

            break;

        case "js":

            editor.session.setMode("ace/mode/javascript");

            break;

        default:

            editor.session.setMode("ace/mode/text");

    } 

    

    //push value from Ace editor to templatecontent on submit

    var form = document.getElementById('submitform');

    form.addEventListener('click', function ()

    {

        var textarea = document.getElementById('templatecontent');

        textarea.value = editor.getValue();

    });

</script>



<script>

//script for switching template

$('form select').on('change',function(){

	$(this).closest('form').submit();

});

</script>



<?php



}

//function for recursing through directories and getting template files

function recurseDirectories($dir,$arr){

	$temparr = scandir($dir);

	foreach($temparr as $file){

		if(is_dir($dir.$file) && $file != "." && $file != ".."){

			$arr = recurseDirectories($dir . $file . '/',$arr);

		}

		else array_push($arr,$dir.$file);

	}

	return $arr;

}

?>

</div>
