<template>
  <div>
    <div class="col-md-6 pull-left p-0 pr-md-3">
      <div
        v-for="player in teamOnePlayers"
        :key="player.id"
        class="mt-1"
      >
        <live-players-score-component
          key="player.id"
          :player="player"
          :isPlayer="false"
          :week="week"
          :team_two_id="team_two_id"
        />
      </div>
      <div>
        <p style="padding-top:30px;font-size:16px"><b>STARTERS TOTAL</b></p>
        <!-- <div class="pull-left col-sm-6"><span>{{ teamOneStatistics | trim }}</span></div> -->
        <div class="pull-right points col-sm-2">
          <span><b v-bind="emitTeamOneTotal">{{ teamOneTotal }}</b></span>
          <br>
          <span
            style="font-size:14px"
            v-bind="emitTeamOneExpectedTotal"
          >{{ teamOneExpectedTotal.toFixed(2) }}</span>
        </div>
      </div>
    </div>
    <div class="col-md-6 pull-left p-0 pl-md-3">
      <div
        v-for="player in teamTwoPlayers"
        :key="player.id"
        class="mt-1"
      >
        <live-players-score-component
          :key="player.id"
          :player="player"
          :isPlayer="false"
          :week="week"
        />
      </div>
      <div>
        <p style="padding-top:30px;font-size:16px"><b>STARTERS TOTAL</b></p>
        <!-- <div class="pull-left col-sm-6"><span>{{ teamTwoStatistics | trim }}</span></div> -->
        <div class="pull-right col-sm-2 points">
          <span><b v-bind="emitTeamTwoTotal">{{ teamTwoTotal }}</b></span>
          <br>
          <span
            style="font-size:14px"
            v-bind="emitTeamTwoExpectedTotal"
          >{{ teamTwoExpectedTotal.toFixed(2) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
</style>

<script>
import LivePlayerScoreComponent from "./LivePlayerScoreComponent.vue";
export default {
  filters: {
    // Filter definitions
    trim(value) {
      value = value.replace(/,\s*$/, "");
      return value;
    }
  },
  props: {
    team_one_id: { type: Number, required: false },
    team_two_id: { type: Number, required: false },
    week: { type: Number, required: true },
    season_type: { type: String, required: true }
  },
  data() {
    return {};
  },
  computed: {
    teamOnePlayers: function() {
      // console.log('----------------'+this.$store.getters.getFantasyPlayers(this.team_one_id));
      return this.$store.getters.getFantasyPlayers(this.team_one_id);
    },
    teamTwoPlayers: function() {
      return this.$store.getters.getFantasyPlayers(this.team_two_id);
    },
    teamOneStatistics: function() {
      return this.teamOnePlayers.reduce(function(teamOneStatistics, item) {
        return teamOneStatistics + item.statistics + " ,";
      }, "");
    },
    teamOneTotal: function() {
      var sum = 0;
      var fantasy_points = [];
      this.teamOnePlayers.forEach(function(element) {
        element.fantasy_player.player_game.forEach(function(element2) {
          fantasy_points.push(element2.fantasy_points_acme);
        });

        element.fantasy_player.fantasy_defense_game.forEach(function(element2) {
          fantasy_points.push(element2.fantasy_points_acme);
        });
      });

      var total = 0;
      for (var i = 0; i < fantasy_points.length; i++) {
        if (isNaN(fantasy_points[i])) {
          continue;
        }
        total += Number(fantasy_points[i]);
      }

      this.teamTotalPlayed('teamOne');
      this.teamTotalNotPlayed('teamOne');
      this.teamTotalMinutesRemaining('teamOne');

      return parseFloat(total).toFixed(2);
    },
    teamOneExpectedTotal: function() {
      // let oPts = this.teamOnePlayers.reduce((prev,next) => prev + next.projected_fantasy_points_acme,0);
      let oPts = 0;
      this.teamOnePlayers.forEach(function(player) {
        if(player.position != 'DEF')
        {
          if(player.fantasy_player.player_game_projection.length > 0)
            oPts += parseFloat(player.fantasy_player.player_game_projection[0].fantasy_points_acme)
        }
        if(player.position == 'DEF')
        {
          if(player.fantasy_player.fantasy_defense_game_projection.length > 0)
            oPts += parseFloat(player.fantasy_player.fantasy_defense_game_projection[0].fantasy_points_acme)
        }

      });
      // let oPts = this.teamOnePlayers.reduce((prev,next) => (prev + next.fantasy_player.player_game_projection[0].fantasy_points_acme,0);
      return oPts;
      // return oPts.toFixed(2)
    },
    teamTwoStatistics: function() {
      return this.teamTwoPlayers.reduce(function(teamTwoStatistics, item) {
        return teamTwoStatistics + item.statistics + " ,";
      }, "");
    },
    teamTwoTotal: function() {
      var sum = 0;
      var fantasy_points = [];
      this.teamTwoPlayers.forEach(function(element) {
        element.fantasy_player.player_game.forEach(function(element2) {
          fantasy_points.push(element2.fantasy_points_acme);
        });

        element.fantasy_player.fantasy_defense_game.forEach(function(element2) {
          fantasy_points.push(element2.fantasy_points_acme);
        });
      });

      var total = 0;
      for (var i = 0; i < fantasy_points.length; i++) {
        if (isNaN(fantasy_points[i])) {
          continue;
        }
        total += Number(fantasy_points[i]);
      }
      this.teamTotalPlayed('teamTwo');
      this.teamTotalNotPlayed('teamTwo');
      this.teamTotalMinutesRemaining('teamTwo');

      return parseFloat(total).toFixed(2);
    },
    teamTwoExpectedTotal: function() {
      // let oPts = this.teamOnePlayers.reduce((prev,next) => prev + next.projected_fantasy_points_acme,0);
      let oPts = 0;
      this.teamTwoPlayers.forEach(function(player) {
        if(player.position != 'DEF')
        {
          if(player.fantasy_player.player_game_projection.length > 0)
            oPts += parseFloat(player.fantasy_player.player_game_projection[0].fantasy_points_acme)
        }
        if(player.position == 'DEF')
        {
          if(player.fantasy_player.fantasy_defense_game_projection.length > 0)
            oPts += parseFloat(player.fantasy_player.fantasy_defense_game_projection[0].fantasy_points_acme)
        }

      });
      return oPts;
    },
    emitTeamOneTotal(event) {
      this.$emit("childToParentTeamOneTotal", this.teamOneTotal);
    },
    emitTeamTwoTotal(event) {
      this.$emit("childToParentTeamTwoTotal", this.teamTwoTotal);
    },
    emitTeamOneExpectedTotal(event) {
      this.$emit(
        "childToParentTeamOneExpectedTotal",
        this.teamOneExpectedTotal
      );
    },
    emitTeamTwoExpectedTotal(event) {
      this.$emit(
        "childToParentTeamTwoExpectedTotal",
        this.teamTwoExpectedTotal
      );
    },

    getkickerByeweekTeamPlayer() {
      var clonedPlayers = [];

      var kickerplayers = this.$store.getters.getkickerByeweekTeamPlayer(
        this.week
      );

      kickerplayers.forEach(players => {
        clonedPlayers.push(players.name);
      });

      var offenceplayers = this.$store.getters.getoffenceByeweekTeamPlayer(
        this.week
      );

      offenceplayers.forEach(players => {
        clonedPlayers.push(players.name);
      });

      var deffenceplayers = this.$store.getters.getdeffenceByeweekTeamPlayer(
        this.week
      );

      deffenceplayers.forEach(players => {
        clonedPlayers.push(players.name);
      });

      var specialplayers = this.$store.getters.getspecialByeweekTeamPlayer(
        this.week
      );

      specialplayers.forEach(players => {
        clonedPlayers.push(players.name);
      });

      var namelist = clonedPlayers.join(", ");

      //console.log(clonedPlayers);

      return namelist;
      //return this.$store.getters.getkickerByeweekTeamPlayer(6);
    },

    activeGames: function() {

      this.teamTwoPlayers.forEach(function(player) {
        if(player.position != 'DEF')
        {
          if(player.fantasy_player.player_game.length > 0)
            if(player.fantasy_player.player_game[0].score.is_in_progress)
              return true;
        }
        if(player.position == 'DEF')
        {
          if(player.fantasy_player.fantasy_defense_game.length > 0)
            if(player.fantasy_player.fantasy_defense_game[0].score.is_in_progress)
              return true
        }

      });

      this.teamOnePlayers.forEach(function(player) {
        if(player.position != 'DEF')
        {
          if(player.fantasy_player.player_game.length > 0)
            if(player.fantasy_player.player_game[0].score.is_in_progress)
              return true;
        }
        if(player.position == 'DEF')
        {
          if(player.fantasy_player.fantasy_defense_game.length > 0)
            if(player.fantasy_player.fantasy_defense_game[0].score.is_in_progress)
              return true
        }

      });

      return false;
    }
  },
  created() {

    this.$store.dispatch("loadFantasyTeamData2", {
      team_id: this.team_one_id,
      team_id2: this.team_two_id,
      week: this.week,
      season_type: this.season_type,
      projection: 0
    });

    let counter = 15000; //60000

    if(this.activeGames)
      counter = 15000; //15000

    this.$nextTick(function () {
      window.setInterval(() => {
        this.$store.dispatch("loadFantasyTeamData2", {
          team_id: this.team_one_id,
          team_id2: this.team_two_id,
          week: this.week,
          season_type: this.season_type,
          projection: 0
        });
      }, counter);
    })

    // Emit data

  },
  methods: {
    teamTotalPlayed: function(team) {
      let teamSelect = team + 'Players';
      // console.log('teamOneTotalPlayed 1');
      var sum = 0;
      var totalPlayed = 0;
      this[teamSelect].forEach(function(element) {
        // console.log('element', element.fantasy_player.team_game[0]);
        if(element.fantasy_player.team_game)
          totalPlayed += element.fantasy_player.team_game.score.has_started ? 1 : 0;
      });
      // console.log('teamOneTotalPlayed 2', totalPlayed);
      this.$emit(team+'TotalPlayed', totalPlayed)
    },

    teamTotalNotPlayed: function(team) {
      let teamSelect = team + 'Players';
      // console.log('teamOneTotalPlayed 1');
      var sum = 0;
      var totalPlayed = 0;
      this[teamSelect].forEach(function(element) {
        // console.log('element', element.fantasy_player.team_game[0]);
        if(element.fantasy_player.team_game)
          totalPlayed += element.fantasy_player.team_game.score.has_started ? 0 : 1;
        else
          totalPlayed += 1;
      });
      // console.log('teamOneTotalPlayed 2', totalPlayed);
      this.$emit(team+'TotalNotPlayed', totalPlayed)
    },

    teamTotalMinutesRemaining: function(team) {
      let teamSelect = team + 'Players';
      // console.log('teamOneTotalPlayed 1');
      var sum = 0;
      var minutes = 0;
      this[teamSelect].forEach(function(element) {
        //console.log('element', element.fantasy_player.team_game);
        if(element.fantasy_player.team_game) {
          if (element.fantasy_player.team_game.score.has_started) {
            let quarter = 0;
            if (element.fantasy_player.team_game.score.quarter === '1')
              quarter = 1
            if (element.fantasy_player.team_game.score.quarter === '2')
              quarter = 2
            if (element.fantasy_player.team_game.score.quarter === '3')
              quarter = 3
            if (element.fantasy_player.team_game.score.quarter === '4')
              quarter = 4
            if (element.fantasy_player.team_game.score.quarter === 'HALF')
              quarter = 2
            if (element.fantasy_player.team_game.score.quarter === 'F')
              quarter = 4
            if (element.fantasy_player.team_game.score.quarter === 'OT')
              quarter = 4
            if (element.fantasy_player.team_game.score.quarter === 'F/OT')
              quarter = 4

            let time_remaining = 0;
            if(element.fantasy_player.team_game.score.time_remaining){
              //console.log(element.fantasy_player.team_game.score.time_remaining.split(':')[0]);
              time_remaining = Number(element.fantasy_player.team_game.score.time_remaining.split(':')[0])
            }
            //console.log('time_remaining', time_remaining)
            minutes += ((4 - quarter) * 15) + time_remaining
          }
        }
        else
          minutes += 60;
      });
      // console.log('teamOneTotalPlayed 2', totalPlayed);
      this.$emit(team+'TotalMinutesRemaining', minutes)
    }

  }
};
</script>
