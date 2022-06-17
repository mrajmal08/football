

<template>

	<tr class="text-center player-row" @click="showModal">

		<td>{{player_data.position}}</td>

		<td class="td-left"><b>{{player_data.fantasy_player.name}}</b> {{player_data.position}} | {{player_data.fantasy_player.team.full_name}}
		<font-awesome-icon  v-if="player_data.fantasy_player.player.injury_status !=null" :icon="['fas', 'plus-circle']" :style="{ color: 'red' }" />
		<font-awesome-icon v-if="player_data.fantasy_player.player.status =='Suspended'" :icon="['fab', 'stripe-s']":style="{ color: 'red' }" />
		<font-awesome-icon v-if="player_data.fantasy_player.fantasy_player_news && player_data.fantasy_player.fantasy_player_news.length > 0" :icon="['fas', 'sticky-note']":style="{ color: '#FDB026' }" />
		</td>
    <td>
      {{player_data.fantasy_player.bye_week}}
    </td>
    <td>
      {{player_data.fantasy_player.team.upcoming_opponent}}
    </td>
		<template v-for="property in fantasyPlayerStatsToShow">
		  <td>{{ fantasyPlayerGameStats[property] }}</td>
		</template>
		<player-detail-modal-component :player_id="player_data.fantasy_player.id"  v-bind:showModal="show_modal" v-on:update:showModal="show_modal = $event"/>
	</tr>
</template>

<script>

export default {
	props:{
	 	isProjection: { required: false  },
  	week: { type: Number },
    item: { type: Object, required: false },
  	isDefense: { type: Boolean },
   	isSt: { type: Boolean },
  },
	data() {
    return {
	   player_data:this.item,
     show_modal: false,
   	}
	},
	filters:{
		changeFormat:function(value){
			return Number.parseFloat(value).toFixed(2);
		}
	},
	computed: {
		fantasyPlayerStatsToShow: function() {
			if(this.isDefense)
				return ['points_allowed','interceptions','sacks','safeties','tackles_for_loss','fumbles_forced','fumbles_recovered','touchdowns_scored','offensive_yards_allowed',null,null,null,null,null,null,'fantasy_points_acme']
			if(this.isSt)
				return [null,null,null,null,null,null,null,null,null,'punt_return_yards','kick_return_yards','punt_return_touchdowns','kick_return_touchdowns','punt_return_yards_per_attempt','kick_return_yards_per_attempt','fantasy_points_acme']
		},
		fantasyPlayerGameStats: function() {
			// if(this.isProjection)
			// 	return this.player_data.fantasy_player.player_game_projection[0]

			if(this.isDefense){
				if(this.player_data.fantasy_player.fantasy_defense_game[0])
					return this.player_data.fantasy_player.fantasy_defense_game[0]
			}

			if(this.isSt){
				if(this.player_data.fantasy_player.player_game[0])
					return this.player_data.fantasy_player.player_game[0]
			}

			return []
		},

	// scoreObject: function() {

	// if(this.isDefense){
	// 			let fantasy_defense_game_fantasy_score=this.player_data.fantasy_player.fantasy_defense_game_projection;
	// 		     if(fantasy_defense_game_fantasy_score[0]){
	// 				return fantasy_defense_game_fantasy_score[0]
	// 			}

	// 		}
	// 		  let player_game_fantasy_score=this.player_data.fantasy_player.fantasy_player_game_projection;

	// 			if(player_game_fantasy_score[0]){

	// 				return player_game_fantasy_score[0]
	// 			}




	// else{

	// 	if(this.isProjection){

	// 	if(this.isDefense){
	// 			let fantasy_defense_game_fantasy_score=this.player_data.fantasy_player.fantasy_defense_season;
	// 		     if(fantasy_defense_game_fantasy_score[0]){
	// 				return fantasy_defense_game_fantasy_score[0]
	// 			}

	// 		}
	// 		  let player_game_fantasy_score=this.player_data.fantasy_player.player_game;

	// 			if(player_game_fantasy_score[0]){

	// 				return player_game_fantasy_score[0]
	// 			}

	// 	}

	// }
	// 		return '';
	// },



		// player_ret: function(){

		// let scoreObject2=''
		// 	if(this.isProjection){

		// 		let player_game_fantasy_score=this.player_data.fantasy_player.fantasy_player_game_projection;

		// 		if(player_game_fantasy_score[0]){

		// 		scoreObject2= player_game_fantasy_score[0];

		// 		 return parseInt(scoreObject2.punt_return_touchdowns)+parseInt(scoreObject2.kick_return_touchdowns);
		// 		}

		// 	}else{

		// 		let player_game_fantasy_score=this.player_data.fantasy_player.player_game;

		// 		if(player_game_fantasy_score[0]){

		// 		scoreObject2= player_game_fantasy_score[0];

		// 		 return parseInt(scoreObject2.punt_return_touchdowns)+parseInt(scoreObject2.kick_return_touchdowns);
		// 		}
		// 	}

		// 		return 0;

		// },


		// player_misc_2pt: function(){

		// let scoreObject=''
		// 	if(this.isProjection){

		// 		let player_game_fantasy_score=this.player_data.fantasy_player.fantasy_player_game_projection;

		// 		if(player_game_fantasy_score[0]){

		// 		scoreObject= player_game_fantasy_score[0];

		// 		 return parseInt(scoreObject.two_point_conversion_passes)+parseInt(scoreObject.two_point_conversion_runs)+
		// 					parseInt(scoreObject.two_point_conversion_receptions);
		// 		}

		// 	}else{

		// 		let player_game_fantasy_score=this.player_data.fantasy_player.player_game;

		// 		if(player_game_fantasy_score[0]){

		// 		scoreObject= player_game_fantasy_score[0];

		// 		 return parseInt(scoreObject.two_point_conversion_passes)+parseInt(scoreObject.two_point_conversion_runs)+
		// 								parseInt(scoreObject.two_point_conversion_receptions);
		// 		}
		// 	}


		// 	return 0;

		// },



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
