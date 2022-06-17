@extends('spark::layouts.app')

@section('content')

<live-game-scoreboard-component :week={{$week}}  :league_setting_week={{$league_setting_week}}  season_type="{{$season_type}}"  :season={{$season}} game={{$game}}></live-game-scoreboard-component>

@endsection

