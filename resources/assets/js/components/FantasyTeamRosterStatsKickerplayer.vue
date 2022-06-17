

<template>
  <tr
    class="text-center player-row"
    @click="showModal"
  >
    <td>{{ player_data.position }}</td>

    <td class="td-left">
      <b>{{ player_data.fantasy_player.name }}</b> {{ player_data.position }} | {{ player_data.fantasy_player.team.full_name }}
      <font-awesome-icon
        v-if="player_data.fantasy_player.player.injury_status !=null"
        :icon="['fas', 'plus-circle']"
        :style="{ color: 'red' }"
      />
      <font-awesome-icon
        v-if="player_data.fantasy_player.player.status =='Suspended'"
        :icon="['fab', 'stripe-s']"
        :style="{ color: 'red' }"
      />
      <font-awesome-icon
        v-if="player_data.fantasy_player.fantasy_player_news && player_data.fantasy_player.fantasy_player_news.length > 0"
        :icon="['fas', 'sticky-note']"
        :style="{ color: '#FDB026' }"
      />
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
    <player-detail-modal-component
      :player_id="player_data.fantasy_player.id"
      :showModal="show_modal"
      @update:showModal="show_modal = $event"
    />
  </tr>
</template>

<script>

export default {
	filters:{
		changeFormat:function(value){
			return Number.parseFloat(value).toFixed(2);
		}
	},
	props:{
	 isProjection: { required: false  },
	  week: { type: Number },
      item: { type: Object, required: false },
	  isDefense: { type: Boolean },
    },
	data() {
    return {
	  	player_data:this.item,
      show_modal: false,
    }
	},
	computed: {
		fantasyPlayerStatsToShow: function() {
				return [null,null,null,null,null,null,null,null,null,null,null,null,'field_goals_attempted','field_goals_longest_made','field_goals_made50_plus','extra_points_made','field_goals_attempted','extra_points_attempted','fantasy_points_acme']
		},
		fantasyPlayerGameStats: function() {
			// if(this.isProjection)
			// 	return this.player_data.fantasy_player.player_game_projection[0]

			if(this.player_data.fantasy_player.player_game[0])
				return this.player_data.fantasy_player.player_game[0]

			return []
		},

			// 	scoreObject: function() {

			// 		  let player_game_fantasy_score=this.player_data.fantasy_player.fantasy_player_game_projection;

			// 			if(player_game_fantasy_score[0]){

			// 				return player_game_fantasy_score[0]
			// 			}

			// 			else{
			// 				if(this.isProjection){

			// 					  let player_game_fantasy_score=this.player_data.fantasy_player.player_game;

			// 						if(player_game_fantasy_score[0]){

			// 							return player_game_fantasy_score[0]
			// 						}

			// 				}

			// 			}
			// 		return '';
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
