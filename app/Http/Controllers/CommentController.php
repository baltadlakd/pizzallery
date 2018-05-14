<?php

namespace pizzallery\Http\Controllers;

use pizzallery\Comment;
use Illuminate\Http\Request;
use pizzallery\Pizza;
use pizzallery\Hamburger;
use pizzallery\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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

    return $link->comments->load('user');
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
    $comment = new Comment([
      'message' => $request['comment'],
    ]);
    if($type == "pizza"){
      $link = Pizza::find($id);
    }else if($type == "hamburguesa"){
      $link = Hamburger::find($id);
    }else{
      return ['Error'=>'Invalid type!'];
    }
    $this->validate(request(),[
      'comment'=>'required|string|max:200|min:5'
    ]);

    $link->comments()->save($comment);
    return [
      'si'=>'awebo'
    ];
  }

  /**
  * Display the specified resource.
  *
  * @param  \pizzallery\Comment  $comment
  * @return \Illuminate\Http\Response
  */
  public function show(Comment $comment)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \pizzallery\Comment  $comment
  * @return \Illuminate\Http\Response
  */
  public function edit(Comment $comment)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \pizzallery\Comment  $comment
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Comment $comment)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \pizzallery\Comment  $comment
  * @return \Illuminate\Http\Response
  */
  public function destroy(Comment $comment)
  {
    //
  }
}
