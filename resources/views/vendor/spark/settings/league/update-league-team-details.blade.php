
<spark-update-league-team-details :user="user" inline-template resource="{{ route('league.details') }}">
    <div class="card card-default" v-if="user">
        <div class="card-header">{{__('League Teams')}}</div>
		<div class="row">
			<div class="col-6" style="padding: 25px;float:left"  v-for="value in user.league_teams">
				<div class="card league-team" >
					<div class="card-body">
					<div class="row"><div class="col-sm-4"></div> 
					<div class="col-sm-8">
					<h3>@{{ value.name }} Roster</h3>
					</div></div>
					<br/>
					<!-- TODO: Turn this back on? :fantasy_transaction="user.team_grouped[value.id]" -->
 						<fantasy-team-quickmanage :fantasy_player="user.fantasy_player" :team_id="value.id"  ></fantasy-team-quickmanage>
					</div>
				</div>	 
			 </div>	
			 
	
	</div>	
        
	</div>
</spark-update-league-team-details>
