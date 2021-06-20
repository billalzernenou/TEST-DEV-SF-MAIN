<?php

declare(strict_types=1);

namespace App\Service\Images\Types;

use App\Service\Images\Types\ImageValidator;



/**
 * Class for get images from flux rss
 */
class TypeRSS
{
    private $imageList = array();
    private $imageValidator;

    /**
     * @param  ImageValidator $imageValidator
     * 
     */
    public function __construct(ImageValidator $imageValidator)
    {
        // initialize   
        $this->imageList = [];
        $this->imageValidator = $imageValidator;
    }


    /**
     * @param  string  $url to fetch 
     * @return array  array of paths to images 
     */
    public function fetch($url): array
    {
        //initialize 
        $imagesToFilter = [];

        try {
            $doc = simplexml_load_file($url);

            $items = $doc->xpath("//item/description");
            foreach ($items as $item) {
                $doc = new \DomDocument();
                $doc->loadHTML(html_entity_decode((string)$item));
                $img = $doc->getElementsByTagName('img')->item(0);
                array_push($imagesToFilter,  $img->getAttribute('src'));
            }
            // filter Images Array 
            $this->imageList = array_filter($imagesToFilter, function ($item) {
                return $this->imageValidator->validate($item);
            }, ARRAY_FILTER_USE_BOTH);
        } catch (\Exception $e) {
            // we could show something according to response code 
            echo ($e);
        }


        return $this->imageList;
    }
}
