<?php 	

//start RSS feed

header("Content-Type: application/xml; charset=UTF-8");

if($ccpage->moduletype == "comic" or $ccpage->moduletype =="blog"){

    //some cleanup functions
    
    function selfURL() {
    
    	$s =  empty($_SERVER["HTTPS"]) ? '' : (($_SERVER["HTTPS"] == "on") ? "s" : "");

    	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;

    	return $protocol."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

    }

    function strleft($s1, $s2) {

	    return substr($s1, 0, strpos($s1, $s2));

    }



    //start building xml

    $str = '<?xml version="1.0" encoding="UTF-8" ?>

	    <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

	    <channel>

    		<title>' . $ccpage->title . '</title>

    		<atom:link href="' . selfURL() . '" rel="self" type="application/rss+xml" />

    		<link>' . $ccsite->root . '</link>

    		<description>Latest from ' . $ccpage->title . '</description>

    		<language>en-us</language>';

    $items = array();

    $query = "SELECT * FROM cc_" . $tableprefix . $ccpage->moduletype ."s WHERE " . $ccpage->moduletype . "=:id AND publishtime <= " . time() . " ORDER BY publishtime DESC LIMIT 20";

    $stmt = $cc->prepare($query);

    $stmt->execute(['id' => $ccpage->module->id]);

    $recent = $stmt->fetchAll();
    
    foreach($recent as $row){
    
    	$str .= '<item><title><![CDATA[' . $ccpage->title . ' - ' . html_entity_decode($row['title'],ENT_QUOTES) . ']]></title>';
        
        if($ccpage->moduletype == "comic"){
    	    $desc_data = $row['transcript'];
        }else{
            $desc_data = $row['content'];
        }
        
    	$desc_data = preg_replace("#(<\s*a\s+[^>]*href\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '<a href="' . $ccsite->root . '$2$3', $desc_data);
    
    	$desc_data = preg_replace("<html>", '', $desc_data);
    
    	$desc_data = preg_replace("<body>", '', $desc_data);
    
    	$desc_data = preg_replace("</html>", '', $desc_data);
    
    	$desc_data = preg_replace("</body>", '', $desc_data);
    
        if(!empty($desc_data)){
    
        	$dom = new DOMDocument();
        
        	@$dom->loadHTML($desc_data);
    
        	for ($i=0; $i<$dom->getElementsByTagName('img')->length; $i++) {
        
        		$encoded = implode("/", array_map("rawurlencode",
        
        			 explode("/", $dom->getElementsByTagName('img')
        
        						->item($i)->getAttribute('src'))));
        
        		$dom->getElementsByTagName('img')
        
        				->item($i)
        
        				->setAttribute('src',$encoded);
        
        	}
        
        }
    
    	$desc_data = $dom->saveHTML();
    
    	$desc_data = str_replace("<html>", '', $desc_data);
    
    	$desc_data = str_replace("<body>", '', $desc_data);
    
    	$desc_data = str_replace("</html>", '', $desc_data);
    
    	$desc_data = str_replace("</body>", '', $desc_data);
    
        if($ccpage->moduletype == "comic"){
        	$desc_data = '<a href="' . $ccsite->root . $ccpage->module->slug . '/' . $row['slug'] . '"><img src="' . $ccsite->root . 'comicsthumbs/' . $row['comicthumb'] . '" /><br />Read it on the site!</a><br />' . $desc_data;
        }else{
            $desc_data = '<h2><a href="' . $ccsite->root . $ccpage->module->slug . '/' . $row['slug'] . '">' . $row['title'] . '</a></h2><div>' . $desc_data . '</div>';
        }
    
    	$str .= '<description><![CDATA[' . $desc_data . ']]></description>';
    
    	$str .= '<link>' . $ccsite->root . $ccpage->module->slug . '/' . $row['slug'] . '</link>';
    
    	$str .= '<author>' . $ccsite->siteauthor . '</author>';
    
    	$str .= '<pubDate>' . date("D, d M Y H:i:s O", $row['publishtime']) . '</pubDate>';
    
    	$str .= '<guid>' . $ccsite->root . $ccpage->module->slug . '/' . $row['slug'] . '</guid>';
    
    	$str .= '</item>';
    
    }
    
    $str .= '</channel></rss>';
    
    echo $str;

}else{
    echo $user_lang['This page does not have an RSS feed.'];
}

?>