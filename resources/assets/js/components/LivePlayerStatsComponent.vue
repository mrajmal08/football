<template>	<div>
<div class="sections">
					<table class="table table-hover">
						<thead>
						
						  <tr v-if="player_position == 'TQB'">							
							<th colspan="3"><span >Passing</span></th>
							<th colspan="2">Rushing</th>
							<th colspan="1">Fum</th>
							
						  </tr>
						  
						    <tr v-else-if="player_position == 'DEF'">							
							<th colspan="3"><span >Plays</span></th>
							<th colspan="2">Scores</th>
							<th colspan="2">Allwd</th>
							
						  </tr>
						  
						   <tr v-else-if="player_position == 'K'">							
							<th colspan="2"><span >PAT</span></th>
							<th colspan="3">FG Made</th>														
						  </tr>
						  
						  
						   <tr v-else-if="player_position == 'ST'">							
							<th colspan="2"><span >Kick Offs</span></th>
							<th colspan="2">Punts</th>
							<th colspan="2">TO</th>
							
						  </tr>
						  
						  
						  <tr v-else>							
							<th colspan="3">Receving</th>
							<th colspan="2">Rushing</th>
							<th colspan="1">Fum</th>
							
						  </tr>
						  
						  
						  
						  <tr class="subhead" v-if="player_position == 'TQB'">
							<th>Yds</th>
							<th>TD</th>
							<th>Int</th>
							<th>Yds</th>	
							<th>TD</th>
							<th>Lost</th>
						  </tr>
						  
						   <tr class="subhead" v-else-if="player_position == 'DEF'">
							<th>Sck</th>
							<th>Fum</th>
							<th>Int</th>
							<th>FumTd</th>	
							<th>IntTd</th>
							<th>Pts</th>
							<th>TotYrd</th>
						  </tr>
						  
						  <tr class="subhead" v-else-if="player_position == 'K'">
							<th>Made</th>
							<th>Att</th>
							<th>0-29</th>
							<th>30-50</th>	
							<th>51+</th>
							
						  </tr>
						  <tr class="subhead" v-else-if="player_position == 'ST'">
							<th>K RetYrd</th>
							<th>K TB</th>
							<th>P Ret Yrd</th>
							<th>P TB</th>	
							<th>Rec</th>
							<th>Lost</th>
						  </tr>
						  
						  
						  <tr class="subhead" v-else>
							<th>Yds</th>
							<th>TD</th>
							<th>Rec</th>
							<th>Yds</th>	
							<th>TD</th>
							<th>Lost</th>
						  </tr>
						  
						  
						  
						</thead>
						
						<tbody>
							<tr v-if="player_position == 'DEF'">
							<td> <span v-if="statsObject">{{statsObject.sacks}}</span></td>
							<td><span v-if="statsObject">{{statsObject.opponent_fumbles_lost}}</span></td>
							<td><span v-if="statsObject">{{statsObject.opponent_passing_interceptions}}</span></td>
							<td><span v-if="statsObject">{{statsObject.fumble_return_touchdowns}}</span></td>	
							<td><span v-if="statsObject">{{statsObject.interception_return_touchdowns}}</span></td>
							<td><span v-if="statsObject">{{statsObject.opponent_score}}</span></td>
							<td><span v-if="statsObject">{{statsObject.opponent_offensive_yards}}</span></td>
						  </tr>
						  
						  
						  <tr v-else-if="player_position == 'K'">
							<td> <span v-if="statsObject">{{statsObject.extra_points_made}}</span></td>
							<td><span v-if="statsObject">{{statsObject.extra_points_attempted}}</span></td>
							<td><span v-if="statsObject">{{statsObject.field_goals_made0to19 + statsObject.field_goals_made20to29}}</span></td>
							<td><span v-if="statsObject">{{statsObject.field_goals_made30to39 + statsObject.field_goals_made40to49}}</span></td>	
							<td><span v-if="statsObject">{{statsObject.field_goals_made50_plus}}</span></td>
							
						  </tr>
						  
						  
						   <tr v-else-if="player_position == 'ST'">
							<td> <span v-if="statsObject">{{statsObject.opponent_return_yards}}</span></td>
							<td><span v-if="statsObject">{{statsObject.kickoff_touchbacks}}</span></td>
							<td><span v-if="statsObject">{{statsObject.opponent_punt_yards}}</span></td>
							<td><span v-if="statsObject"></span></td>	
							<td><span v-if="statsObject"></span></td>
							<td><span v-if="statsObject"></span></td>
						  </tr>
						  
						  
						  
						  <tr v-else>
							<td> <span v-if="statsObject">{{statsObject.receiving_yards}}</span></td>
							<td><span v-if="statsObject">{{statsObject.receiving_touchdowns}}</span></td>
							<td><span v-if="statsObject">{{statsObject.receptions}}</span></td>
							<td><span v-if="statsObject">{{statsObject.rushing_yards}}</span></td>	
							<td><span v-if="statsObject">{{statsObject.rushing_touchdowns}}</span></td>
							<td><span v-if="statsObject">{{statsObject.fumbles_lost}}</span></td>
						  </tr>
						  
						</tbody>
					</table></div>
	</div>
</template>

<style>
.player-table {
    border-bottom: 1px solid #e2e4e6;
   
}
.table{
	font-size: 14px;
}


.subhead th{
	background: aliceblue !important;
}

.sections{
	
}
.fa-plus-square{color:red}

</style>

<script> 

export default {
	props:{
      player: { type: Object, required: true },
	   player_position:{type: String, required: false},
    },
	computed: {
		  statsObject: function() {
		  if(this.player.fantasy_player.player_game[0])
			return this.player.fantasy_player.player_game[0]
			return null;
		  
		  if(this.player.fantasy_player.team_game[0])
			return this.player.fantasy_player.team_game[0]
		  
		  }
	  }
	
	
}
</script>