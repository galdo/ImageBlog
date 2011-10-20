<?php

/****************************************************
 * INFO: set global settings
 ****************************************************/
$cwd = getcwd();        //< get current working directory


/****************************************************
 * INFO: load main functionality and settings
 *       The main library is loaded containing the
 *       functionality to upload / share images
 *
 *       also settings and templates are loaded 
 ****************************************************/
if ((file_exists($cwd. "/../lib/imageblog-0.1.php")) && (file_exists($cwd . "/../conf/imageblog.conf.php"))) {
    require_once ($cwd . "/../lib/imageblog-0.1.php");
    require_once ($cwd . "/../conf/imageblog.conf.php");

	//make instance of application
    $ImageBlogInstance = new ImageBlog();
    
    //get available posts
    $entryList = $ImageBlogInstance->read_post($cwd); 

} else {
    print_r("Error running ImageBlog.\n");
    exit();
}


foreach ($entryList as $entry) {
	print_r($entry["date"]."\t".$entry["title"]."\t".$entry["tags"]."\t".$entry["filename"]."\n");
}

header("Content-type: application/txt");
header("Content-Disposition: attachment; filename=\"blog.index\"");
readfile($cwd . "/../" . $imageblog["data_path"] . "/blog.index");


?>