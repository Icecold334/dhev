<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Http\Requests\StoreBahanRequest;
use App\Http\Requests\UpdateBahanRequest;

class BahanController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bahan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBahanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bahan $bahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bahan $bahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBahanRequest $request, Bahan $bahan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bahan $bahan)
    {
        //
    }
}
