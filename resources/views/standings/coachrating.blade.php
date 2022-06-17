@extends('spark::layouts.app')

@section('content')
<b-container fluid>
  <b-row>    
	<standings-coach-ratings-component :week={{$week}} :system_week={{$system_week}} season="{{$season}}" ></standings-coach-ratings-component>
  </b-row>	  
</b-container>

@endsection

