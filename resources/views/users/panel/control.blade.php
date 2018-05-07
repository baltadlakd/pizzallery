@extends('layouts.app')

@section('content')

    @isset($user->password)
        <bar
            v-bind:ren=`{!! route('editName',[Auth::User()->id]) !!}`
            v-bind:ru='{!! $user !!}'
            v-bind:rup=`{!! route('updatePassword', [ Auth::User()->id ] ) !!}`
            v-bind:cou='0'
            v-bind:all=`{!! route('userAll') !!}`
            v-bind:uind=`{!! route('userShow', [ Auth::User()->id] ) !!}`
            v-bind:upd=`{!! route('userUpdate', [ Auth::User()->id] ) !!}`
            v-bind:fb=`{{ route('redirect', ['provider'=>'facebook']) }}`
            v-bind:gh=`{{ route('redirect', ['provider'=>'github']) }}`
            v-bind:gp=`{{ route('redirect', ['provider'=>'google']) }}`
            v-bind:path=`{{ env('myPATH') }}`
            ></bar>
    @else
        <bar
            v-bind:ren=`{!! route('editName',[Auth::User()->id]) !!}`
            v-bind:ru='{!! $user !!}'
            v-bind:rcp=`{!! route('createPassword', [ Auth::user()->id] )!!}`
            v-bind:cou='1'
            v-bind:all=`{!! route('userAll') !!}`
            v-bind:uind=`{!! route('userShow', [ Auth::User()->id] ) !!}`
            v-bind:upd=`{!! route('userUpdate', [ Auth::User()->id] ) !!}`
            v-bind:fb=`{{ route('redirect', ['provider'=>'facebook']) }}`
            v-bind:gh=`{{ route('redirect', ['provider'=>'github']) }}`
            v-bind:gp=`{{ route('redirect', ['provider'=>'google']) }}`
            v-bind:path=`{{ env('myPATH') }}`
            ></bar>
    @endisset
    <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->
        @include('partials.errors')
@endsection
