<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class HtmlScraper
 *
 * @package AppBundle\Service
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class HtmlScraper
{
    private $userAgent = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.81 Safari/537.36';
    private $timeout = 5;

    public function getTitle($url)
    {
        try {
            $client = new Client();
            $response = $client->get($url, ['allow_redirects' => true, 'connect_timeout' => $this->timeout, 'timeout' => $this->timeout, 'headers' => ['User-Agent' => $this->userAgent]]);
            if ($response->getStatusCode() == 200) {
                $crawler = new Crawler($response->getBody()->getContents());
                $titleFilter = $crawler->filter('title');

                return array('title' => $titleFilter->count() != 0 ? $titleFilter->text() : null, 'url' => $response->getEffectiveUrl());
            }
        } catch (RequestException $e) {
            return null;
        }
    }
}