<spark-update-league-team-details :user="user" inline-template resource="{{ route('league.details') }}">
    <div class="card card-default" v-if="user">
        <div class="card-header">{{__('Scoring Review')}}</div>
		<div class="row">
		
		
			<scoringreview :fantasy_player="user.fantasy_player_all" :years="user.settings_years" :sys_season="user.sys_season" :sys_week="user.sys_week"  :sys_season_type="user.sys_season_type" :scoring_review="user.scoring_review" ></scoringreview>
	
	</div>	
        	
	</div>
</spark-update-league-team-details>
