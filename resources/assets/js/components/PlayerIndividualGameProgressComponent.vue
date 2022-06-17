<template>
  <div>
    <span v-html="gameDetailsToShow" /><br/><a :href="getUrl" target="_blank"><b-icon icon="info-circle-fill"></b-icon> Game</a>
    <div v-if="greenArea != 0 && showProgress" class="progress">
      <span class="info"
        >{{ scoreObject.down }} & {{ scoreObject.distance }} on
        {{ scoreObject.yard_line_territory }} {{ scoreObject.yard_line }}</span
      >
      <div class="bar" :style="{ width: greenArea + '%' }" />
    </div>
  </div>
</template>

<style>
.progress {
  width: 100%;
  height: 31px;
  background: #808080;
  /*margin-top: -10px;*/
  position: relative;
  font-size: 0.75rem !important;
  color: white;
}

.info {
  position: absolute;
  /*    top: 50%;
    left: 50%;
    height: 30%;
    width: 50%;
    margin: -15% 0 0 -25%;*/
  padding-bottom: 7px;
  padding-top: 7px;
  padding-left: 5px;
}

.bar {
  background: green;
  height: 30px;
  color: white;
}
.greenArea span {
  position: absolute;
  top: 5px;
  z-index: 2;
  color: #fff;
  text-align: center;
  width: 100%;
}
</style>

<script>
  import { BIcon } from 'bootstrap-vue'
  Vue.component('b-icon', BIcon)

export default {
  props: {
    player: { type: Object, required: true },
  },
  computed: {
    getUrl: function() {
      return '/scores/nfl-games/box-scores/'+this.scheduleObject.game_key+'/'+this.scheduleObject.week+'/'+this.scheduleObject.season
    },
    getQuarter: function() {
      if(this.scoreObject.quarter != null && this.scoreObject.quarter != 'F' && this.scoreObject.quarter != 'HALF' && this.scoreObject.quarter != 'OT' && this.scoreObject.quarter != 'F/OT')
        return this.scoreObject.quarter +"Q";
      return this.scoreObject.quarter;
    },
    gameDetailsToShow: function() {
      if (this.playerByeWeek == this.week) return "on BYE";
      if (this.scoreObject) {
        let scoreHtml =
          this.scoreObject.away_team +
          " " +
          this.scoreObject.away_score +
          " @ " +
          this.scoreObject.home_team +
          " " +
          this.scoreObject.home_score +
          "<br />" +
          this.getQuarter
        if (this.scoreObject.time_remaining)
          scoreHtml += " " + this.scoreObject.time_remaining;
        // scoreHtml += "<b-icon\n" +
        //         "                icon=\"person-plus\"\n" +
        //         "                aria-hidden=\"true\"\n" +
        //         "              ></b-icon>"
        return scoreHtml;
      }
      if (this.scheduleObject)
        return (
          this.scheduleObject.away_team +
          " @ " +
          this.scheduleObject.home_team +
          "<br/>" +
          this.scheduleObject.date
        );
      return null;
    },
    scoreObject: function() {
      if (this.player.fantasy_player.team_game)
        return this.player.fantasy_player.team_game.score;

      // if (this.player.fantasy_player.player_game)
      //   return this.player.fantasy_player.player_game.score;

      return false;
    },

    scheduleObject: function() {
      // Make sure we have data before we try to use it.
      if (
        !this.player.fantasy_player.team.team_away_schedule &&
        !this.player.fantasy_player.team.team_home_schedule
      )
        return {};
      // if (this.player.fantasy_player.teams.TeamFullSchedule[0]) {
      //   return this.player.fantasy_player.teams.TeamFullSchedule[0];
      if (this.player.fantasy_player.team.team_away_schedule.length > 0) {
        return this.player.fantasy_player.team.team_away_schedule[0];
      }
      if (this.player.fantasy_player.team.team_home_schedule.length > 0) {
        return this.player.fantasy_player.team.team_home_schedule[0];
      }
      return {};
    },

    playerByeWeek: function() {
      return this.player.fantasy_player.bye_week;
    },

    week: function() {
      return this.player.week;
    },

    greenArea: function() {
      let score = this.scoreObject;
      if (score) {
        //Figure out logic for when to show progress. Defense we don't show when the
        if (
          score.yard_line_territory &&
          this.player.team == score.yard_line_territory
        ) {
          //console.log(score.yard_line/100);
          return (score.yard_line / 100) * 100;
        } else {
          return ((50 - score.yard_line + 50) / 100) * 100;
        }
      } else {
        return 0;
      }
    },

    showProgress: function() {
      let show = false;

      // if (!this.player.score_object) return show;

      // console.log('key 1', this.player.fantasy_player.team.key);
      // console.log('key 2', this.scoreObject.possession);

      if(this.player.fantasy_player.position != 'DEF' && this.player.fantasy_player.position != 'ST' && this.player.fantasy_player.team.key === this.scoreObject.possession && this.scoreObject.down != null)
        return true;

      if(this.player.fantasy_player.position == 'DEF' && this.player.fantasy_player.team.key != this.scoreObject.possession && this.scoreObject.down != null)
        return true;

      return false;
    },
  },
};
</script>
