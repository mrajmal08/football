@extends('spark::layouts.app')

@section('content')

<team-draft-card-component></team-draft-card-component>
<players-table-component resource="{{ route('players.list') }}"></players-table-component>
<team-card-table-component></team-card-table-component>
@endsection

