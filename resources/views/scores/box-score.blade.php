@extends('spark::layouts.app')

@section('content')

<box-scores-component :game_key={{$game_key}} :week={{$week}} :season={{$season}} ></box-scores-component>


@endsection

