<?php

namespace App\Http\Controllers;

use http\Header\Parser;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ComposerController;

class ParserController extends Controller
{
    private array $results = array();

    protected int $maxMusicForImport = 20;
    protected string $serviceUrl = 'https://soundcloud.com/';

    public function setMaxMusicsForImport($max): string
    {
        if ($max > 50) {
            return "Максимум 50 треков!";
        }

        return $this->maxMusicForImport = $max;
    }

    /**
     * Get the music and composer information
     * @param $url
     * @return void
     */
    public function init($url)
    {
        $content = $this->getContentFromPage($url, 'section > article', 'h2');

        foreach ($content as $item) {
            $musics[] = explode('by', $item['result']);
        }

        /**
         * For the next, we keep the items and parse other info
         */
        foreach ($musics as $item) {
            /**
             * Get the music duration
             */
            if ($item[0] != null && $item[1] != null) {
                $this->results[] = [
                    $item,
                    $this->getMusicContinue($item)
                ];
            }
        }

        dd($this->results);
    }

    /**
     * @param $music
     * @return array
     */
    private function getMusicContinue($music)
    {
        $composer = strtolower(str_replace(' ', '', $music[1]));

        $music = strtolower(str_replace(' ', '-', $music[0]));
        $music = str_replace('(', '-', $music);
        $music = str_replace(')', '-', $music);
        $music = str_replace('--', '-', $music);
        $music = str_replace('.', '', $music);
        $music = substr($music, 0, -1);

        $url = $this->serviceUrl.$composer."/".$music;

        $this->getContentFromPage($url, 'span.sc-visuallyhidden', null, false);
    }

    /**
     * Parse elements from url of page
     *
     * @param $url
     * @return array
     */
    private function getContentFromPage($url, $selector = 'section > article', $thirdElement = null, $array = true)
    {
        /**
         * Get html remote text
         */
        $html = file_get_contents($url);

        /**
         * Create new instance for parser
         */
        $crawler = new Crawler(null, $url);
        $crawler->addHtmlContent($html, 'UTF-8');

        if ($array == true) {
            $crawler->filter($selector)->each(function ($item) use ($thirdElement) {
                if ($thirdElement != null) {
                    $this->results[] = [
                        'result' => $item->filter($thirdElement)->text(),
                    ];
                } else {
                    $this->results[] = [
                        'result' => $item->text(),
                    ];
                }
            });
        } else {
            dd($crawler->filter($selector));
        }

        echo "<pre>";
        var_dump($this->results);
        echo "</pre>";

        return $this->results;
    }
}
