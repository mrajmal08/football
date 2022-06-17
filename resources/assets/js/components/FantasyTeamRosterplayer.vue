

<template>
  <tr
    class="text-center"
    @click="showModal"
  >
    <td>{{ player_data.position }} </td>

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
    </td><td>
      {{ scoreObject.opponent }}
    </td>


    <td class="nowrap"><player-individual-game-progress :player="player_data" /></td>

    <td><span>{{ player_data.fantasy_player.bye_week }}</span></td>
    <td />
    <td />
    <td />
    <td />
    <td><span v-if="scoreObject.fantasy_points_acme">{{ scoreObject.fantasy_points_acme|changeFormat }}</span><span v-else>0</span></td>
    <td><span v-if="avg_score">{{ avg_score|changeFormat }}</span><span v-else>0</span></td>
    <td><b v-if="scoreObjectProjection.fantasy_points_acme">{{ scoreObjectProjection.fantasy_points_acme|changeFormat }}</b><b v-else>0</b></td>



    <player-detail-modal-component
      :player_id="player_data.fantasy_player.id"
      :showModal="show_modal"
      @update:showModal="show_modal = $event"
    />
  </tr>
</template>

<script>

export default {filters:{
		changeFormat:function(value){
			return Number.parseFloat(value).toFixed(2);
		}
	},
	props:{
	 isProjection: { required: false  },
	  week: { type: Number },
      item: { type: Object, required: false },
	  isOffense: { type: Boolean},
    },
	data() {
      return {
	   player_data:this.item,
      	show_modal: false,
		avg_score:'',
      	position: 'QB', move: '0', name: 'Aaron Rodgers',team: 'GB', opponent: '@SEA', status: 'Thu 7:30 pm', genius: '-', passing_yards: '-',passing_touchdowns: '-', passing_interceptions: '-', rushing_yards: '-', rushing_touchdowns: '-', receiving_yards: '-', receiving_touchdowns: '-', ret_td: '-', misc_fum_td: '-',
			 two_pt: '-', fumbles_lost: '-', fantasy_points_acme: '0.00', team_logo: 'https://cdn.head-fi.org/g/2283245_l.jpg'}
	},
	computed: {

	scoreObject: function() {


			if(this.isOffense){
				let fantasy_defense_game_fantasy_score=this.player_data.fantasy_player.fantasy_defense_game;
			     if(fantasy_defense_game_fantasy_score[0]){
					return fantasy_defense_game_fantasy_score[0]
				}

			}
			  let player_game_fantasy_score=this.player_data.fantasy_player.player_game;

				if(player_game_fantasy_score[0]){

					return player_game_fantasy_score[0]
				}

				return '';
      },
	  scoreObjectProjection: function() {


			if(this.isOffense){

				let player_game_fantasy_score=this.player_data.fantasy_player.fantasy_defense_game_projection;

				if(player_game_fantasy_score[0]){

				return player_game_fantasy_score[0]
				}

			}
			let player_game_fantasy_score=this.player_data.fantasy_player.fantasy_player_game_projection;

				if(player_game_fantasy_score[0]){

					return player_game_fantasy_score[0]
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
	created() {

        this.getPlayers(this.player_data.fantasy_player.id);
    },
	methods: {

	getPlayers(id){
		axios.get('/average_score',{
					params: {
				  projection: this.isProjection,
				  player_id: id,

				}

				})
				.then((response)=>{
					this.avg_score=response.data;
					//console.log(response.data)

				})
				.catch(error => {});
	}			,
	onClose () {

		  this.$refs.popover.$emit('close')
		},


	showModal () {
		this.show_modal = true
    }
  }
}
</script>
