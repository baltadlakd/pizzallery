@extends('layouts.app')

@section('content')
    <user-table ruta={!! route('userAll') !!}> </user-table>
@endsection
