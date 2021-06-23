<?php

declare(strict_types=1);

namespace App\Service\Images;

use App\Service\Images\Types\TypeAPI;
use App\Service\Images\Types\TypeRSS;
use App\Service\Images\Types\ImageValidator;




/**
 * Class to switch and merge reurned images 
 */
class ImageAcumolator
{
    private $typeAPI;
    private $typeRSS;
    private $imageValidator;

    /**
     * @param   TypeAPI $typeAPI
     * @param   TypeRSS $typeRSS
     * @param ImageValidator $imageValidator
     */
    public function __construct(TypeAPI $typeAPI, TypeRSS $typeRSS, ImageValidator $imageValidator)
    {
        // initialize
        $this->typeAPI = $typeAPI;
        $this->typeRSS = $typeRSS;
        $this->imageValidator=$imageValidator;
    }

    /**
     * @param   array  $urls list of urls(api && rss) to fetch  
     * @return  array  unique array of merged image arrays =
     */
    public function handler(array $urlList): array
    {  // initialise empty array to contain returned images
        $imageList=array();

        foreach ($urlList as $currentURL => $currentType) {
            if ($currentType == "api") {
                $imageList = [...$imageList, ...$this->typeAPI->fetch($currentURL)];
            } elseif ($currentType == "rss") {
                $imageList = [...$imageList, ...$this->typeRSS->fetch($currentURL)];
            }else {
                continue;
            }
        }
      
        //take off duplicates 
        $imageList = array_unique($imageList);

         // filter Images Array 
        $imageList = array_filter($imageList, function ($item) {
            return $this->imageValidator->validate((string)$item);
        }, ARRAY_FILTER_USE_BOTH);

        return $imageList;
    }
}
