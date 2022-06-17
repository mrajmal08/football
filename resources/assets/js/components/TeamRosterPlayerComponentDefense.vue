<template>
	
	<tr class="text-center">
	
		<td>{{player_data.position}}</td>
		<td><img src="/img/move.png"></td>
		<td><img :src="player_data.fantasy_player.teams.wikipedia_logo_url" style="border: 2px solid #fff;width: 50px;" fluid /></td>
		<td class="" style="padding: 0px !important;text-align: left;">
			<div class="pull-left" @click="showModal"><img :src="player_data.fantasy_player.teams.wikipedia_logo_url" style="border: 2px solid #fff;width: 50px;" fluid /></div>
			<div @click="showModal">{{player_data.fantasy_player.name}}</br>{{player_data.fantasy_player.team}} <i class="fas fa-plus-square" v-if="scoreObject.injury_status"></i></div>
		</td>
		<td><span v-if="player_data.fantasy_player.bye_week==week">BYE </span>
		<span v-else> {{scoreObject.opponent}}</span></td>
		<td class="nowrap"><player-individual-game-progress :player="player_data"></player-individual-game-progress></td>
		<td>{{scoreObject.sacks}}</td>
		<td>{{scoreObject.turnover_int}}</td>
		<td>{{scoreObject.fumbles_recovered}}</td>
		<td>{{scoreObject.safeties}}</td>
		<td>{{scoreObject.defensive_touchdowns}}</td>
		<td>{{scoreObject.special_teams_touchdowns}}</td>
		<td>{{scoreObject.player_pts_allow}}</td>
		<td>{{scoreObject.fantasy_points_acme}}</td>
		<player-detail-modal-component :player_id="player_data.fantasy_player.id" v-bind:is_def="player_data.is_def" v-bind:is_st="player_data.is_st" v-bind:team_qb="player_data.team_qb" v-bind:showModal="show_modal" v-on:update:showModal="show_modal = $event"/>
	</tr>
</template>

<script> 

export default {
	props:{
	week: { type: Number },
	 isProjection: { required: false  },
      item: { type: Object, required: false },
	  isDefense: { type: Boolean, required: false, default: true },
    },
	
	computed: {
	scoreObject: function() {
	
	let fantasy_defense_game_fantasy_score=this.player_data.fantasy_player.fantasy_defense_game;
	  if(fantasy_defense_game_fantasy_score[0]){
	  	
        return fantasy_defense_game_fantasy_score[0]
		}
	  
	  
		return '';
      },
	  
	  
		
		
	},
	methods: {
	
	onClose () {
		  
		  this.$refs.popover.$emit('close')
		},
   
	showModal () {	
		this.show_modal = true
    }
  },
	data() {
      return {
      	show_modal: false,
		   player_data:this.item,
      	position: 'DEF', move: '0', name: 'Green Bay Packers',team: 'DEF', opponent: 'DEN', status: 'Sun 01:15 pm', sacks: '10', interceptions: '5',fumbles_recovered: '2', safeties: '-', defensive_touchdowns: '-', special_teams_touchdowns: '1', pts_allow: '74', fantasy_points: '30.00', team_logo: 'https://cdn.head-fi.org/g/2283245_l.jpg'}
	}
}
</script>