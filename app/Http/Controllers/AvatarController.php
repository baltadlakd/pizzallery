<?php

namespace pizzallery\Http\Controllers;

use Illuminate\Http\Request;
use pizzallery\Avatar;
use pizzallery\User;
use Auth;

class AvatarController extends Controller
{
  public function all(Request $request)
  {
    $avatars = Avatar::paginate(5);
    return $avatars;
  }
  public function index(Request $request)
  {
    return view('users.panel.avatar');
  }
  public function store(Request $request)
  {
    $this->validate(request(),[
      'image'=>'required|file|image'
    ]);
    $avatar = $request->file('image');
    $_original  = $avatar->getClientOriginalName();
    $_tamano    = $avatar->getClientSize();
    $_mime      = $avatar->getMimeType();
    if($request->hasFile('image')){
      $_hashed  = $request->image->store('avatars');
      Avatar::create([
        'original'=> $_original,
        'hashed'=>$_hashed,
        'mime'=>$_mime,
        'size'=>$_tamano,
        'path'=>'avatars'
      ]);
      alert()->info('Actualizado','Archivo subido correctamente!');
    }else{
      alert()->error('ups!','Archivo no encontrado!');
    }
    return redirect()->route('avatars.index');
  }
  public function update(Request $request){
    $user = User::find($request->userid);
    $ang = Avatar::find($request->avatarid);
    $user->avatar = $ang->hashed;
    $user->save();
    return $user;
  }
  public function show(Request $request,$id){
    $ang = Avatar::find($id);
    return $ang->hashed;
  }
  public function destroy(Request $request,$id){
    $avatar = Avatar::find($id);
    if (\Storage::exists($avatar->hashed)) {
      \Storage::delete($avatar->hashed);
      $avatar->delete();
    } else {
      return redirect()->back()->with([
        'message' => 'NO SE ENCONTRÓ ARCHIVO',
      ]);
    }
  }
}
