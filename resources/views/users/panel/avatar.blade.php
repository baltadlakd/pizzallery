@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="container">
            <form class="form-group" action="{{ route('avatars.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="image" class="form-control"/>
                <br />
                <input type="submit" value="Subir" class="form-control"/>
            </form>
        </div>

    </div>

    <avatars
        v-bind:user=`{{Auth::id()}}`
        v-bind:is-admin=`{{Auth::user()->hasAnyRole('admin')}}`
        ></avatars>

@endsection
