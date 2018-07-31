<?php

namespace App\Http\Controllers;

use App\Models\Dapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DappController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $dapp_list = Dapp::where('user_id', $user_id)
                        ->orderBy('id', 'desc')
                        ->paginate(15);
        return view('dapp.index', ['dapp_list' => $dapp_list]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dapp  $dapp
     * @return \Illuminate\Http\Response
     */
    public function show(Dapp $dapp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dapp  $dapp
     * @return \Illuminate\Http\Response
     */
    public function edit(Dapp $dapp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dapp  $dapp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dapp $dapp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dapp  $dapp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dapp $dapp)
    {
        //
    }
}
