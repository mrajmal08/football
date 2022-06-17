@extends('spark::layouts.app')

@section('content')

    
	<fantasyteam-roster-component :week={{$week}} :league_setting_week={{$league_setting_week}} season="{{$year}}" season_type="{{$season}}" team_id={{$team_id}}></fantasyteam-roster-component>
  


@endsection

