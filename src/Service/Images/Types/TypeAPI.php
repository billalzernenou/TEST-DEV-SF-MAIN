<?php

declare(strict_types=1);

namespace App\Service\Images\Types;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\Images\Types\ImageValidator;

/**
 * Class for get images from api
 */
class TypeAPI
{
    private $imageValidator;
    private $imageList = array();
    private $client;

    /**
     * @param  HttpClientInterface $client
     * @param  ImageValidator $imageValidator
     * 
     */
    public function __construct(HttpClientInterface $client, ImageValidator $imageValidator)
    {
        // initialize
        $this->client = $client;
        $this->imageList = [];
        $this->imageValidator = $imageValidator;
    }


    /**
     * @param  string  $url to fetch 
     * @return array  array of paths to images 
     */
    public function fetch(string $url): array
    {
        try {
            //initialize 
            $imagesToFilter = [];

            // Query the API
            $response = $this->client->request('GET', $url);
            $content = json_decode($response->getContent());
            $articles = $content->articles;

            // extract urlToImage from articles
            foreach ($articles as $article) {
                array_push($imagesToFilter, $article->urlToImage);
            }
            // filter Images Array 
            $this->imageList = array_filter($imagesToFilter, function ($item) {
                return $this->imageValidator->validate((string)$item);
            }, ARRAY_FILTER_USE_BOTH);
        } catch (\Exception $e) {
            // we could show something according to response code 
            echo ($e);
        }


        return $this->imageList;
    }
}
