<?php

namespace pizzallery\Http\Controllers;

use pizzallery\Tarjeta;
use pizzallery\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TarjetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Auth::check()){
          $cc = Tarjeta::where('user_id',Auth::id())->get();
          foreach($cc as $card){
            $card->fecha = $card->date;            
          }
          return $cc;
      }
      return [
        'start'=>'Error!',
        'message'=>'not logged in.',
        'status'=>true,
        'show'=>true,
      ];
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
        $user = User::find($request->user['id']);
        $user->tarjetas()->create([
          'name'=>$request->name,
          'month'=>$request->month,
          'year'=>$request->year,
          'ccv'=>$request->ccv,
          'address'=>$request->address,
          'number'=>$request->number,
        ]);
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \pizzallery\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function show(Tarjeta $tarjeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \pizzallery\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarjeta $tarjeta)
    {
        $cc = Tarjeta::find($tarjeta->id);
        return $cc;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \pizzallery\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarjeta $tarjeta)
    {
      $cc = Tarjeta::find($tarjeta->id);
      $cc->update([
        'name'=>$request->name,
        'address'=>$request->address,
        'number'=>$request->number,
        'month'=>$request->month,
        'year'=>$request->year,
        'ccv'=>$request->ccv,
      ]);
        return [
          'start'=>'Actualizado!',
          'message'=>'La operación se realizó con exito.',
          'status'=>true,
          'show'=>true,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \pizzallery\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarjeta $tarjeta)
    {
        $cc = Tarjeta::find($tarjeta->id);
        $cc->delete();
        return [
            'start'=>'Eliminada!',
            'message'=>'Tu tarjeta se ha eliminado con exito.',
            'status'=>true,
            'show'=>true,
          ];
    }
}
