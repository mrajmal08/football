<template>
	<div class="card-carousel--card--footer">
		<a class="" :href="'/scores/nfl-games/box-scores/' + team.game_key +'/' + week+'/'+season"  target="_blank">
			<div class="team-section">
				<p><i v-if="isAwayWin" class="fas fa-caret-right"></i></p>
				<img :src="team.away_team.team_data.wikipedia_logo_url != null ? team.away_team.team_data.wikipedia_logo_url : 'https://cdn.head-fi.org/g/2283245_l.jpg'" alt="">
				<p>{{team.away_team.team_data.away_team}}</p>
				<p>{{team.away_team.score_data.away_score}}</p>
			</div>
			<div class="team-section">
				<p><i v-if="isHomeWin" class="fas fa-caret-right"></i></p>
				<img :src="team.home_team.team_data.wikipedia_logo_url != null ? team.home_team.team_data.wikipedia_logo_url : 'https://cdn.head-fi.org/g/2283245_l.jpg'" alt="">
				<p>{{team.home_team.team_data.home_team}}</p>
				<p>{{team.home_team.score_data.home_score}}</p>
			</div>
			<div class="team-section final-score">
				<p>{{team.home_away_team_score.score_data.quarter_description}}
				<span v-if="team.home_away_team_score.score_data.time_remaining !='null'">{{team.home_away_team_score.score_data.time_remaining}}</span></p>
			</div>
		</a>
	</div>
</template>

<script>
	export default {
		props:{
			team: { type: Object, required: true},
			week: { type: Number, required: true},
			season: { type: Number, required: true},
		},
		data () {
			return {
				isAwayWin: false,
				isHomeWin: false
			}
		},
		mounted() {
			if(this.team.away_team.score_data.away_score > this.team.home_team.score_data.home_score)
				this.isAwayWin = true;
			else
				this.isHomeWin = true;
		}
	}
</script>
