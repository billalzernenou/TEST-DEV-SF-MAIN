<?php

declare(strict_types=1);

namespace App\Service\Images\Types;

/**
 * this class dedicated tovalid images according to allowed extentions 
 */
class ImageValidator
{

    private $allowed_extensions = array();

    /**
     * initialize $allowed_extensions array of string 
     */
    public function __construct()
    {
        // initialize   
        $this->allowed_extensions =  array("png", "jpg", "jpeg");;
    }

    /**
     * @param string path  path to test with RegExp 
     * @return boolean  
     */
    public function validate($path): Bool
    {

        $image_extension = explode(".", $path);

        // does image contain one of the extensions 
        $extension = end($image_extension);

        if (!in_array($extension, $this->allowed_extensions)) {
            return false;
        } else {
            return true;
        }
    }
}
