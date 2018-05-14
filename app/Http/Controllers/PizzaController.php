<?php

namespace pizzallery\Http\Controllers;

use pizzallery\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if(!$request->ajax()){
        return view('pizzas.index');
      }
      $pizzas = Pizza::with('user')
        ->paginate(8);
      return $pizzas;
    }

    /**
     * Display the specified resource.
     *
     * @param  \pizzallery\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
      if($request->ajax()){
        $pizza = Pizza::find($id);
        $pizza->load('user');
        return $pizza;
      }else{
        return view('pizzas.show',['id'=>$request->pizza]);
      }
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
     * Show the form for editing the specified resource.
     *
     * @param  \pizzallery\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function edit(Pizza $pizza)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \pizzallery\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pizza $pizza)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \pizzallery\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pizza $pizza)
    {
        //
    }
}
