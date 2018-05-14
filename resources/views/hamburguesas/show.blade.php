@extends('layouts.app')

@section('content')
    <div class="row">
        <hamburger-show
        v-bind:id-hamburger=`{{$id}}`
        v-bind:owner=`{{Auth::id()}}`
        ></hamburger-show>
    </div>
    <div class="row">
        <comment
        v-bind:id=`{{$id}}`
        v-bind:type=`hamburger`></comment>
    </div>

@endsection
