<template>
	<div class="container-fluid">
		<div class="col-sm-12">
			<b-dropdown id="ddown1" @click="changeItem" text="Select Week" class="m-md-2">

				<b-dropdown-item v-for="index in league_setting_week" @click="changeItem(index)" :key="index" :value="index" >
					{{ index }}
				</b-dropdown-item>
			</b-dropdown>
			<span> Week {{week}} </span>
		</div>
		<b-tabs id="player_tabs">
		<br/>
			  <b-alert show variant="warning" v-if="getkickerByeweekTeamPlayer" >The following players are on BYE this week: {{getkickerByeweekTeamPlayer}}</b-alert>
			  
			  
			<b-tab title="STATS" @click="selectTab(1)" active>
				
				<div class="text-right" style="padding:30px 0px;">
					<b-btn @click="" size="sm" variant="primary">SUBMIT</b-btn>
					<b-btn @click="" size="sm">CANCEL</b-btn>
				</div>
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Offense</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th rowspan="2">Genius</th>
							<th colspan="3">Passing</th>
							<th colspan="2">Rushing</th>
							<th colspan="2">Receiving</th>
							<th colspan="1">Ret</th>
							<th colspan="2">Misc</th>
							<th colspan="1">Fum</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>Yds</th>
							<th>TD</th>
							<th>Int</th>
							<th>Yds</th>
							<th>TD</th>
							<th>Yds</th>
							<th>TD</th>
							<th>TD</th>
							<th>FumTD</th>
							<th>2PT</th>
							<th>Lost</th>
						  </tr>
						</thead>
						<tbody>
							 <tr is="team-roster-player-offense-component" v-for="(item, index) in getoffenseTeam" :item="item" :isOffense="false" :week="week" :isProjection="false" v-bind:key="index"></tr>
						</tbody>
					</table>
				</div>
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Kicker</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th colspan="3">PAT</th>
							<th colspan="5">FG Made</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>Made</th>
							<th>Td</th>
							<th>Int</th>
							<th>0-19</th>
							<th>20-29</th>
							<th>30-39</th>
							<th>40-49</th>
							<th>50+</th>
						  </tr>
						</thead>
						<tbody>
							 <tr is="team-roster-player-kicker-component" v-for="(item,index) in getkickersTeam" :item="item" :isKicker="false" :week="week" :isProjection="false" v-bind:key="index"></tr>
						</tbody>
					</table>
				</div>
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Defense Team</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th colspan="1">Tackles</th>
							<th colspan="2">Turnover</th>
							<th colspan="2">Score</th>
							<th colspan="1">Ret</th>
							<th colspan="1">Points</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>Sack</th>
							<th>Int</th>
							<th>Fum Rec</th>
							<th>Saf</th>
							<th>TD</th>
							<th>TD</th>
							<th>Pts Allow</th>
						  </tr>
						</thead>
						<tbody>
							 <tr is="team-roster-player-defense-component" v-for="(item,index) in getdefenseTeam" :item="item" :isDefense="false" :week="week" :isProjection="false" v-bind:key="index"></tr>
						</tbody>
					</table>
				</div>
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Special Teams</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th colspan="2">Kick Offs</th>
							<th colspan="2">Punts</th>
							<th colspan="3">FG</th>
							<th colspan="2">TO</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>K Ret Yds</th>
							<th>K TB</th>
							<th>P Ret Yds</th>
							<th>P TB </th>
							<th>Blk FG</th>
							<th>Blk PAT</th>
							<th>Blk P</th>
							<th>Rec</th>
							<th>Lost</th>
							<th></th>
						  </tr>
						</thead>
						<tbody>
							 <tr is="team-roster-player-special-component" v-for="(item,index) in getspecialTeam" :item="item" :isSpecial="false" :week="week" :isProjection="false" v-bind:key="index"></tr>
						</tbody>
					</table>
				</div>
				
				<h6>Bench</h6>
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Offense</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th rowspan="2">Genius</th>
							<th colspan="3">Passing</th>
							<th colspan="2">Rushing</th>
							<th colspan="2">Receiving</th>
							<th colspan="1">Ret</th>
							<th colspan="2">Misc</th>
							<th colspan="1">Fum</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>Yds</th>
							<th>TD</th>
							<th>Int</th>
							<th>Yds</th>
							<th>TD</th>
							<th>Yds</th>
							<th>TD</th>
							<th>TD</th>
							<th>FumTD</th>
							<th>2PT</th>
							<th>Lost</th>
						  </tr>
						</thead>
						<tbody>
							 <tr is="team-roster-player-offense-component" v-for="(item,index) in getoffenseBenchTeam" :item="item" :isOffense="false" :week="week" :isProjection="false" v-bind:key="index"></tr>
						</tbody>
					</table>
				</div>
				
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Kicker</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th colspan="3">PAT</th>
							<th colspan="5">FG Made</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>Made</th>
							<th>Td</th>
							<th>Int</th>
							<th>0-19</th>
							<th>20-29</th>
							<th>30-39</th>
							<th>40-49</th>
							<th>50+</th>
						  </tr>
						</thead>
						<tbody>
							 <tr is="team-roster-player-kicker-component" v-for="(item,index) in getkickersBenchTeam" :item="item" :isKicker="false" :week="week" :isProjection="false" v-bind:key="index"></tr>
						</tbody>
					</table>
				</div>
				
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Defense Team</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th colspan="1">Tackles</th>
							<th colspan="2">Turnover</th>
							<th colspan="2">Score</th>
							<th colspan="1">Ret</th>
							<th colspan="1">Points</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>Sack</th>
							<th>Int</th>
							<th>Fum Rec</th>
							<th>Saf</th>
							<th>TD</th>
							<th>TD</th>
							<th>Pts Allow</th>
						  </tr>
						</thead>
						<tbody>
							 <tr is="team-roster-player-defense-component" v-for="(item, index) in getdefenseBenchTeam" :item="item" :isDefense="false" :week="week" :isProjection="false" v-bind:key="index"></tr>
						</tbody>
					</table>
				</div>
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Special Teams</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th colspan="2">Kick Offs</th>
							<th colspan="2">Punts</th>
							<th colspan="3">FG</th>
							<th colspan="2">TO</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>K Ret Yds</th>
							<th>K TB</th>
							<th>P Ret Yds</th>
							<th>P TB </th>
							<th>Blk FG</th>
							<th>Blk PAT</th>
							<th>Blk P</th>
							<th>Rec</th>
							<th>Lost</th>
							<th></th>
						  </tr>
						</thead>
						<tbody>
							 <tr is="team-roster-player-special-component" v-for="(item,index) in getspecialBenchTeam" :item="item" :isSpecial="false" :week="week" :isProjection="false" v-bind:key="index"></tr>
						</tbody>
					</table>
				</div>
				
				
			</b-tab>
			<b-tab title="PROJECTIONS" @click="selectTab(2)">
				<div class="text-right" style="padding:30px 0px;">
					<b-btn @click="" size="sm" variant="primary">SUBMIT</b-btn>
					<b-btn @click="" size="sm">CANCEL</b-btn>
				</div>
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Offense</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th rowspan="2">Genius</th>
							<th colspan="3">Passing</th>
							<th colspan="2">Rushing</th>
							<th colspan="2">Receiving</th>
							<th colspan="1">Ret</th>
							<th colspan="2">Misc</th>
							<th colspan="1">Fum</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>Yds</th>
							<th>TD</th>
							<th>Int</th>
							<th>Yds</th>
							<th>TD</th>
							<th>Yds</th>
							<th>TD</th>
							<th>TD</th>
							<th>FumTD</th>
							<th>2PT</th>
							<th>Lost</th>
						  </tr>
						</thead>
						<tbody >	
						
						<tr is="team-roster-player-offense-component" v-for="(item,index) in getoffenseTeam" :item="item" :isOffense="false" :week="week" :isProjection="true" v-bind:key="index"></tr>
						
						</tbody>
		
					</table>
				</div>
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Kicker</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th colspan="3">PAT</th>
							<th colspan="5">FG Made</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>Made</th>
							<th>Td</th>
							<th>Int</th>
							<th>0-19</th>
							<th>20-29</th>
							<th>30-39</th>
							<th>40-49</th>
							<th>50+</th>
						  </tr>
						</thead>
						<tbody>
							 <tr is="team-roster-player-kicker-component" v-for="(item,index) in getkickersTeam" :item="item" :isKicker="false" :week="week" :isProjection="true" v-bind:key="index"></tr>
						</tbody>
						
						
		
					</table>
				</div>
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Defense Team</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th colspan="1">Tackles</th>
							<th colspan="2">Turnover</th>
							<th colspan="2">Score</th>
							<th colspan="1">Ret</th>
							<th colspan="1">Points</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>Sack</th>
							<th>Int</th>
							<th>Fum Rec</th>
							<th>Saf</th>
							<th>TD</th>
							<th>TD</th>
							<th>Pts Allow</th>
						  </tr>
						</thead>
						<tbody >
							 <tr is="team-roster-player-defense-component" v-for="(item,index) in getdefenseTeam" :item="item" :isDefense="false" :week="week" :isProjection="true" v-bind:key="index"></tr>
						</tbody>
						
						
					</table>
				</div>
				
				<div class="sections table-responsive">
					<table class="table table-hover">
						<thead>
						  <tr>
							<th rowspan="2">POS</th>
							<th rowspan="2">Move</th>
							<th rowspan="2"></th>
							<th rowspan="2" width="30%">Special Teams</th>
							<th rowspan="2">Opp</th>
							<th rowspan="2" width="10%">Status</th>
							<th colspan="2">Kick Offs</th>
							<th colspan="2">Punts</th>
							<th colspan="3">FG</th>
							<th colspan="2">TO</th>
							<th rowspan="2">Fantasy Points</th>
						  </tr>
						  <tr class="subhead">
							<th>K Ret Yds</th>
							<th>K TB</th>
							<th>P Ret Yds</th>
							<th>P TB </th>
							<th>Blk FG</th>
							<th>Blk PAT</th>
							<th>Blk P</th>
							<th>Rec</th>
							<th>Lost</th>
							<th></th>
						  </tr>
						</thead>
						<tbody >
							 <tr is="team-roster-player-special-component" v-for="(item,index) in getspecialTeam" :item="item" :isSpecial="false" :week="week" :isProjection="true" v-bind:key="index"></tr>
						</tbody>
						
						
					</table>
				</div>
			</b-tab>
			<b-tab title="RANKS">
				
			</b-tab>
		</b-tabs>
	</div>
