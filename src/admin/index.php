<?php

$cwd = getcwd();
require_once ($cwd . "/../conf/imageblog.conf.php");
require_once ($cwd . "/../tpl/".$imageblog['template'].".conf.php");

require_once ($cwd . "/../lib/imageblog-0.1.php");

//get template settings for picture transformation
$template = $GLOBALS[$imageblog['template']];

/**** HEADER ****/ 
print("<html><head><title>ImageBlog Admin Interface</title>\n");
print_r($_FILES['entry_file']);

/**** CONTENT ****/ 

if (($_FILES['entry_file']['error'] == 0) && (count($_FILES['entry_file']) > 0)){
    //create redirection
    print("<meta http-equiv=\"refresh\" content=\"5;url=../index.php\"></head><body>");

    //file already uploaded --> create the blog entry
    $entry_date  = date($imageblog['date_format']);
    $entry_title = $_POST['entry_title'];
    $entry_tags  = $_POST['entry_tags'];
    $entry_file  = $imageblog['data_path']."/".$_FILES['entry_file']['name'];
    
    //copy the file to the data dircetory
    move_uploaded_file($_FILES["entry_file"]["tmp_name"], $cwd."/../".$entry_file);
    
    //create blog entry
    $ImageBlogInstance = new ImageBlog();
    $ImageBlogInstance->write_post($cwd."/..", array('entry_date' => $entry_date, 'entry_title' => $entry_title, 'entry_tags' => $entry_tags, 'entry_file' => $entry_file), $template['image_size']);

    //reset data
    $entry_date  = "";
    $entry_title = "";
    $entry_tags  = "";
    $entry_file  = "";

    $_FILES['entry_file'] = array();

    print ("The entry ".$entry_title." successfully created.<br>You will be redirected in 5s...");
} else {
    print("</head><body><form  enctype=\"multipart/form-data\" action=\"index.php\" method=\"post\" target=\"_self\">\n
    <table>
    <!-- hier folgen die Formularelemente -->
    <tr><td>Title:</td><td><input type=\"text\" name=\"entry_title\" /></td></tr>
    <tr><td>Tags:</td><td><input type=\"text\" name=\"entry_tags\" /></td></tr>
    <trd><td>Image File:</td><td><input type=\"file\" name=\"entry_file\" /></td></tr>
    <tr><td colspan=\"2\"><input type=\"submit\" value=\"create\"></td></tr>
    </table>
    
    </form>");
}

/**** FOOTER ****/ 
print("</body></html>\n");

?>