<template>
	<tr class="text-center">
		<td>{{player_data.position}}</td>
		<td><img src="/img/move.png"></td>
		<td><img :src="player_data.fantasy_player.teams.wikipedia_logo_url" style="border: 2px solid #fff;width: 50px;" fluid /></td>
		<td class="" style="padding: 0px !important;text-align: left;">
			
			<div class="pull-left" @click="showModal"><img :src="player_data.fantasy_player.player.photo_url" style="border: 2px solid #fff;width: 50px;" fluid /></div>
			
			<div @click="showModal">{{player_data.fantasy_player.name}}</br>{{player_data.fantasy_player.team}} <i class="fas fa-plus-square" v-if="scoreObject.injury_status"></i></div>
		</td>
		<td><span v-if="player_data.fantasy_player.bye_week==week">BYE </b-alert></span>
		<span v-else> {{scoreObject.opponent}}</span></td>
		<td class="nowrap"><player-individual-game-progress :player="player_data"></player-individual-game-progress></td>
		<td>{{scoreObject.extra_points_made}}</td>
		<td>{{scoreObject.passing_touchdowns}}</td>
		<td>{{scoreObject.passing_interceptions}}</td>
		<td>{{scoreObject.field_goals_made0to19}}</td>
		<td>{{scoreObject.field_goals_made20to29}}</td>
		<td>{{scoreObject.field_goals_made30to39}}</td>
		<td>{{scoreObject.field_goals_made40to49}}</td>
		<td>{{scoreObject.field_goals_made50_plus}}</td>
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
	  isKicker: { type: Boolean, required: false, default: true },
    },
	
	computed: {
		scoreObject: function() {
		
			let team_game_fantasy_score=this.player_data.fantasy_player.team_game;
			
			let player_game_fantasy_score=this.player_data.fantasy_player.player_game;
			
			if(player_game_fantasy_score[0]){
				
				return player_game_fantasy_score[0]
				}
			  if(team_game_fantasy_score[0]){
				
				return team_game_fantasy_score[0]
				}
			  
			  
				return '';
			  },
	  
	},methods: {
	
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
      	position: 'K', move: '0', name: 'David Akers',team: 'SF', opponent: '@PHI', status: 'Sun 10:00 am', pat_made: '7',

		extra_points_made: '7',
		passing_touchdowns: '7',
		passing_interceptions: '7',
	  fg1: '1',fg2: '3', fg3: '1', fg4: '-', fg5: '2', fantasy_points: '0.00', team_logo: 'https://cdn.head-fi.org/g/2283245_l.jpg'}
	}
}
</script>