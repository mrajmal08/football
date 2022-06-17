<!-- {{--@push('styles')--}}
    {{--<style>--}}
    {{--html {--}}
    {{--height: 100%;--}}
    {{--}--}}

    {{--body {--}}
    {{--min-height: 100vh;--}}
    {{--}--}}

    {{--/* fixed and fluid only on sm and up */--}}
    {{--@media (min-width: 576px) {--}}
    {{--.fixed {--}}
    {{--flex: 0 0 200px;--}}
    {{--min-height: 100vh;--}}
    {{--}--}}
    {{--.col .fluid {--}}
    {{--min-height: 100vh;--}}
    {{--}--}}
    {{--}--}}

    {{--.flex-grow {--}}
    {{--flex:1;--}}
    {{--}--}}
    {{--</style>--}}
{{--@endpush--}} -->

<!-- @extends('spark::layouts.app') -->

@section('content')

		<draft-room-component  :week="{{$week}}" draft-date="{{$draft_date}}" :commissioner="{{json_encode($isCommissioner)}}" :teams="{{$leagueDetails->teams}}"
		:deafault-page=true :league="{{$leagueDetails}}" :user-id={{$userId}}></draft-room-component>

@endsection