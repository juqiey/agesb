<?php

namespace App\Http\Controllers;

use App\Models\Ssa;
use App\Http\Requests\StoreSsaRequest;
use App\Http\Requests\UpdateSsaRequest;
use Symfony\Component\HttpFoundation\Request;

class SsaController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $ssrsQuery = Ssa::query();

        if ($request->has('vessel') && $request->vessel != '') {
            $ssrsQuery->where('vessel', $request->vessel);
        }

        $ssrs = $ssrsQuery->get();

        $vessels = [
            'VES001' => 'AISHAH AIMS 1'    ,
            'VES002' => 'AISHAH AIMS 2',
            'VES003' => 'AISHAH AIMS 3',
        ];

        $selectedVessel = $request->query('vessel', null);

        return view('ssa.request.index', compact('ssrs', 'vessels', 'selectedVessel'));
    } 

    public function verifyIndex(Request $request) {
        return view('ssa.verify.index');
    }   
    
    public function approveIndex(Request $request) {
        return view('ssa.approve.index');
    }

    public function reportIndex(Request $request) {
        return view('ssa.report.index');
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
    public function store(StoreSsaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ssa $ssa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ssa $ssa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSsaRequest $request, Ssa $ssa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ssa $ssa)
    {
        //
    }
}
