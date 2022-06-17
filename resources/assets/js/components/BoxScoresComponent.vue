<template>
	<b-container fluid>
		<loading :active.sync="visible" :can-cancel="true"></loading>
		<div class="row" v-for="team in fantacy_teams">
			<jumbo-game-score-component :team_data="team"/>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<key-players-component :game_key="game_key" :week="week" :season="season"/>
				<div class="row">
					<game-details-component :game_key="game_key"/>
				</div>
			</div>
			<div class="col-sm-6" v-for="team in fantacy_teams">
				<box-score-brief-component :team_data="team" :week="week" :season="season"/>
				<div class="row">
					<team-player-stats-component :game_key="game_key"/>
					<!-- <div class="col-sm-6">
						<team-player-stats-component/>
					</div> -->
				</div>
			</div>
			<div class="col-sm-3">
				<social-feed-component/>
			</div>
		</div>
		
		<scores-ticker-component :game_key="game_key" :week="week" :season="season"/>
	</b-container fluid>
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
		components: {
			Loading
		},
		props:{
			game_key: { type: Number, required: true},
			week: { type: Number, required: true},
			season: { type: Number, required: true},
		},
		data() {
			return {
				visible: false,
				selected_season:2018,
				selected_week:1,
				fantacy_teams:[]
			}
		},  
		created() {
			this.getPlayerTeam();
		},
		methods: {
			getPlayerTeam(){
				this.visible = true;
				axios.get('/nfl-game-score',{params: {week:this.week,season:this.season,game_key:this.game_key}})
				.then((response)=>{
					this.fantacy_teams = response.data;
					var self = this;						
					self.visible = false;
				})
				.catch(error => {});
			}
		},
		mounted() {
			console.log('Component mounted.')
		}
	}
</script>
