<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="{{ mix(Spark::usesRightToLeftTheme() ? 'css/app-rtl.css' : 'css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @yield('scripts', '')

    <!-- Global Spark Object -->
    <script>
        window.Spark = <?php echo json_encode(array_merge(
            Spark::scriptVariables(), []
        )); ?>;
		
    </script>
</head>
<body>
    <div id="spark-app" v-cloak>
        <!-- Navigation -->
		
        @if (Auth::check())
		  @if (Route::getCurrentRoute()->getActionMethod()=='final_show')
			@include('spark::nav.subscribed')
		  @else
            @include('spark::nav.user')		
		  @endif
        @else
            @include('spark::nav.guest')
        @endif

        <!-- Main Content -->
        <main class="pt-2 bg-light">
		 @include('spark::flash-message')

            @yield('content')
        </main>

        <!-- Application Level Modals -->
        @if (Auth::check())
            @include('spark::modals.notifications')
            @include('spark::modals.support')
            @include('spark::modals.session-expired')
        @endif
    </div>
<?php 
$current_route=Route::currentRouteName();
?>
    <!-- JavaScript -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="/js/sweetalert.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data-2012-2022.min.js"></script>

    <script src="/js/leader-line.min.js"></script>
	<script>
		var timezone = moment.tz.guess();
		$('#timezone').val(timezone);
		<?php if($current_route=='standings/tournament'){?>
		var startElement_1	= document.getElementById('start_1');
		var startElement_2 	= document.getElementById('start_2');
		var startElement_3 	= document.getElementById('start_3');
		var startElement_4 	= document.getElementById('start_4');
		var startElement_5 	= document.getElementById('start_5');
		var startElement_6 	= document.getElementById('start_6');
		var startElement_7 	= document.getElementById('start_7');
		var startElement_8 	= document.getElementById('start_8');
		var endElement_1	= document.getElementById('north_home_team');
		var endElement_2	= document.getElementById('south_home_team');
		var championship_final_1	= document.getElementById('championship_final_1');
		var championship_final_2	= document.getElementById('championship_final_2');
		var east_conference_1		= document.getElementById('east_conference_1');
		var west_conference_1		= document.getElementById('west_conference_1');
		new LeaderLine(startElement_1, endElement_1, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(startElement_2, endElement_1, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(startElement_3, endElement_2, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(startElement_4, endElement_2, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(endElement_1, championship_final_1, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(endElement_2, championship_final_1, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(startElement_5, east_conference_1, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(startElement_6, east_conference_1, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(startElement_7, west_conference_1, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(startElement_8, west_conference_1, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(east_conference_1, championship_final_2, {color: 'red', size: 3,path:'straight'});
		new LeaderLine(west_conference_1, championship_final_2, {color: 'red', size: 3,path:'straight'});
		<?php }?>
		
	</script>
</body>
</html>
