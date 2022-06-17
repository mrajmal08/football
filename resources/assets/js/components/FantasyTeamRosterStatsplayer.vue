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

<style>

.table_super_heading, .table thead th {
  text-transform: uppercase;
  text-align: center;
}
</style>

<script>

export default {
	filters:{
		changeFormat:function(value){
			return Number.parseFloat(value).toFixed(2);
		}
	},

	props:{
	 isProjection: { type: Boolean, required: false  },
	  week: { type: Number },
    item: { type: Object, required: false },
	  isDefense: { type: Boolean },
    isSt: { type: Boolean }
  },
	data() {
    return {
	   		player_data:this.item,
      	show_modal: false,
			}
	},

	computed: {

		fantasyPlayerGameStats: function() {

      if(this.player_data.fantasy_player.position == 'DEF')
      {
        if(this.isProjection)
          return this.player_data.fantasy_player.fantasy_defense_game_projection[0]

        if(this.player_data.fantasy_player.fantasy_defense_game[0])
          return this.player_data.fantasy_player.fantasy_defense_game[0]

      } else {
        if(this.isProjection)
          return this.player_data.fantasy_player.player_game_projection[0]

        if(this.player_data.fantasy_player.player_game[0])
          return this.player_data.fantasy_player.player_game[0]
      }


			return []

		},

		fantasyPlayerStatsToShow: function() {
      if(this.player_data.fantasy_player.position == 'DEF')
        return ['points_allowed','fumbles_forced','fumbles_recovered','interceptions','sacks','safeties','tackles_for_loss','touchdowns_scored','offensive_yards_allowed',null,null,null,null,null,null,'fantasy_points_acme']

      if(this.player_data.fantasy_player.position == 'ST')
        return [null,null,null,null,null,null,null,null,null,'punt_return_yards','kick_return_yards','punt_return_touchdowns','kick_return_touchdowns','punt_return_yards_per_attempt','kick_return_yards_per_attempt','fantasy_points_acme']

      if(this.player_data.fantasy_player.position == 'K'){
        return [null,null,null,null,null,null,null,null,null,null,null,null,'field_goals_attempted','field_goals_longest_made','field_goals_made50_plus','field_goals_attempted','extra_points_made','extra_points_attempted','fantasy_points_acme']
      }

			return ['passing_attempts','passing_completions','passing_yards','passing_touchdowns','passing_interceptions','rushing_attempts','rushing_yards','rushing_yards_per_attempt','rushing_touchdowns','receiving_targets','receiving_touchdowns','receiving_yards','receiving_touchdowns','fumbles_lost','fantasy_points_acme']
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
