<?php

namespace pizzallery\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use pizzallery\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function panel(){
        $user = Auth::user();

        return view('users.panel.control', compact('user'));
    }

    public function show(Request $request, $id){
      if(!$request->ajax()){
        return redirect()->back();
      }
      $user = User::find($id);
      $user->load('socialProvider');
      if($user->password){
        $user->hasPw = true;
      }else{
        $user->hasPw = false;
      }
      return $user;
    }
    public function all(Request $request){
      if($request->ajax()){
        $users = User::where('name','!=','')
        ->with('socialProvider')
        ->paginate(10);
        return $users;
      }else{
        return redirect()->back();
      }

    }

    public function createPassword(Request $request, User $user){
      if(!$request->ajax()){
        return redirect()->back();
      }
      $this->validate(request(),[
        'password'=>'required|string|alpha_num|max:100|min:5|confirmed'
      ]);
      $user->password = Hash::make($request->password);
      $user->save();
      return [
        'start'=>'Actualizado!',
        'message'=>'La operación se realizó con exito.',
        'status'=>true
      ];
    }
    public function updatePassword(Request $request, User $user){
      if(!$request->ajax()){
        return redirect()->back();
      }
      $this->validate(request(),[
        'old_password'=>'required|string|alpha_num|max:100|min:5',
        'password'=>'required|string|alpha_num|max:100|min:5|confirmed'
      ]);
      $pass = $request->old_password;
      if (Hash::check($pass, $user->password )) {
        $user->password = Hash::make($request->password);
        $user->save();
        return [
          'start'=>'Actualizado!',
          'message'=>'La operación se realizó con exito.',
          'status'=>true,
          'show'=>true,
        ];
      }else{
        return [
          'start'=>'Error! ',
          'message'=>' La contraseña actual no coincide.',
          'status'=> false,
          'show'=>true,
        ];
      }
    }

    public function editName(Request $request, User $user){
      if(!$request->ajax()){
        return redirect()->back();
      }
      $this->validate(request(),[
        'name'=>'required|string|max:100|min:8'
      ]);
      $user->name = $request->name;
      $user->save();
      return [
        'start'=>'Actualizado! ',
        'message'=>'La operación se realizó con exito',
        'status'=>true,
        'show'=>true,
      ];
    }

    public function update(Request $request, User $user){
      if(!$request->ajax()){
        return redirect()->back();
      }
      $this->validate(request(),[
        'phone'=>'required|numeric|phone',
        'age'=>'required|numeric'
      ]);
      $user->phone = $request->phone;
      $user->age = $request->age;
      $user->save();
      return [
        'start'=>'Actualizado! ',
        'message'=>'La operación se realizó con exito',
        'status'=>true,
        'show'=>true,
        'user'=>$user,
      ];
    }

    public function destroy(User $user){
      if(!$request->ajax()){
        return redirect()->back();
      }
      $usuario = User::find($user->id);
      $usuario->delete();
    }

}
