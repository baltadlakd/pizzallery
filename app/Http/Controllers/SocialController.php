<?php

namespace pizzallery\Http\Controllers;

use Illuminate\Http\Request;

use Socialite;

use pizzallery\User;
use pizzallery\SocialProvider;
use pizzallery\Role;
use Auth;
use Alert;

class SocialController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider){
        try{
            $userinfo = Socialite::driver($provider)->user();
        }catch(\Exception $e){
            return view('home');
        }
        $social = SocialProvider::where('provider_id', $userinfo->getId())->first();

        if(Auth::check()){//esta logueado
          if(!$social){//no se habia logueado con esta opcion y se crea
            $correo = $userinfo->getEmail();
            if(!$correo){
              alert()->error('Oops...', 'No pudimos obtener el correo de tu cuenta!');
              return redirect()->route('userPanel');
            }
            Auth::User()->socialProvider()->create([
              'provider_id'=>$userinfo->getId(),
              'provider'=>$provider
            ]);
            alert()->info('Actualizado','Has conectado tu cuenta');
            return redirect()->route('userPanel');
          }else{
            alert()->error('Oops...', 'Esta cuenta ya esta vinculada a otro usuario!');
            return redirect()->route('userPanel');
          }
        }
        else{//no esta logueado
          if(!$social){
              $correo = $userinfo->getEmail();
              if(!$correo){
                  return redirect()->route('login')->with([
                      'email'=>'No se pudo obtener el correo de la cuenta.'
                  ]);
              }
              $user = User::firstOrCreate(
                  ['email'=> $userinfo->getEmail()],
                  ['name'=> $userinfo->getName()]
              );
              $user->socialProvider()->create([
                  'provider_id'=>$userinfo->getId(),
                  'provider'=>$provider
              ]);
              $user->roles()
                    ->attach(Role::where('name', 'user')->first());
          }
          else{
              $user = $social->user;
          }
          auth()->login($user);
          return view('home');
        }
    }

    public function destroy($id){
      $social = SocialProvider::find($id);
      $social->delete();
      return [
          'start'=>'Actualizado!',
          'message'=>'Has desconectado tu cuenta.',
          'status'=>true,
          'show'=>true,
        ];
    }
}
