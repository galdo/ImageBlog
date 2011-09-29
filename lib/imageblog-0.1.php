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
    public function install_imageblog($cwd) {
        print("Installing ImageBlog...\n");
        
        mkdir ($cwd . "/data");
        touch ($cwd . "/data/blog.index");
    }
    
    /*************************************************
     * FUNCTION check_installed
     *          check if all required paths and files
     *          are existing within the environment
     *
     *          $cwd is the current working directory
     *          given by the caller
     *************************************************/
    public function check_installed($cwd) {
        if ((file_exists($cwd . "/data")) && (file_exists($cwd . "/data/blog.index"))) {
            return true;
        } else {
            return false;
        }
    }
    
    /*************************************************
     * FUNCTION read_post
     *          reads post from the index and generate
     *          an html valid output to print
     *
     *          $cwd is the current working directory
     *          given by the caller
     *************************************************/
    public function read_post($cwd) {
        if ($this->check_installed($cwd) == true) {
            //open blog index
            $blog_entries = file($cwd . "/data/blog.index", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
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
            
            return array_reverse($blogEntries);
            
        } else {
            //install imageblog correctly
            $this->install_imageblog($cwd);
        }
    }
    
    /*************************************************
     * FUNCTION write_post
     *          represents the interface to fill in
     *          the needed data an makes it persistant
     *          using the storage mechanism
     *
     *          $blog_entry is the array representing
     *          the blog entry with date[0], title[1],
     *          tags[2], filename[3]
     *************************************************/
    public function write_post($cwd, $blog_entry) {
        
        if ($this->check_installed($cwd) == true) {
            
            // (1) get existing blog entries
            $existingBlogEntries = $this->read_post($cwd);
            
            // (2) append new entry
            $existingBlogEntries = array_reverse($existingBlogEntries);
            array_push($existingBlogEntries, $blog_entry);
            
            // (3) store to database
            $dbHandle = fopen($cwd . "/data/blog.index",'w');
            
            foreach($existingBlogEntries as $entry) {
                $entryString = $entry['entry_date'].", ".$entry['entry_title'].", ".$entry['entry_tags'].", ".$entry['entry_file']."\n";
                fwrite($dbHandle, $entryString);   
            }
            fclose($dbHandle);
            
            return true;
            
        } else {
            $this->install_imageblog($cwd);
        }
    
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
     *          | tags          |
     *          | date          |
     *          -----------------
     *
     *          the blog entry array is reversed, that
     *          means the newest is on top of the list
     *          the oldest entry is the last one
     *          next = younger, prev = older
     *************************************************/
    public function create_html($blog_entry, $prev, $next) {
    
        //check type of $prev
        if ($prev == false) $prev = $next + 1;
        
        //check type of $next            
        if ($next == false) $next = 0;
    
        $retString = "<table class=\"entry\">\n";
        $retString = $retString . "<tr><td colspan=3 class=\"entry_title\">".$blog_entry['entry_title']."</td></tr>\n";
        $retString = $retString . "<tr><td colspan=3 class= \"entry_image\"><img src=\"".$blog_entry['entry_file']."\"></td></tr>\n";
        $retString = $retString . "<tr><td class=\"entry_info\"><span class=\"info\">Tags:</span> ".$blog_entry['entry_tags']."<br><span class=\"info\">Creation Date:</span> ".$blog_entry['entry_date']."</td>\n";
        
        //adding next and prev button
        $retString = $retString . "<td class=\"navigation\"><a href=\"index.php?page=".$prev."\">previous</a></td><td class=\"navigation\"><a href=\"index.php?page=".$next."\">next</a></td></tr>\n";
        
        $retString = $retString . "</table>\n\n";
        
        return $retString;
    }
}

?>