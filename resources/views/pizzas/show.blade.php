@extends('layouts.app')

@section('content')

<div class="row">
    <pizza-show
        v-bind:id-pizza=`{{$id}}`
        v-bind:owner=`{{Auth::id()}}`
    ></pizza-show>
</div>
<div class="row">
    <comment
        v-bind:id=`{{$id}}`
        v-bind:type=`pizza`></comment>
</div>

@endsection
