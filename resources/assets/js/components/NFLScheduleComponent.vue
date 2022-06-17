<template>
	<b-container fluid>
		<div class="color-container space-right">
			<div class="color-head d-flex d-align-center">
				<div class="txt-uppercase font-16 font-bold color-width color-data-head txt-center">VISITOR</div>
				<div class="txt-uppercase font-16 font-bold color-width color-data-head txt-center">HOME</div>
			</div>
			<div class="color-content-container">
				<div class="color-content d-flex d-align-center" v-for="(teams, tindex) in nflTeams" >

					<div @click="showPopup(teams.away_team.key)" :style="{ 'background-color': '#'+teams.away_team.primary_color+'','color': '#'+teams.away_team.secondary_color+'' }" class="color-width font-13 color-data txt-center">
							{{teams.away_team.full_name}}
					</div>
					<div @click="showPopup(teams.home_team.key)" :style="{ 'background-color': '#'+teams.home_team.primary_color+'','color': '#'+teams.home_team.secondary_color+'' }" class="color-width font-13 color-data txt-center ">
							{{teams.home_team.full_name}}
					</div>

				</div>
			</div>
			<b-modal size="lg" ref="myModalRef" hide-footer title="Players" >
				<team-players-table-component :team_pop="teamName"></team-players-table-component>
			</b-modal>
		</div>
	</b-container>
</template>
<style>

</style>

<script>
export default {
  props: {
    week: { type: Number, required: false}
  },
	data () {
		return {
		  nflTeams: [],
		  teamName:'',
		  showPlayerModal: false
		}
	},
	created(){
        this.getNFLTeams();
	},
	methods: {
		getNFLTeams() {

            axios.get('/nfl-schedules?week='+this.week)
			.then((response)=>{
				this.nflTeams 	= response.data.nflTeams;
			})
			.catch(error => {});
        },
		showPopup(team) {
			this.teamName	= team;
			this.showPlayerModal = true;
			this.$refs.myModalRef.show()
		},
	}
}
</script>
