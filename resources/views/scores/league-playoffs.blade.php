@extends('spark::layouts.app')

@section('content')

<b-container fluid  style="width: auto;max-width:2500px;overflow-x: scroll; overflow-y: hidden;">
  <b-row>    
	<scores-league-playoffs-component :week={{$week}}></scores-league-playoffs-component>
  </b-row>	  
</b-container>

@endsection
