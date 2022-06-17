@extends('spark::layouts.app')

@section('content')
<b-container fluid>
  <b-row>    
	<team-roster-component :week={{$week}} :league_setting_week={{$league_setting_week}} season="{{$season}}"></team-roster-component>
  </b-row>	  
</b-container>

@endsection

