<?php

namespace pizzallery\Http\Controllers;

use pizzallery\Tag;
use pizzallery\Pizza;
use pizzallery\Hamburger;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$type,$id)
    {
      if(!$request->ajax()){
        return view('index');
      }
      if($type == "pizza"){
        $link = Pizza::find($id);
      }else if($type == "hamburguesa"){
        $link = Hamburger::find($id);
      }else{
        return ['Error'=>'Invalid type!'];
      }

      return $link->ingredientes;
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
    public function store(Request $request,$type,$id)
    {

        if(!$request->ajax()){
          return view('index');
        }
        if($type == "pizza"){
          $link = Pizza::find($id);
        }else if($type == "hamburguesa"){
          $link = Hamburger::find($id);
        }else{
          return ['Error'=>'Invalid type!'];
        }
        $index = 0;
        $link->ingredientes()->detach();

        while(isset($request[$index])){
          $ing = new Tag(['ingrediente'=>$request[$index]]);
          $link->ingredientes()->save($ing);
          $index++;
        }
        return ['status'=>true];
    }

    /**
     * Display the specified resource.
     *
     * @param  \pizzallery\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \pizzallery\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \pizzallery\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \pizzallery\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
