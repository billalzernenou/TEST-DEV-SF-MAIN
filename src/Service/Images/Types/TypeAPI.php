<?php

declare(strict_types=1);

namespace App\Service\Images\Types;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class for get images from api
 */
class TypeAPI
{
    private $client;

    /**
     * @param  HttpClientInterface $client
     * 
     */
    public function __construct(HttpClientInterface $client)
    {
        // initialize
        $this->client = $client;
    }


    /**
     * @param  string  $url to fetch 
     * @return array  array of paths to images 
     */
    public function fetch(string $url): array
    {
        try {
            //initialize 
            $imageList=[];

            // Query the API
            $response = $this->client->request('GET', $url);
            $content = json_decode($response->getContent());
            $articles = $content->articles;

            // extract urlToImage from articles
            foreach ($articles as $article) {
                $imageList[]=$article->urlToImage;
        }
        } catch (\Exception $e) {
            // we could show something according to response code. 500 internal server error , 
            //400 error query, 300 redirection
            trigger_error('Exception! '.$e->getMessage()); 
            
        }


        return $imageList;
    }
}
