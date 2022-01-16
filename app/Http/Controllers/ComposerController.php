<?php

namespace App\Http\Controllers;

use App\Models\Composer;
use App\Models\Music;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use App\Http\Controllers\ComposerParseController;

class ComposerController extends Controller
{
    public function __construct()
    {
        $this->composerParse = new ComposerParseController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function show($id)
    {
        $compositor = Composer::where('id', $id)->first();
        $musics = Music::where('composer', $id)->get();

        return view('compositor.show', compact('compositor', 'musics'));
    }

    public function search($name)
    {
        $composer = Composer::where('name', $name)->first();
        return $composer->id;
    }

    /**
     * Create a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($composer)
    {
        if (!Composer::where('name', $composer)->exists()) {
            DB::table('composers')->insert([
                'name' => $composer,
                'city' => $this->composerParse->initComposerSearch($composer)[0],
            ]);
        }
    }
}
