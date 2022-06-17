<template>
	<b-container fluid class="container-fluid">
		<loading :active.sync="visible" :can-cancel="true"></loading>
		<b-row>
			<b-col cols="2">
				<div><b-button variant="outline-primary">Pre Wk4</b-button></div>
			</b-col>
			<b-col cols="2" >
				<div><b-button variant="outline-primary" v-on:click="getWeek(1)">Week 1</b-button></div>
			</b-col>
			<b-col cols="2" >
				<div><b-button variant="outline-primary" v-on:click="getWeek(2)">Week 2</b-button></div>
			</b-col>
			<b-col cols="2">
				<div>
					<b-form-select  v-model="selected_week" v-on:change="getSelectedWeek">	
						<option v-for="index in 17"  :key="index" :value="index"  >	{{ index }}</option>
					</b-form-select>
				</div>
			</b-col>
			<b-col cols="2">
				<b-form-select   v-model="selected_season" v-on:change="getSelectedSeason" >
					<option value='2020'>2020 Season</option>
				</b-form-select>
			</b-col>
			<b-col cols="2">
				<b-form-select v-model="selected_season_type" v-on:change="getSelectedSeasonType" >
					<option value='1'>REG</option>
					<option value='2'>PRE</option>
					<option value='3'>POST</option>
				</b-form-select>
			</b-col>
		</b-row>
		<br/><br/>
		<b-row>
			<div class="col-md-4" v-for="team in fantacy_teams">
				<nflindividual-game-score-component :team_data="team" :week="selected_week"	 :season='selected_season'/>
			</div>
		</b-row>
	</b-container>
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
	data() {
      return {
			visible: false,
			selected_season:2020,
			selected_week:2,
			selected_season_type:1,
			fantacy_teams:[]
		}
    },  
	created() {
        this.getPlayerTeam(this.selected_week,this.selected_season,this.selected_season_type);
	},
	methods: {
		getWeek: function(week) { 
			let season=this.selected_season;
			let season_type=this.selected_season_type;
			this.selected_week=week;
			this.getPlayerTeam(week,season,season_type);
		},
		getSelectedWeek: function(week) { 
			let season=this.selected_season;
			let season_type=this.selected_season_type;
			this.selected_week=week;
			this.getPlayerTeam(week,season,season_type);
		},
		getSelectedSeason: function(season) { 
			let week=this.selected_week;
			let season_type=this.selected_season_type;
			this.selected_season=season;
			this.getPlayerTeam(week,season,season_type);
		},
		getSelectedSeasonType: function(season_type) { 
			let week=this.selected_week;
			let season=this.selected_season;
			this.selected_season_type=season_type;
			this.getPlayerTeam(week,season,season_type);
		},
		getPlayerTeam(week,season,season_type){
			this.visible = true;
			axios.get('/nfl-game-score',{params: {week:week,season:season,season_type:season_type}})
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
