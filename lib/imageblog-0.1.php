<?php

class ImageBlog {

    /*************************************************
     * FUNCTION install_imageblog
     *          is called every time check_installed
     *          return false. In this case all
     *          required folder are created within
     *          the environment
     *
     *          Current Requirements:
     *          - ./lib  --> check by require index.php
     *          - ./conf --> check by require index.php
     *          - ./data
     *          - ./data/blog.index
     *
     *          BlogIndex Format:
     *          - |date|title|tags|filename|
     *          - field separator ","
     *          - tag separator " "
     *************************************************/
    public function install_imageblog() {
        print("Installing ImageBlog...\n");
        
        mkdir (getcwd() . "/data");
        touch (getcwd() . "/data/blog.index");
    }
    
    /*************************************************
     * FUNCTION check_installed
     *          check if all required paths and files
     *          are existing within the environment
     *************************************************/
    public function check_installed() {
        if ((file_exists(getcwd() . "/data")) && (file_exists(getcwd() . "/data/blog.index"))) {
            return true;
        } else {
            return false;
        }
    }
    
    /*************************************************
     * FUNCTION read_post
     *          reads post from the index and generate
     *          an html valid output to print
     *************************************************/
    public function read_post() {
        if ($this->check_installed() == true) {
            //open blog index
            $blog_entries = file(getcwd() . "/data/blog.index", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            $counter = 0;
            $blogEntries = array();
            foreach ($blog_entries as $blog_entry) {
                //creates an array of substrings seperated by the delimeter ","
                $blog_entry = explode(",", $blog_entry);
                
                $entry_date  = trim($blog_entry[0]);
                $entry_title = trim($blog_entry[1]);
                $entry_tags  = trim($blog_entry[2]);
                $entry_file  = trim($blog_entry[3]);
                
                $entryArray = array('entry_date' => $entry_date, 'entry_title' => $entry_title, 'entry_tags' => $entry_tags, 'entry_file' => $entry_file);
                array_push($blogEntries, $entryArray);
                
                $counter++;
            }
            
            return $blogEntries;
            
        } else {
            //install imageblog correctly
            $this->install_imageblog();
        }
    }
    
    /*************************************************
     * FUNCTION write_post
     *          represents the interface to fill in
     *          the needed data an makes it persistant
     *          using the storage mechanism
     *************************************************/
    public function write_post() {
        return false;
    }
    
    /*************************************************
     * FUNCTION create_html
     *          creates the html content of a single
     *          entry which can be embedded into the
     *          main website frame
     *
     *          -----------------
     *          |     title     |
     *          -----------------
     *          |     image     |
     *          -----------------
     *          | tags  |  date |
     *          -----------------
     *************************************************/
    public function create_html($blog_entry, $prev, $next) {
        $retString = "<table class=\"entry\">";
        $retString = $retString . "<tr><td colspan=3 class=\"entry_title\">".$blog_entry['entry_title']."</td></tr>";
        $retString = $retString . "<tr><td colspan=3 class= \"entry_image\"><img src=\"".$blog_entry['entry_file']."\"></td></tr>";
        $retString = $retString . "<tr><td class=\"entry_info\"><span class=\"info\">Tags:</span> ".$blog_entry['entry_tags']."<br><span class=\"info\">Creation Date:</span> ".$blog_entry['entry_date']."</td>";
        
        //adding next and prev button
        $retString = $retString . "<td class=\"navigation\"><a href=\"index.php?page=".$prev."\">PREV</a></td><td class=\"navigation\"><a href=\"index.php?page=".$next."\">NEXT</a></td></tr>";
        
        $retString = $retString . "</table>";
        
        return $retString;
    }
}

?>