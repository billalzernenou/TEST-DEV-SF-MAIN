<?php

declare(strict_types=1);

namespace App\Service\Images;

use App\Service\Images\Types\TypeAPI;
use App\Service\Images\Types\TypeRSS;



/**
 * Class to switch and merge reurned images 
 */
class ImageAcumolator
{
    private $typeAPI;
    private $typeRSS;
    private $imageList;

    /**
     * @param   TypeAPI $typeAPI
     * @param   TypeRSS $typeRSS
     */
    public function __construct(TypeAPI $typeAPI, TypeRSS $typeRSS)
    {
        // initialize
        $this->typeAPI = $typeAPI;
        $this->typeRSS = $typeRSS;
        $this->imageList = [];
    }

    /**
     * @param   array  $urls list of urls(api && rss) to fetch  
     * @return  array  unique array of merged image arrays =
     */
    public function handler(array $urlList): array
    {

        foreach ($urlList as $currentURL => $currentType) {
            if ($currentType == "api") {
                $this->imageList = array_merge($this->imageList, $this->typeAPI->fetch($currentURL));
            } elseif ($currentType == "rss") {
                $this->imageList = array_merge($this->imageList, $this->typeRSS->fetch($currentURL));
            }
        }

        //take off duplicates 
        $this->imageList = array_unique($this->imageList);

        return $this->imageList;
    }
}
