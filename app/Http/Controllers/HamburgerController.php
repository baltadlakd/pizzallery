<?php

namespace pizzallery\Http\Controllers;

use pizzallery\Hamburger;
use Illuminate\Http\Request;

class HamburgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if(!$request->ajax()){
        return view('hamburguesas.index');
      }
      $hamburgers = Hamburger::with('user')
        ->paginate(8);
      return $hamburgers;
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
     * @param  \pizzallery\Hamburger  $hamburger
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
      if($request->ajax()){
        $hamburger = Hamburger::find($id);
        $hamburger->load('user');
        return $hamburger;
      }else{
        return view('hamburguesas.show',['id'=>$request->hamburger]);
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \pizzallery\Hamburger  $hamburger
     * @return \Illuminate\Http\Response
     */
    public function edit(Hamburger $hamburger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \pizzallery\Hamburger  $hamburger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hamburger $hamburger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \pizzallery\Hamburger  $hamburger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hamburger $hamburger)
    {
        //
    }
}
