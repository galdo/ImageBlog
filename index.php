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
if ((file_exists($cwd. "/lib/imageblog-0.1.php")) && (file_exists($cwd . "/conf/imageblog.conf.php"))) {
    require_once ($cwd . "/lib/imageblog-0.1.php");
    require_once ($cwd . "/conf/imageblog.conf.php");
    
    //read template
    require_once($cwd . "/tpl/" . $imageblog['template'] . ".conf.php");
    if (sizeof($GLOBALS[$imageblog['template']]) > 0) {

        $template = $GLOBALS[$imageblog['template']];
    }

    //read command line parameter -> transfer to get (normally used with browser window)
    if(isset($argv[1])) {
        $_GET['page'] = $argv[1];
    }
    
    //read the param
    $page = $_GET['page'];
    if (sizeof($page) == 0) $page = 0;


    //make instance of application
    $ImageBlogInstance = new ImageBlog();
    
    //get available posts
    $entryList = $ImageBlogInstance->read_post($cwd); 
    
    /**** EXAMPLE HOW TO WRITE A POST ****/
    //$ImageBlogInstance->write_post($cwd, array('entry_date' => "today", 'entry_title' => "write test", 'entry_tags' => "", 'entry_file' => "test.jpg"));
    
} else {
    print_r("Error running ImageBlog.\n");
    exit();
}


/****************************************************
 * INFO: build the website
 *       the website frame and content is generated
 *       by using ->create_html from the ImageBlog-
 *       Library
 ****************************************************/

 
/**** HEADER ****/ 
print("<html>\n");
print("<head><title>".$imageblog['title']."</title>\n<link rel=\"stylesheet\" type=\"text/css\" href=\"tpl/".$template['stylesheet']."\" /></head>\n\n");



/**** CONTENT (SITE VISE) ****/
//TODO: Extend template to deal with more entries per page
if ($page == sizeof($entryList) - 1) $prev = false; else $prev = $page + 1;
if ($page == 0) $next = false; else $next = $page - 1;
print $ImageBlogInstance->create_html($entryList[$page], $prev, $next);


/**** FOOTER ****/
print("\n<div class=\"footer\">Powered by ImageBlog</div>\n");
print("</html>\n");


?>