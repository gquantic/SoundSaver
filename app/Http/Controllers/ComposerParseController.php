<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ParserController;
use DiDom\Document;

class ComposerParseController extends ParserController
{
    public function __construct()
    {

    }

    /**
     * Parse composers
     *
     * @throws \DiDom\Exceptions\InvalidSelectorException
     */
    public function initComposerSearch($composer)
    {
        return [
            $this->getContentFromPage("$this->serviceUrl/$composer", 'article p')[1]->text()
        ];
    }
}
