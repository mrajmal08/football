<template>
  <b-card
    no-body
    class="overflow-hidden my-0"

  >
    <player-detail-modal-component
      :player_id="player_data.fantasy_player.id"
      :showModal="show_modal"
      :team_two_id="team_two_id"
      @update:showModal="show_modal = $event"
    />
    <b-row
      no-gutters
      class="bg-gradient"
    >
      <b-col
        cols="1"
        md="1"
        @click="showModal"
      >
        <b-card-img
          v-if="item.fantasy_player_id > 0"
          :src="playerImage"
          alt="Image"
          class="rounded-0"
        />
      </b-col>
      <b-col
        cols="3"
        md="3"
        class="p-1 my-auto"
      >
        <b-card-body class="p-0">
          <b-card-text>
            <strong
              v-if="item.fantasy_player_id > 0"
              @click="showModal"
            >{{playerName}}</strong>
            <p
              v-if="item.fantasy_player_id > 0"
              class="m-0"
            >
              {{ item.fantasy_player.team.key }} |
              {{ item.fantasy_player.position }}
            </p>
            <p>
              <font-awesome-icon
                v-if="item.fantasy_player.player.injury_status !=null"
                :icon="['fas', 'plus-circle']"
                :style="{ color: 'red' }"
              />
              <font-awesome-icon
                v-if="item.fantasy_player.player.status =='Suspended'"
                :icon="['fab', 'stripe-s']"
                :style="{ color: 'red' }"
              />
              <font-awesome-icon
                v-if="item.fantasy_player.fantasy_player_news && item.fantasy_player.fantasy_player_news.length > 0"
                :icon="['fas', 'sticky-note']"
                :style="{ color: '#FDB026' }"
              />
            </p>
          </b-card-text>
        </b-card-body>
      </b-col>
      <b-col
        cols="3"
        md="3"
        class="p-1 my-auto"
      >
      <player-individual-game-progress :player="player" />
        <!-- <player-individual-game-progress :player="player_details[0]" /> -->
      </b-col>
      <b-col
      cols="3"
        md="3"
        class="p-1 my-auto"
      >
        {{ player_statistics }}
      </b-col>
      <b-col
      cols="2"
        md="2"
        class="p-1 my-auto points"
      >
        <span><b>{{ player_fantasy_points_acme }}</b></span><br>
        <span class="text-muted text-small">{{ player_projected_fantasy_points_acme }}</span>
      </b-col>
    </b-row>
    <b-card-footer footer-class="text-left p-1" v-if="inGameNews">
      <span
        class="text-muted"
        style="font-size: 95%"
      >{{inGameNews}}</span>
    </b-card-footer>
  </b-card>
</template>

<style>
.points{
	font-size : 15px;
	text-align:right;
}
</style>

<script>

