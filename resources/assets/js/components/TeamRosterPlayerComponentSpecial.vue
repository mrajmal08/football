<template>
	<tr class="text-center">
	
		<td>{{player_data.position}}</td>
		<td><img src="/img/move.png"></td>
		<td><img :src="player_data.fantasy_player.teams.wikipedia_logo_url" style="border: 2px solid #fff;width: 50px;" fluid /></td>
		<td class="" style="padding: 0px !important;text-align: left;">
			<div class="pull-left" @click="showModal"><img :src="player_data.fantasy_player.teams.wikipedia_logo_url" style="border: 2px solid #fff;width: 50px;" fluid /></div>
			
			<div @click="showModal"> {{player_data.fantasy_player.name}}</br>{{player_data.fantasy_player.team}}  <i class="fas fa-plus-square" v-if="scoreObject.injury_status"></i></div>
		</td>
		<td><span v-if="player_data.fantasy_player.bye_week==week">BYE </span>
		<span v-else> {{scoreObject.opponent}}</span></td>
		
		<td class="nowrap"><player-individual-game-progress :player="player_data"></player-individual-game-progress></td>
		<td>{{scoreObject.kick_return_yards}}</td>
		<td>{{scoreObject.kick_return_fair_catches}}</td>
		<td>{{scoreObject.punt_return_yards}}</td>
		<td>{{scoreObject.punt_touchbacks}}</td>
		<td></td>
		<td></td>
		<td></td>
		<td>{{scoreObject.fumbles_recovered}}</td>
		<td>{{scoreObject.fumbles_lost}}</td>
		
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
	  isSpecial: { type: Boolean, required: false, default: true },
    },
	
	computed: {
	
	scoreObject: function() {
	
	if(this.isProjection){
	
		let fantasy_defense_game_fantasy_score=this.player_data.fantasy_player.fantasy_defense_game_projection;
	
		if(fantasy_defense_game_fantasy_score[0]){
	  	
        return fantasy_defense_game_fantasy_score[0]
		}
		
	  }else{
	  	  
		let fantasy_defense_game_fantasy_score=this.player_data.fantasy_player.fantasy_defense_game;
	
		if(fantasy_defense_game_fantasy_score[0]){
	  	
        return fantasy_defense_game_fantasy_score[0]
	  
		}  
	  
	
      }
	  
	  	return '';
		
		}
		
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
      	position: 'K', move: '0', name: 'David Akers',team: 'SF', opponent: '@PHI', status: 'Sun 10:00 am', pat_made: '7', kick_return_yards: '1',kick_return_fair_catches: '3', punt_return_yards: '1', punt_touchbacks: '-', blk_fg: '2',blk_pat:'-',blk_p:'-',fumbles_recovered:'-', fumbles_lost:'-',fantasy_points: '0.00', team_logo: 'https://cdn.head-fi.org/g/2283245_l.jpg'}
	}
}
</script>