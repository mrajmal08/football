

<template>
			
	<tr class="text-center">
	
		<td>{{player_data.position}}</td>
		<td><img src="/img/move.png"></td>
		<td><img :src="player_data.fantasy_player.teams.wikipedia_logo_url" style="border: 2px solid #fff;width: 50px;" fluid /></td>
		<td class="" style="padding: 0px !important;text-align: left;">
			<div class="pull-left" @click="showModal" v-if="player_data.position!='TQB'"><img :src="player_data.fantasy_player.player.photo_url" style="border: 2px solid #fff;width: 50px;" fluid /></div>
			<div class="pull-left" @click="showModal" v-if="player_data.position=='TQB'"><img :src="player_data.fantasy_player.teams.wikipedia_logo_url" style="border: 2px solid #fff;width: 50px;" fluid /></div>
			
			<div @click="showModal">{{player_data.fantasy_player.name}}</br>{{player_data.position}}  - {{player_data.fantasy_player.team}} <i class="fas fa-plus-square" v-if="scoreObject.injury_status"></i></div>
		</td>
		<td><span v-if="player_data.fantasy_player.bye_week==week"> BYE </span>
		<span v-else> {{scoreObject.opponent}}</span></td>
		<td class="nowrap"><player-individual-game-progress :player="player_data"></player-individual-game-progress></td>
		<td>{{player_genius}}</td>
		<td ><span >{{scoreObject.passing_yards}}</span></td>
		<td >{{scoreObject.passing_touchdowns}}</td>
		<td>{{scoreObject.passing_interceptions}}</td>
		<td>{{scoreObject.rushing_yards}}</td>
		<td>{{scoreObject.rushing_touchdowns}}</td>
		<td>{{scoreObject.receiving_yards}}</td>
		<td>{{scoreObject.receiving_touchdowns}}</td>
		<td>{{player_ret}}</td>
		<td>{{scoreObject.misc_fum_td}}</td>
		<td>{{player_misc_2pt}}</td>
		<td>{{scoreObject.fumbles_lost}}</td>
		<td>{{scoreObject.fantasy_points_acme}}</td>
		<player-detail-modal-component :player_id="player_data.fantasy_player.id" v-bind:is_def="player_data.is_def" v-bind:is_st="player_data.is_st" v-bind:team_qb="player_data.team_qb" v-bind:showModal="show_modal" v-on:update:showModal="show_modal = $event"/>
		 <!-- <div>
			<template>
					  <div>
						
						<b-modal ref="myModalRef" hide-footer title="Player Details" hide-footer centered size="lg">
						  <player-detail-modal-component :player_id="player_data.fantasy_player.player_id" v-bind:is_def="player_data.is_def" v-bind:is_st="player_data.is_st" v-bind:team_qb="player_data.team_qb" v-bind:showModal="show_modal" v-on:update:showModal="show_modal = $event"/>
						</b-modal>
					  </div>
			</template>
					
	 </div> -->
	
	</tr>
</template>

<script> 

export default {
	props:{
	 isProjection: { required: false  },
	  week: { type: Number },
      item: { type: Object, required: false },
	  isOffense: { type: Boolean, required: false, default: true },
    },
	data() {
      return {
	   player_data:this.item,
      	show_modal: false,
      	position: 'QB', move: '0', name: 'Aaron Rodgers',team: 'GB', opponent: '@SEA', status: 'Thu 7:30 pm', genius: '-', passing_yards: '-',passing_touchdowns: '-', passing_interceptions: '-', rushing_yards: '-', rushing_touchdowns: '-', receiving_yards: '-', receiving_touchdowns: '-', ret_td: '-', misc_fum_td: '-',
			 two_pt: '-', fumbles_lost: '-', fantasy_points_acme: '0.00', team_logo: 'https://cdn.head-fi.org/g/2283245_l.jpg'}
	},
	
	computed: {
	
	scoreObject: function() {
	
		if(this.isProjection){
			
			let player_game_fantasy_score=this.player_data.fantasy_player.fantasy_player_game_projection;	
			
				if(player_game_fantasy_score[0]){
					
					return player_game_fantasy_score[0]
					}	
		}
		else{
			
			  let player_game_fantasy_score=this.player_data.fantasy_player.player_game;
				
				if(player_game_fantasy_score[0]){
					
					return player_game_fantasy_score[0]
				}
		}	
		return '';
      },
	  
		player_genius: function(){
			return'';
		},
		
		
		
		player_ret: function(){
		
		let scoreObject2=''
			if(this.isProjection){
				
				let player_game_fantasy_score=this.player_data.fantasy_player.fantasy_player_game_projection;	
				
				if(player_game_fantasy_score[0]){
				
				scoreObject2= player_game_fantasy_score[0];
				
				 return parseInt(scoreObject2.punt_return_touchdowns)+parseInt(scoreObject2.kick_return_touchdowns);
				}
				
			}else{
				
				let player_game_fantasy_score=this.player_data.fantasy_player.player_game;
				
				if(player_game_fantasy_score[0]){
				
				scoreObject2= player_game_fantasy_score[0];
				
				 return parseInt(scoreObject2.punt_return_touchdowns)+parseInt(scoreObject2.kick_return_touchdowns);
				}
			}
		
				return 0;
			
		},
		
		
		player_misc_2pt: function(){
		
		let scoreObject=''
			if(this.isProjection){
				
				let player_game_fantasy_score=this.player_data.fantasy_player.fantasy_player_game_projection;	
				
				if(player_game_fantasy_score[0]){
				
				scoreObject= player_game_fantasy_score[0];
				
				 return parseInt(scoreObject.two_point_conversion_passes)+parseInt(scoreObject.two_point_conversion_runs)+
							parseInt(scoreObject.two_point_conversion_receptions);
				}
				
			}else{
				
				let player_game_fantasy_score=this.player_data.fantasy_player.player_game;
				
				if(player_game_fantasy_score[0]){
				
				scoreObject= player_game_fantasy_score[0];
				
				 return parseInt(scoreObject.two_point_conversion_passes)+parseInt(scoreObject.two_point_conversion_runs)+
										parseInt(scoreObject.two_point_conversion_receptions);
				}
			}
		
		
			return 0;
		
		},
		
		
		
	},
	methods: {
	
	onClose () {
		  
		  this.$refs.popover.$emit('close')
		},

  
	showModal () {	
		this.show_modal = true
    }
  }
}
</script>