@extends('spark::layouts.app')

@section('content')
<b-container fluid>
  <b-row>    
	<standings-overall-component :week={{$week}} season="{{$season}}"></standings-overall-component>
  </b-row>	  
</b-container>

@endsection

