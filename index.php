<?php

/****************************************************
 * INFO: load main functionality
 *       The main library is loaded containing the
 *       functionality to upload / share images 
 ****************************************************/

if ((file_exists(getcwd() . "/lib/imageblog-0.1.php")) && (file_exists(getcwd() . "/conf/imageblog.conf.php"))) {
    require_once (getcwd() . "/lib/imageblog-0.1.php");
    require_once (getcwd() . "/conf/imageblog.conf.php");
    
    // read template
    if (sizeof($GLOBALS[$imageblog['template']]) > 0) {
        $template = $GLOBALS[$imageblog['template']];
    }

    // read command line parameter -> transfer to get (normally used with browser window)
    if(isset($argv[1])) {
        $_GET['page'] = $argv[1];
    }
    
    //read the param
    $page = $_GET['page'];
    if (sizeof($page) == 0) $page = 0;


    // make instance of application
    $ImageBlogInstance = new ImageBlog();
    
} else {
    error("Error running ImageBlog.\n");
}


// generate main output
print("<html>\n");
print("<head><title>".$imageblog['title']."</title><link rel=\"stylesheet\" type=\"text/css\" href=\"".getcwd() . "/tpl/" . $template['stylesheet']."\" /></head>\n");


$entryList = $ImageBlogInstance->read_post();

//TODO: Extend template to deal with more entries per page
if ($page == 0) $prev = false; else $prev = $page - 1;
if ($page == sizeof($entryList) - 1) $next = false; else $next = $page + 1;

print $ImageBlogInstance->create_html($entryList[$page], $prev, $next);

print("<div class=\"footer\">Powered by ImageBlog</div>");
print("</html>\n");

?>