<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Http\Requests\StoreMusicRequest;
use App\Http\Requests\UpdateMusicRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ComposerController;
use App\Http\Controllers\ParserController;

class MusicController extends Controller
{
    public function __construct()
    {
        $this->composerController = new ComposerController;
        $this->parserController = new ParserController;
    }

    public function index()
    {
        return view('music.index');
    }

    public function show()
    {
        $musics = Music::all();
        return view('music.index', compact('musics'));
    }

    public function create($content)
    {
        $composer = $this->composerController->search($content['real_name']);
        if (!Music::where('composer', $composer)->where('name', $content['music'][0])->exists()) {
            DB::table('music')->insert([
                'composer' => $composer,
                'name' => $content['music'][0],
                'duration' => $content['duration'],
                'comments' => $content['comments'],
            ]);
        }
    }
}
