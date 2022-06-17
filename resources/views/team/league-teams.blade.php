@extends('spark::layouts.app')

@section('content')
<b-container fluid>
  <b-row>    
	<team-league-teams-component :week={{$week}}></team-league-teams-component>
  </b-row>	  
</b-container>

@endsection

