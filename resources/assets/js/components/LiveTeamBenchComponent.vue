<template>
  <b-row>
    <div class="col-md-6 col-xs-12">
      <b-row>
        <div class="col-xs-12 col-md-12">
          <div v-for="player in teamOneBench">
            <live-players-score-component :key="player.id" :player="player" :isPlayer="false" :week="week" :season="season" />
          </div>
        </div>
        <div class="col-xs-12 col-md-12">
          <p style="padding-top:20px"><b>BENCH TOTAL</b></p>
          <div class="pull-right text-right">
            <span><b>{{teamOneBenchTotal}}</b></span>
            </br>
            <span>{{teamOneBenchExpectedTotal}}</span>
          </div>
        </div>
      </b-row>
    </div>
    <div class="col-md-6 col-xs-12">
      <b-row>
        <div class="col-xs-12 col-md-12">
          <div v-for="player in teamTwoBench">
            <live-players-score-component :key="player.id" :player="player" :isPlayer="false" :week="week" :season="season" />
          </div>
        </div>
        <div class="col-xs-12 col-md-12">
          <p style="padding-top:20px"><b>BENCH TOTAL</b></p>
          <div class="pull-right text-right">
            <span><b>{{teamTwoBenchTotal}}</b></span>
            </br>
            <span>{{teamTwoBenchExpectedTotal}}</span>
          </div>
        </div>
      </b-row>
    </div>
  </b-row>
</template>
<style>
</style>
<script>
import LivePlayerScoreComponent from "./LivePlayerScoreComponent.vue";

export default {
  components: { LivePlayerScoreComponent },
  props: {
    team_one_id: { type: Number, required: false },
    team_two_id: { type: Number, required: false },
    week: { type: Number, required: true },
    season: { type: Number, required: true },
  },
  data() {
    return {

    }
  },
  created() {

    // this.$store.dispatch('loadFantasyTeamData2',{team_id:this.team_one_id, team_id2:this.team_two_id, week:this.week, season:this.season, projection: 0});


  },
  computed: {

    teamOneBench: function() {
      return this.$store.getters.getBenchFantasyPlayers(this.team_one_id)
    },
    teamTwoBench: function() {

      return this.$store.getters.getBenchFantasyPlayers(this.team_two_id)
    },

    teamOneBenchTotal: function() {
      return this.teamOneBench.reduce(function(teamOneBenchTotal, item) {
        var total = parseFloat(teamOneBenchTotal) + parseFloat(item.fantasy_points_acme);
        return parseFloat(total).toFixed(2);
      }, 0);
    },
    teamOneBenchExpectedTotal: function() {
      // let oPts = this.teamOnePlayers.reduce((prev,next) => prev + next.projected_fantasy_points_acme,0);
      let oPts = 0;
      this.teamOneBench.forEach(function(player) {
        if (player.position != 'DEF') {
          if (player.fantasy_player.player_game_projection.length > 0)
            oPts += parseFloat(player.fantasy_player.player_game_projection[0].fantasy_points_acme)
        }
        if (player.position == 'DEF') {
          if (player.fantasy_player.fantasy_defense_game_projection.length > 0)
            oPts += parseFloat(player.fantasy_player.fantasy_defense_game_projection[0].fantasy_points_acme)
        }

      });
      // let oPts = this.teamOnePlayers.reduce((prev,next) => (prev + next.fantasy_player.player_game_projection[0].fantasy_points_acme,0);
      return oPts;
      // return oPts.toFixed(2)
    },
    // teamOneBenchExpectedTotal: function(){
    //  return this.teamOneBench.reduce(function(teamOneBenchExpectedTotal, item){
    //    var total = parseFloat(teamOneBenchExpectedTotal) + parseFloat(item.predicted_score);
    //    return parseFloat(total).toFixed(2);
    //  },0);
    // },
    teamTwoBenchTotal: function() {
      return this.teamTwoBench.reduce(function(teamTwoBenchTotal, item) {
        var total = parseFloat(teamTwoBenchTotal) + parseFloat(item.fantasy_points_acme);
        return parseFloat(total).toFixed(2);
      }, 0);
    },
    teamTwoBenchExpectedTotal: function() {
      // let oPts = this.teamOnePlayers.reduce((prev,next) => prev + next.projected_fantasy_points_acme,0);
      let oPts = 0;
      this.teamTwoBench.forEach(function(player) {
        if (player.position != 'DEF') {
          if (player.fantasy_player.player_game_projection.length > 0)
            oPts += parseFloat(player.fantasy_player.player_game_projection[0].fantasy_points_acme)
        }
        if (player.position == 'DEF') {
          if (player.fantasy_player.fantasy_defense_game_projection.length > 0)
            oPts += parseFloat(player.fantasy_player.fantasy_defense_game_projection[0].fantasy_points_acme)
        }

      });
      // let oPts = this.teamOnePlayers.reduce((prev,next) => (prev + next.fantasy_player.player_game_projection[0].fantasy_points_acme,0);
      return oPts;
      // return oPts.toFixed(2)
    },
    // teamTwoBenchExpectedTotal: function(){
    //  return this.teamTwoBench.reduce(function(teamTwoBenchExpectedTotal, item){
    //    var total = parseFloat(teamTwoBenchExpectedTotal) + parseFloat(item.predicted_score);
    //    return parseFloat(total).toFixed(2);
    //  },0);
    // }
  }
}

</script>
