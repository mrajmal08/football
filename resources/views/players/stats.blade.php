@extends('spark::layouts.app')

@section('content')
<players-table-component :user-id={{$userId}} :league="{{$league}}" :is-commissioner={{json_encode($is_commissioner)}} :draft-complete={{json_encode($draft_complete)}} :waiver-period-enabled={{json_encode($waiver_period_enabled)}} ></players-table-component>
<?php /*TODO: show_draft_user={{$show_draft_user}} had to be removed because prop is not passing correctly */ ?>
@endsection
