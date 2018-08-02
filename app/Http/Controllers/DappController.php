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
        return view('dapp.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'app_name' => 'bail|required|unique:dapp',
            'status' => 'required',
            'icon_file' => 'required',
            'callback_url' => 'required',
            'withdraw_addr' => 'required',
        ]);
        $user_id = Auth::id();
        $icon_path = $request->file('icon_file')->store('dapp_icon');

        $dapp = new Dapp;
        $dapp->user_id = $user_id;
        $dapp->app_name = $request->app_name;
        $dapp->description = $request->description;
        $dapp->icon = $icon_path;
        $dapp->secret_key = md5($request->app_name.time().rand());
        $dapp->callback_url = $request->callback_url;
        $dapp->withdraw_addr = $request->withdraw_addr;
        $dapp->status = $request->status;
        $dapp->save();
        return redirect()->route('dapp_index')->with('msg', __('common.save_success'));
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
