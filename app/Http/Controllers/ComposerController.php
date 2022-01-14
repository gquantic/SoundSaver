<?php

namespace App\Http\Controllers;

use App\Models\Composer;
use App\Http\Requests\StoreComposerRequest;
use App\Http\Requests\UpdateComposerRequest;

class ComposerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreComposerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComposerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Composer  $composer
     * @return \Illuminate\Http\Response
     */
    public function show(Composer $composer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Composer  $composer
     * @return \Illuminate\Http\Response
     */
    public function edit(Composer $composer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComposerRequest  $request
     * @param  \App\Models\Composer  $composer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComposerRequest $request, Composer $composer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Composer  $composer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Composer $composer)
    {
        //
    }
}