export default {
	props:{
	 week: { type: Number, required: true },
	    player: { type: Object, required: false },
		  isPlayer: { type: Boolean, required: false, default: true },
		  stats:{type: String, required: false},
		  team_two_id:{type: Number, required: false}
    },
	data() {
   return {
	 	player_data:this.player,
    item: this.player,
	 	test:'',
	 	show: true,
	 	show_modal: false,
		background_color: ''
		}
	},

	computed: {

		player_details_count:function(){
			return this.$store.getters.getPlayer(this.player.player_id).length;
		},

    playerImage: function() {
      let offenseArray = ['RB', 'WR', 'TE', 'K'];
      let imgSrc = 'https://cdn.head-fi.org/g/2283245_l.jpg';
      if (offenseArray.includes(this.item.fantasy_player.position))
      {
        // We have the regular offense.
        if(this.item.fantasy_player.player_photo_url)
          imgSrc = this.item.fantasy_player.player_photo_url
      } else  {
        if(this.item.fantasy_player.team.wikipedia_logo_url)
          imgSrc = this.item.fantasy_player.team.wikipedia_logo_url
      }
      return imgSrc;
    },
    inGameNews: function() {
      return false;
      if(this.item.fantasy_player.player_game.length > 0) {
        if(this.item.fantasy_player.position == 'TQB')
          return this.item.fantasy_player.player_game[0].passing_yards_per_completion +' passing yards / completion'
        if(this.item.fantasy_player.position == 'RB')
          return this.item.fantasy_player.player_game[0].rushing_yards_per_attempt + ' yards per rush';
        if(['WR', 'TE'].includes(this.item.fantasy_player.position))
          return this.item.fantasy_player.player_game[0].receiving_yards_per_reception + ' yards per rec';

        if(this.item.fantasy_player.position == 'K')
        {
          if(this.item.fantasy_player.player_game[0].fields_goals_longest_made > 0)
            return this.item.fantasy_player.player_game[0].fields_goals_longest_made + ' FG';
          return this.item.fantasy_player.player_game[0].extra_points_made + ' Xpts';
        }
      }

      if(this.item.fantasy_player.position == 'DEF' && this.item.fantasy_player.fantasy_defense_game.length > 0)
      {
        let news = ''
        if(this.item.fantasy_player.fantasy_defense_game[0].fumbles_forced > 0)
          news = this.item.fantasy_player.fantasy_defense_game[0].fumbles_forced + ' forced fumbles, ';
        news += this.item.fantasy_player.fantasy_defense_game[0].tackles_for_loss + ' tackles for loss';
        return news;
      }
      if(this.item.fantasy_player.position == 'ST' && this.item.fantasy_player.team_game)
      {
        let news = ''
        if(this.item.fantasy_player.team_game.kick_return_long > 0)
          news = this.item.fantasy_player.team_game.kick_return_long + ' yard kick return on day';
        return news;
      }
      return ''
    },
    playerName: function() {
      let name = this.item.fantasy_player.name;
      let offenseArray = ['RB', 'WR', 'TE', 'K'];
      if (!offenseArray.includes(this.item.fantasy_player.position))
        name = this.item.fantasy_player.team.name

      return name;
    },
		player_details:function(){

			var clonedPlayers = []
			return this.$store.getters.getPlayer(this.player_data.fantasy_player.player_id);
				// players.forEach(players => {
				// 	if(this.player.position==players.position){
                //
				// 		clonedPlayers.push({
				// 			...players
				// 		})
				// 	}
                //
				// });
				// return clonedPlayers;


		     //	return this.$store.getters.getPlayer(this.player.player_id);



		},is_def: function(){
					return this.player_details.reduce(function(player, item){
						return item.is_def;
					},'');
		},
		is_st: function(){
					return this.player_details.reduce(function(player, item){
						return item.is_st;
					},'');
		},
		team_qb: function(){
					return this.player_details.reduce(function(player, item){
						return item.team_qb;
					},'');
		},
		fplayer_id: function(){
					return this.player_details.reduce(function(player, item){
						return item.fplayer_id;
					},'');
		},
		player_name: function(){
					return this.player_details.reduce(function(player, item){
						return item.name;
					},'');
		},

		player_projected_fantasy_points_acme: function() {
			if(this.player_data.position == "DEF"){
				if(this.player_data.fantasy_player.fantasy_defense_game_projection[0])
					return this.player_data.fantasy_player.fantasy_defense_game_projection[0].fantasy_points_acme
			}
			// 	return ( typeof this.player_data.fantasy_player.fantasy_defense_game_projection[0] != 'undefined' && this.player_data.fantasy_player.fantasy_defense_game_projection[0] instanceof Array ) ? this.player_data.fantasy_player.fantasy_defense_game_projection[0].fantasy_points_acme : 0

			// return ( typeof this.player_data.fantasy_player.player_game_projection[0] != 'undefined' && this.player_data.fantasy_player.player_game_projection[0] instanceof Array ) ? this.player_data.fantasy_player.player_game_projection[0].fantasy_points_acme : 0
			if(this.player_data.fantasy_player.player_game_projection[0])
				return this.player_data.fantasy_player.player_game_projection[0].fantasy_points_acme

			return 0

		},

		player_fantasy_points_acme: function() {
			if(this.player_data.position == "DEF"){
				if(this.player_data.fantasy_player.fantasy_defense_game[0])
					return this.player_data.fantasy_player.fantasy_defense_game[0].fantasy_points_acme
			}
			// 	return ( typeof this.player_data.fantasy_player.fantasy_defense_game[0] != 'undefined' && this.player_data.fantasy_player.fantasy_defense_game[0] instanceof Array ) ? this.player_data.fantasy_player.fantasy_defense_game[0].fantasy_points_acme : 0

			// return ( typeof this.player_data.fantasy_player.player_game[0] != 'undefined' && this.player_data.fantasy_player.player_game[0] instanceof Array ) ? this.player_data.fantasy_player.player_game[0].fantasy_points_acme : 0
			if(this.player_data.fantasy_player.player_game[0])
				return this.player_data.fantasy_player.player_game[0].fantasy_points_acme

			return 0

		},

		player_position: function(){
					return this.player_details.reduce(function(player, item){
						return item.position;


					},'');
		},
		player_nfl_team_city: function(){
					return this.player_details.reduce(function(player, item){
						return item.team.key;
					},'');
		},
		player_nfl_game_live_score: function(){
					return this.player_details.reduce(function(player, item){
						return item.fantasyPlayer.score_object;
					},'');
		},
		player_statistics: function(){
      return this.item.statistics
      // console.log(this.player_data);
          return this.player_details.reduce(function(player, item){
            return item.statistics;
          },'');
					// return this.player_details.reduce(function(player, item){
					// 	return item.statistics;
					// },'');
		},
		player_real_score: function(){
					return this.player_details.reduce(function(player, item){
						return item.real_score;
					},'');
		},
		player_predicted_score: function(){
					return this.player_details.reduce(function(player, item){
						return item.predicted_score;
					},'');
		},
		player_passing_yards: function(){
					return this.player_details.reduce(function(player, item){
						return item.passing_yards;
					},'');
		},
		player_passing_touchdowns: function(){
					return this.player_details.reduce(function(player, item){
						return item.passing_touchdowns;
					},'');
		},
		player_passing_interceptions: function(){
					return this.player_details.reduce(function(player, item){
						return item.passing_interceptions;
					},'');
		},
		player_rushing_yards: function(){
					return this.player_details.reduce(function(player, item){
						return item.rushing_yards;
					},'');
		},
		player_rushing_touchdowns: function(){
					return this.player_details.reduce(function(player, item){
						return item.rushing_touchdowns;
					},'');
		},
		player_receiving_yards: function(){
					return this.player_details.reduce(function(player, item){
						return item.receiving_yards;
					},'');
		},
		player_receiving_touchdowns: function(){
					return this.player_details.reduce(function(player, item){
						return item.receiving_touchdowns;
					},'');
		},
		player_points_allowed: function(){
					return this.player_details.reduce(function(player, item){
						return item.points_allowed;
					},'');
		},
		player_sacks: function(){
					return this.player_details.reduce(function(player, item){
						return item.sacks;
					},'');
		},
		player_interceptions: function(){
					return this.player_details.reduce(function(player, item){
						return item.interceptions;
					},'');
		},
		player_fumbles_recovered: function(){
					return this.player_details.reduce(function(player, item){
						return item.fumbles_recovered;
					},'');
		},
		player_status: function(){
					return this.player_details.reduce(function(player, item){
						return item.status;
					},'');
		},
		injury_status: function(){
			return this.player_details.reduce(function(player, item){
				return item.injury_status;
			},'');
		},
		schedule_date_time: function(){
			return this.player_details.reduce(function(player, item){
				return item.schedule_date_time;
			},'');
		},
		quarter: function(){
			return this.player_details.reduce(function(player, item){
				return item.quarter;
			},'');
		},


		down: function(){
				return this.player_details.reduce(function(player, item){
					let score=item.score_object;
					if(score){
						return score.down;
					}
					else{
						return '';
					}
				},'');
		},

		yard_line_territory: function(){
					return this.player_details.reduce(function(player, item){
					let score=item.score_object;
					if(score){
						return score.yard_line_territory;
						}
					else{
							return '';
						}
					},'');
		},
		yard_line: function(){
					return this.player_details.reduce(function(player, item){
					let score=item.score_object;
					if(score){
						return score.yard_line;
						}
					},'');
		},
		possession: function(){
					return this.player_details.reduce(function(player, item){
					let score=item.score_object;
					if(score){
						return score.possession;
						}
					},'');
		},
		distance: function(){
					return this.player_details.reduce(function(player, item){
					let score=item.score_object;
					if(score){
						return score.distance;
						}
					else{
							return '';
						}
					},'');
		},
		greenArea: function(){
					return this.player_details.reduce(function(player, item){
					let score=item.score_object;

					if(score){

						if(score.yard_line_territory && item.team.key==score.yard_line_territory){
							//console.log(score.yard_line/100);
							return (score.yard_line/100)*100;
						}
						else{
							return (((50-score.yard_line)+50)/100)*100;
						}
					}
					else{
							return 0;
					}

					},'');
		}


	},
 watch: {
    player_fantasy_points_acme(val, old){
		if(val != old){
			if(val > old){
				this.background_color='bg-success';
			}
			if(val < old){
				this.background_color='bg-danger';
			}
		}
		setTimeout(()=>{
			this.background_color='';
		}, 2000);
    }
  },

	created(){

		// if(!this.isPlayer){
		// 	this.id 					= this.player.id;
		// 	this.name		 			= this.player.name;
		// 	this.position				= this.player.position;
		// 	this.nfl_team_city			= this.player.team;
		// 	this.nfl_game_live_score	= this.player.status;
		// 	this.statistics				= this.player.statistics;
		// 	this.fantasy_points_acme	= this.player.fantasy_points_acme;
		// 	this.predicted_score		= this.player.predicted_score;
		// 	this.passing_yards			= this.player.passing_yards;
		// 	this.passing_touchdowns		= this.player.passing_touchdowns;
		// 	this.passing_interceptions	= this.player.passing_interceptions;
		// 	this.rushing_yards			= this.player.rushing_yards;
		// 	this.rushing_touchdowns		= this.player.rushing_touchdowns;
		// 	this.receiving_yards		= this.player.receiving_yards;
		// 	this.receiving_touchdowns	= this.player.receiving_touchdowns;
		// 	this.points_allowed			= this.player.points_allowed;
		// 	this.sacks					= this.player.sacks;
		// 	this.interceptions			= this.player.interceptions;
		// 	this.fumbles_recovered		= this.player.fumbles_recovered;
		// }
 },
  methods: {
// onClose () {
// 		  this.$refs.popover.$emit('close')
// 		},

	showModal () {
      this.show_modal = true
    },
  }
}
</script>
