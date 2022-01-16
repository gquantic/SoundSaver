<?php

namespace App\Http\Controllers;

use DiDom\Exceptions\InvalidSelectorException;
use DiDom\Query;
use http\Header\Parser;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ComposerController;
use DiDom\Document;
use App\Models\Music;

/**
 * Для написания использовался пакет DiDOM
 * https://github.com/Imangazaliev/DiDOM.git
 */

class ParserController extends Controller
{
    /**
     * Массив для хранения результатов
     * @var array
     */
    protected array $results = array();

    protected int $maxMusicForImport = 20;

    /**
     * URL сервиса
     */
    protected string $serviceUrl = 'https://soundcloud.com';

    /**
     * Установить лимит песен для парсинга
     *
     * @param $max
     * @return string
     */
    public function setMaxMusicsForImport($max): string
    {
        if ($max > 50) {
            return "Максимум 50 треков!";
        }

        return $this->maxMusicForImport = $max;
    }

    /**
     * Инициализация парсинга
     *
     * @param $url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws InvalidSelectorException
     */
    public function init($url, ComposerController $composerController, MusicController $musicController)
    {
        $content = $this->getContentFromPage($url, 'section > article', 'h2');

        foreach ($content as $item) {
            $music = explode('by', $item->children('h2.name a')[1]->text());
            $realName = $music[1];

            /**
             * Read composer name
             */
            $composer = substr($url, 23);
            $composer = substr($composer, 0, strpos($composer, '/'));

            /**
             * Read array
             */
            $music = [
                $music[0],
                $composer,
            ];

            $this->results[] = [
                'music' => $music,
                'duration' => $this->getMusicContinue($music),
                'comments' => $this->getMusicComments($music),
                'real_name' => $realName,
            ];
        }

        foreach ($this->results as $item) {
            $composerController->create($realName, $item['music'][1]);
            $musicController->create($item);
        }
    }

    /**
     * Вытаскиваем число комментариев под музыкой
     *
     * @param $music
     * @return string
     * @throws InvalidSelectorException
     */
    private function getMusicComments($music): string
    {
        /**
         * Массив для комментариев
         */
        $comments = [];

        /**
         * Получаем комментарии
         */
        $comments = $this->getContentFromPage($this->prepareUrlForParse($music), 'section.comments');

        if ($comments == null) {
            return "Not found";
        }

        return count($comments[0]->children('h2'));
    }

    /**
     * @param $music
     * @return string
     * @throws InvalidSelectorException
     */
    private function getMusicContinue($music): string
    {
        /**
         * Получаем и форматируем длительность трека
         * Вид: PT00H01M47S
         */
        if ($this->getContentFromPage($this->prepareUrlForParse($music), 'meta[itemprop="duration"]') == null) {
            return "Not found";
        }

        $duration = $this->getContentFromPage($this->prepareUrlForParse($music), 'meta[itemprop="duration"]')[0]->attr('content');
        return substr(str_replace(['M', 'S'],  [':', ''], $duration), 5);
    }

    /**
     * Подготовка ссылки для парсинга
     *
     * @param $music
     * @return string
     */
    protected function prepareUrlForParse($music): string
    {
        /**
         * Готовим запрос
         */
        $composer = strtolower(str_replace(' ', '', $music[1]));

        $music = strtolower(str_replace(' ', '-', $music[0]));
        $music = str_replace('(', '-', $music);
        $music = str_replace(')', '-', $music);
        $music = str_replace('--', '-', $music);
        $music = str_replace(['.', "'"], '', $music);
        $music = str_replace('--', '-', $music);

        $music = substr($music, 0, -1);

        if (str_ends_with($music, '-')) {
            $music = substr($music, 0, -1);
        }

        /**
         * Возвращаем итоговую ссылка вида https://soundcloud.com/ИСПОЛНИТЕЛЬ/МУЗЫКА
         */
        return "$this->serviceUrl/$composer/$music";
    }

    /**
     * Получаем элементы из страницы
     *
     * @param $url - Ссылка на страницу
     * @param $element - Сам элемент
     * @return array
     * @throws InvalidSelectorException
     */
    protected function getContentFromPage($url, $element): array
    {
        $document = new Document($url, true);
        return $document->find($element);
    }
}
