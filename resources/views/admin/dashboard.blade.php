@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel de Administración</h1>
    <p>Bienvenido, {{ auth()->user()->name }}</p>
</div>
@endsection
