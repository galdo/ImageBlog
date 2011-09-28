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

    // make instance of application
    $ImageBlogInstance = new ImageBlog();
    
} else {
    error("Error running ImageBlog.\n");
}

// generate main output
print("<html>\n");
print("<head><title>".$imageblog['title']."</title><link rel=\"stylesheet\" type=\"text/css\" href=\"".getcwd() . "/tpl/" . $template['stylesheet']."\" /></head>\n");


$entryList = $ImageBlogInstance->read_post();
print $ImageBlogInstance->create_html($entryList[0]);

print("</html>\n");

?>