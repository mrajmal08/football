@extends('spark::layouts.app')

@section('content')  
	<league-transactions-component :week={{$week}}  teams="{{$teams}}" transactions="{{$transactions}}"></league-transactions-component>  
@endsection

