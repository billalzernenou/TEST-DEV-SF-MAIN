<?php

declare(strict_types=1);

namespace App\Service\Images\Types;



/**
 * Class for get images from flux rss
 */
class TypeRSS
{
    /**
     * 
     */
    public function __construct()
    {

    }

    /**
     * @param  string  $url to fetch 
     * @return array  array of paths to images 
     */
    public function fetch($url): array
    {
        //initialize 
        $imageList = [];

        try {
            $doc = simplexml_load_file($url);

            $items = $doc->xpath("//item/description");
            foreach ($items as $item) {
                $doc = new \DomDocument();
                $doc->loadHTML(html_entity_decode((string)$item));
                $img = $doc->getElementsByTagName('img')->item(0);
                $imageList[] =$img->getAttribute('src');
            }
           
        } catch (\Exception $e) {
             // we could show something according to response code. 500 internal server error , 
            //400 error query, 300 redirection
            trigger_error('Exception! '.$e->getMessage()); 
        }


        return $imageList;
    }
}