</template>

<script>
	import TeamRosterPlayerComponentOffense from "./TeamRosterPlayerComponentOffense.vue";
	import TeamRosterPlayerComponentKicker from "./TeamRosterPlayerComponentKicker.vue";
	import TeamRosterPlayerComponentDefense from "./TeamRosterPlayerComponentDefense.vue";
	import TeamRosterPlayerComponentSpecial from "./TeamRosterPlayerComponentSpecial.vue";
	
	export default {
	components: { TeamRosterPlayerComponentOffense,TeamRosterPlayerComponentKicker,TeamRosterPlayerComponentDefense,TeamRosterPlayerComponentSpecial },
	props:{
      week: { type: Number, required: true },
      season: { required: true },
     league_setting_week: { type: Number, required: true }
    },
	data () {
		return {
		
		  offenseTeam: [],
		  kickersTeam: [],
		  defenseTeam: [],
		  specialTeam: [],
		  bye_week_player:[],
		 
		}
	},
	computed: {
		getoffenseTeam(){
			return this.$store.getters.getoffenseTeamPlayer(1);			
		},
		getkickersTeam(){
			return this.$store.getters.getkickersTeamPlayer(1);	
			
		},
		getdefenseTeam(){
			return this.$store.getters.getdefenseTeamPlayer(1);	
			
		},
		getspecialTeam(){
			return this.$store.getters.getspecialTeamPlayer(1);
			//return this.$store.state.specialTeam;
		},
		getoffenseBenchTeam(){			
			return this.$store.getters.getoffenseTeamBenchPlayer(1);
		},
		getkickersBenchTeam(){
			return this.$store.getters.getkickersTeamBenchPlayer(1);
		},
		getdefenseBenchTeam(){
			return this.$store.getters.getdefenseTeamBenchPlayer(1);
		},
		getspecialBenchTeam(){
			return this.$store.getters.getspecialTeamBenchPlayer(1);
		},
		
		getkickerByeweekTeamPlayer(){
		
		var clonedPlayers = [];
		
		
		var kickerplayers = this.$store.getters.getkickerByeweekTeamPlayer(this.week);
		
			kickerplayers.forEach(players => {
					clonedPlayers.push(players.name)
			});
			
		var offenceplayers = this.$store.getters.getoffenceByeweekTeamPlayer(this.week);
		
			offenceplayers.forEach(players => {
					clonedPlayers.push(players.name)
			});	
			
			
		var deffenceplayers = this.$store.getters.getdeffenceByeweekTeamPlayer(this.week);
		
			deffenceplayers.forEach(players => {
					clonedPlayers.push(players.name)
			});	

		var specialplayers = this.$store.getters.getspecialByeweekTeamPlayer(this.week);
		
			specialplayers.forEach(players => {
					clonedPlayers.push(players.name)
			});			

			
			var namelist = clonedPlayers.join(', ');

		console.log(clonedPlayers);
		
		return namelist;
			//return this.$store.getters.getkickerByeweekTeamPlayer(6);			
		}
		
	},
	methods:{
		changeItem: function(week) {
			window.location.href = '/team/roster/week/'+week+'/season/REG';
		},
		selectTab(selectedTab) {
		
			if(selectedTab==1){
			
				this.$store.dispatch('loadFantasyTeamData2',{team_id:'', team_id2:'', week:this.week, season:this.season, projection:0});
			}
			
			else{
			
				this.$store.dispatch('loadFantasyTeamData2',{team_id:'', team_id2:'', week:this.week, season:this.season, projection:1});
			}
         }
	},
	created(){
		//this.$store.dispatch('loadFantasyTeamData2',{team_id:'', team_id2:'', week:this.week, season:this.season,  projection:0});
	}
	
}
</script>

