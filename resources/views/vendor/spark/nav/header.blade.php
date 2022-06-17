<?php
$week=1;
$settings			= 	Helper::getSystemSettingsDetails();
$week				=	$settings['week'];
?>

<ul class="navbar-nav mr-auto">
	 <li class="nav-item dropdown">
		<!-- League -->
		<a href="#" class="d-block d-md-flex text-center nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
		   aria-haspopup="true" aria-expanded="false">
			League
		</a>

		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<!-- League -->
			<a class="dropdown-item" href="/league/home">
				{{__('Home')}}
			</a>

			<div class="dropdown-divider"></div>

			<!-- Schedule -->
			<a class="dropdown-item" href="/league/schedule">
				{{__('Schedule')}}
			</a>
			
			<div class="dropdown-divider"></div>

			<!-- Transactions -->
			<a class="dropdown-item" href="/league/transactions">
				{{__('Transactions')}}
			</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<!-- Draft -->
		<a href="#" class="d-block d-md-flex text-center nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
		   aria-haspopup="true" aria-expanded="false">
			Draft
		</a>
		
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<!-- Draft Room -->
			<a class="dropdown-item" href="/draft/draft-room">
				{{__('Draft Room')}}
			</a>

			<div class="dropdown-divider"></div>

			<!-- Draft Preparation -->
{{-- 			<a class="dropdown-item" href="/draft/draft-prep">
				{{__('Draft Preparation')}}
			</a> --}}
			
			<div class="dropdown-divider"></div>

			<!-- Draft Results -->
			<a class="dropdown-item" href="/draft/draft-results">
				{{__('Draft Results')}}
			</a>
			
			<div v-if="user.is_commissioner == true" class="dropdown-divider"></div>
			
			<!-- Draft Settings -->
			<a v-if="user.is_commissioner == true" class="dropdown-item" href="/settings#/league">
				{{__('Draft Settings')}}
			</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<!-- Team -->
		<a href="#" class="d-block d-md-flex text-center nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
		   aria-haspopup="true" aria-expanded="false">
			Team
		</a>

		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<!-- Roster -->
			<a class="dropdown-item" href="/team/roster">
				{{__('Roster')}}
			</a>

			<div class="dropdown-divider"></div>

			<!-- Roster Grid -->
			<a class="dropdown-item" href="/team/league-teams">
				{{__('Roster Grid')}}
			</a>
			
			<div class="dropdown-divider"></div>

			 <!-- Change Team Name & Logo --> 
			<a class="dropdown-item" href="/settings#/profile">
				{{__('Change Team Name & Logo')}}
			</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<!-- Players -->
		<a href="#" class="d-block d-md-flex text-center nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
		   aria-haspopup="true" aria-expanded="false">
			Players
		</a>

		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<!-- Stats -->
			<a class="dropdown-item" href="/players/stats">
				{{__('Stats')}}
			</a>

			<div class="dropdown-divider"></div>

			<!-- Injury Report -->
			<a class="dropdown-item" href="/players/injury-report">
				{{__('Injury Report')}}
			</a>
			
			<div class="dropdown-divider"></div>

			<!-- Depth Chart -->
			<a class="dropdown-item" href="/players/depth-charts">
				{{__('Depth Chart')}}
			</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<!-- Scores -->
		<a href="#" class="d-block d-md-flex text-center nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
		   aria-haspopup="true" aria-expanded="false">
			Scores
		</a>

		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<!-- Fantasy Games -->
			<a class="dropdown-item" href="/scores/fantasy-games">
				{{__('Fantasy Games')}}
			</a>

			<div class="dropdown-divider"></div>

			<!-- Fantasy Playoffs -->
			<a class="dropdown-item" href="/scores/league-playoffs/<?php echo $week;?>">
				{{__('Fantasy Playoffs')}}
			</a>
			
			<div class="dropdown-divider"></div>

			<!-- NFL Games -->
			<a class="dropdown-item" href="/scores/nfl-games">
				{{__('NFL Games')}}
			</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<!-- Standings -->
		<a href="#" class="d-block d-md-flex text-center nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
		   aria-haspopup="true" aria-expanded="false">
			Standings
		</a>

		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
			<!-- Fantasy Games -->
			<a class="dropdown-item" href="/standings/head-to-head">
				{{__('Head to Head')}}
			</a>

			<div class="dropdown-divider"></div>

			<!-- Overall -->
			<a class="dropdown-item" href="/standings/overall">
				{{__('Overall')}}
			</a>
			
			<div class="dropdown-divider"></div>

			<!-- Tournament -->
			<a class="dropdown-item" href="/standings/tournament">
				{{__('Tournament ')}}
			</a>
			
			<div class="dropdown-divider"></div>
			
			<!-- Coach Rating -->
			<a class="dropdown-item" href="/standings/coach-ratings">
				{{__('Coach Rating')}}
			</a>
		</div>
	</li>
</ul>
