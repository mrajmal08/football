<template>
  <div>
    <player-detail-modal-component
      :player_id="selected_player_id"
      :showModal="show_modal"
      :draftComplete="true"
      :week="leagueWeek"
      @update:showModal="show_modal = $event"
    />
    <div class="container-fluid jumbo-container">
      <div class="row container">
        <div class="col-sm-12">
          <b-row>
            <div class="col-sm-4">
              <div v-if="current_team.team_owner" class="fantasyPageTeamHeader">
                <div class="logoCover">
                  <div class="logo">
                    <img
                      :src="
                        current_team.team_owner.photo_url != null
                          ? current_team.logo_url
                          : 'https://cdn.head-fi.org/g/2283245_l.jpg'
                      "
                      style="border-radius: 50%;border: 2px solid #fff;width: 100px;height: 100px;"
                      fluid
                    />
                  </div>
                </div>
                <div class="teaminfo">
                  <div class="teamName">
                    <div class="select_form_div">
                      <div class="dropdown">
                        <button
                          id="dropdownMenuButton"
                          class="btn btn-primary dropdown-toggle"
                          type="button"
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          {{ current_team.name }}
                        </button>
                        <div
                          class="dropdown-menu"
                          aria-labelledby="dropdownMenuButton"
                        >
                          <a
                            v-for="item in teams"
                            :key="item.id"
                            class="dropdown-item"
                            href="#"
                            @click="changeTeam(item.id)"
                            >{{ item.name }}</a
                          >
                        </div>
                        <b class="selected_arrow" />
                      </div>
                    </div>
                    <div>
                      <div class="teamOwners">
                        {{ current_team.team_owner.name }}
                      </div>
                    </div>
                    <div class="teamRecord">(0 - 0 - 0)</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-3">
              <h2>Actual: {{actualPoints}}</h2>
              <h4>Projected: {{projectedPoints}}</h4>
            </div>
          </b-row>
          <b-row>
            <b-col cols="6 teamOwnersAndSettings">
              <b-form inline>
                <label class="mr-sm-2" for="inline-form-custom-select-pref">
                  Week:</label
                >
                <b-form-select v-model="week" @change="changeItem">
                  <option
                    v-for="index in league_setting_week"
                    :key="index"
                    :value="index"
                  >
                    {{ index }}
                  </option>
                </b-form-select>
                <b-form-group id="input-group-4" style="margin-left:10px">
                  <!--<b-button variant="primary" size="md">-->
                    <!--<fa-icon-->
                      <!--icon="plus"-->
                      <!--icon-id="botonProfile"-->
                      <!--other-classes="my-bg-color"-->
                    <!--/>-->
                    <!--ADD/DROP-->
                  <!--</b-button>-->
                </b-form-group>
              </b-form>
            </b-col>
          </b-row>
        </div>
      </div>
    </div>
    <div class="container" style="padding:0px">
      <b-tabs id="player_tabs" pills>
        <br />
        <b-alert v-if="getkickerByeweekTeamPlayer" show variant="warning">
          The following players are on BYE this week:
          {{ getkickerByeweekTeamPlayer }}
        </b-alert>

        <!--      <b-tab title="OVERVIEW" @click="selectTab(1)" active>



        <div class="sections table-responsive">
          <table class="table table-hover" id="table_with_subhead">
            <thead>

              <tr class="superheader">
              <th rowspan="2">POS</th>
              <th rowspan="2" class="td-left">Players</th>
              <th colspan="3"><div class="table_super_heading">Schedule</div></th>
              <th colspan="2"><div class="table_super_heading">Rank</div></th>
              <th colspan="2"><div class="table_super_heading">Trends</div></th>
              <th colspan="3"><div class="table_super_heading">Fantasy Points</div></th>

              </tr>
              <tr class="subhead">
              <th>Opp</th>
              <th>Game Time</th>
              <th>Bye</th>
              <th>PosRnk</th>
              <th>Ovp</th>
              <th>Own</th>
              <th>Start</th>
              <th>2018</th>
              <th>3yr Avg</th>
              <th>Proj</th>

              </tr>
            </thead>
            <tbody>
               <tr is="fantasyteam-roster-player-component" v-for="(item, index) in getoffenseTeam" :item="item" :isDefense="false" :week="week" :isProjection="false" v-bind:key="item.id">
               </tr>

               <tr is="fantasyteam-roster-player-component" v-for="(item,index) in getkickersTeam" :item="item" :isDefense="false" :week="week" :isProjection="false" v-bind:key="item.id"></tr>

               <tr is="fantasyteam-roster-player-component" v-for="(item,index) in getdefenseTeam" :item="item" :isDefense="true" :week="week" :isProjection="false" v-bind:key="item.id"></tr>

               <tr is="fantasyteam-roster-player-component" v-for="(item,index) in getspecialTeam" :item="item" :isDefense="false" :week="week" :isProjection="false" v-bind:key="item.id"></tr>

               <tr is="fantasyteam-roster-player-component" v-for="(item,index) in getoffenseBenchTeam" :item="item" :isDefense="false" :week="week" :isProjection="false" v-bind:key="item.id"></tr>

               <tr is="fantasyteam-roster-player-component" v-for="(item, index) in getdefenseBenchTeam" :item="item" :isDefense="false" :week="week" :isProjection="false" v-bind:key="item.id"></tr>

               <tr is="fantasyteam-roster-player-component" v-for="(item,index) in getspecialBenchTeam" :item="item" :isDefense="false" :week="week" :isProjection="false" v-bind:key="item.id"></tr>
            </tbody>
          </table>
        </div>
      </b-tab> -->

        <b-tab title="STATS" @click="selectTab(2)">
          <div class="sections table-responsive">
            <table id="table_with_subhead" class="table table-hover">
              <thead>
                <tr class="title">
                  <td colspan="19">
                    Offense
                    <a href="#" class="sectionHelp"
                      ><span class="learnMore"
                    /></a>
                  </td>
                </tr>
                <tr class="superheader">
                  <th rowspan="2">POS</th>
                  <th rowspan="2" class="td-left">
                    Players
                  </th>
                  <th rowspan="2">BYE</th>
                  <th rowspan="2">OPP</th>
                  <th colspan="5">
                    <div class="table_super_heading">Passing</div>
                  </th>
                  <th colspan="4">
                    <div class="table_super_heading">Rushing</div>
                  </th>
                  <th colspan="4">
                    <div class="table_super_heading">Receiving</div>
                  </th>
                  <th colspan="1">
                    <div class="table_super_heading">Fumbles</div>
                  </th>
                  <th colspan="2">
                    <div class="table_super_heading" style="border: none;">
                      &nbsp;
                    </div>
                  </th>
                </tr>
                <tr class="subhead text-center">
                  <th>ATT</th>
                  <th>Comp</th>
                  <th>Yds</th>
                  <th>TD</th>
                  <th>Int</th>
                  <th>ATT</th>
                  <th>Yds</th>
                  <th>AVG</th>
                  <th>TD</th>
                  <th>TAR</th>
                  <th>REC</th>
                  <th>YDS</th>
                  <th>TD</th>
                  <th>LOST</th>
                  <th rowspan="2">FPTS</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  is="fantasyteam-roster-stats-player-component"
                  v-for="item in getoffenseTeam"
                  :key="item.id"
                  :item="item"
                  :isDefense="false"
                  :week="week"
                  :isProjection="false"
                />
              </tbody>
            </table>

            <table id="table_with_subhead" class="table table-hover">
              <thead>
                <tr class="title">
                  <td colspan="21">
                    Defense
                    <a href="#" class="sectionHelp"
                      ><span class="learnMore"
                    /></a>
                  </td>
                </tr>
                <tr class="superheader text-center">
                  <th rowspan="2">POS</th>
                  <th rowspan="3" class="td-left">
                    Players
                  </th>
                  <th rowspan="2">BYE</th>
                  <th rowspan="2">OPP</th>
                  <th>PA</th>
                  <th>Int</th>
                  <th>SACK</th>
                  <th>STY</th>
                  <th>TK</th>
                  <th>FF</th>
                  <th>DFR</th>
                  <th>DTD</th>
                  <th>YDS</th>
                  <th>PRYd</th>
                  <th>KRYd</th>
                  <th>PRTD</th>
                  <th>KRTD</th>
                  <th>PRAvg</th>
                  <th>KRAvg</th>
                  <th rowspan="2">FPTS</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  is="fantasyteam-roster-stats-dfence-player-component"
                  v-for="item in getdefenseTeam"
                  :key="item.id"
                  :item="item"
                  :isDefense="true"
                  :week="week"
                  :isProjection="false"
                />

                <tr
                  is="fantasyteam-roster-stats-dfence-player-component"
                  v-for="item in getspecialTeam"
                  :key="item.id"
                  :item="item"
                  :isSt="true"
                  :isDefense="false"
                  :week="week"
                  :isProjection="false"
                />
              </tbody>
            </table>

            <table id="table_with_subhead" class="table table-hover">
              <thead>
                <tr class="title">
                  <td colspan="25">
                    Kicking
                    <a href="#" class="sectionHelp"
                      ><span class="learnMore"
                    /></a>
                  </td>
                </tr>
                <tr class="superheader text-center">
                  <th rowspan="2">POS</th>
                  <th rowspan="2" class="td-left">
                    Players
                  </th>
                  <th rowspan="2">BYE</th>
                  <th rowspan="2">OPP</th>
                  <th rowspan="2" />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th>FG</th>
                  <th>FGLg</th>
                  <th>FG50</th>
                  <th>XP</th>
                  <th>FGA</th>
                  <th>XPAtt</th>
                  <th>FPTS</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  is="fantasyteam-roster-stats-kicker-player-component"
                  v-for="item in getkickersTeam"
                  :key="item.id"
                  :item="item"
                  :isDefense="false"
                  :week="week"
                  :isProjection="false"
                />
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-6">
              <b-table
                      id="table_with_subhead"
                      class="table table-hover text-left player-table-with-modal"
                      :items="getBenchFantasyPlayers"
                      :fields="benchFields"
                      @row-clicked="showModal"
              >
                <template v-slot:thead-top="data">
                  <b-tr class="title">
                    <b-td colspan="6">BENCH</b-td>
                  </b-tr>
                </template>
                    <!-- <td>{{player_data.position}}</td> -->


<!--     <td>
      {{player_data.fantasy_player.team.upcoming_opponent}}
    </td> -->
<!--     <template v-for="property in fantasyPlayerStatsToShow">
      <td>{{ fantasyPlayerGameStats[property] }}</td>
    </template> -->
                <template v-slot:cell(fantasy_player.name)="data" colspan="1">
                      <b>{{data.item.fantasy_player.name}}</b> | {{data.item.fantasy_player.team.full_name}}
    <font-awesome-icon  v-if="data.item.fantasy_player.player.injury_status !=null" :icon="['fas', 'plus-circle']" :style="{ color: 'red' }" />
    <font-awesome-icon v-if="data.item.fantasy_player.player.status =='Suspended'" :icon="['fab', 'stripe-s']":style="{ color: 'red' }" />
    <font-awesome-icon v-if="data.item.fantasy_player.fantasy_player_news && data.item.fantasy_player.fantasy_player_news.length > 0" :icon="['fas', 'sticky-note']":style="{ color: '#FDB026' }" />

                </template>
              </b-table>
            </div>
          </div>
        </b-tab>

        <b-tab title="PROJECTION" @click="selectTab(3)">
          <div class="sections table-responsive">
            <table id="table_with_subhead" class="table table-hover">
              <thead>
                <tr class="title">
                  <td colspan="19">
                    Offense
                    <a href="#" class="sectionHelp"
                      ><span class="learnMore"
                    /></a>
                  </td>
                </tr>
                <tr class="superheader">
                  <th rowspan="2">POS</th>
                  <th rowspan="2" class="td-left">
                    Players
                  </th>
                  <th colspan="5">
                    <div class="table_super_heading">Passing</div>
                  </th>
                  <th colspan="4">
                    <div class="table_super_heading">Rushing</div>
                  </th>
                  <th colspan="4">
                    <div class="table_super_heading">Receiving</div>
                  </th>
                  <th colspan="1">
                    <div class="table_super_heading">Fumbles</div>
                  </th>
                  <th rowspan="1"></th>
                </tr>
                <tr class="subhead">
                  <th>ATT</th>
                  <th>Comp</th>
                  <th>Yds</th>
                  <th>TD</th>
                  <th>Int</th>
                  <th>ATT</th>
                  <th>Yds</th>
                  <th>AVG</th>
                  <th>TD</th>
                  <th>TAR</th>
                  <th>REC</th>
                  <th>YDS</th>
                  <th>TD</th>
                  <th>LOST</th>
                  <th>FPTS</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  is="fantasyteam-roster-stats-player-component"
                  v-for="item in getoffenseTeam"
                  :key="item.id"
                  :item="item"
                  :isDefense="false"
                  :week="week"
                  :isProjection="true"
                />
              </tbody>
            </table>

            <table id="table_with_subhead" class="table table-hover">
              <thead>
                <tr class="title">
                  <td colspan="19">
                    Defense & ST
                    <a href="#" class="sectionHelp"
                      ><span class="learnMore"
                    /></a>
                  </td>
                </tr>
                <tr class="superheader">
                  <th colspan="2"></th>
                  <th colspan="1">
                    <div class="table_super_heading">Pts</div>
                  </th>
                  <th colspan="3">
                    <div class="table_super_heading">Turnovers</div>
                  </th>
                  <th colspan="2">
                    <div class="table_super_heading">Scoring</div>
                  </th>
                  <th colspan="2">
                    <div class="table_super_heading">Stats</div>
                  </th>
                  <th colspan="1">
                    <div class="table_super_heading">Yds</div>
                  </th>
                  <th colspan="6">
                    <div class="table_super_heading">ST</div>
                  </th>
                  <th colspan="1"></th>
                </tr>
                <tr class="subhead">
                  <th rowspan="2">POS</th>
                  <th rowspan="3" class="td-left">
                    Players
                  </th>
                  <th>Against</th>
                  <th>FF</th>
                  <th>FR</th>
                  <th>INT</th>
                  <th>DTD</th>
                  <th>STY</th>
                  <th>TK</th>
                  <th>SACK</th>
                  <th>ALLOW</th>
                  <th>PRYd</th>
                  <th>KRYd</th>
                  <th>PRTD</th>
                  <th>KRTD</th>
                  <th>PRAvg</th>
                  <th>KRAvg</th>
                  <th>FPTS</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  is="fantasyteam-roster-stats-player-component"
                  v-for="item in getdefenseTeam"
                  :key="item.id"
                  :item="item"
                  :week="week"
                  :isProjection="true"
                />

                <tr
                  is="fantasyteam-roster-stats-player-component"
                  v-for="item in getspecialTeam"
                  :key="item.id"
                  :item="item"
                  :week="week"
                  :isProjection="true"
                />
              </tbody>
            </table>

            <table id="table_with_subhead" class="table table-hover">
              <thead>
                <tr class="title">
                  <td colspan="21">
                    Kicking
                    <a href="#" class="sectionHelp"
                      ><span class="learnMore"
                    /></a>
                  </td>
                </tr>
                <tr>
                  <th rowspan="2">POS</th>
                  <th rowspan="2" class="td-left">
                    Players
                  </th>

                  <th rowspan="2" />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th />
                  <th>FG</th>
                  <th>FGLg</th>
                  <th>FG50</th>
                  <th>FGA</th>
                  <th>XP</th>
                  <th>XPAtt</th>
                  <th>FPTS</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  is="fantasyteam-roster-stats-player-component"
                  v-for="item in getkickersTeam"
                  :key="item.id"
                  :item="item"
                  :week="week"
                  :isProjection="true"
                />
              </tbody>
            </table>
          </div>
        </b-tab>
      </b-tabs>
    </div>
  </div>
</template>
<style>
.jumbotron {
  background: #0055a6;
  color: #fff;
}
.jumbo-container {
  background: #0055a6;
  color: #fff;

  left: 0;

  position: relative;
  width: 100%;
  z-index: 0;
}
.superheader th {
  border: none !important;
}
.table th,
.table td {
  padding: 0.7rem;
}
.table_super_heading {
  text-align: center;
  border-bottom: 1px solid #c1cacf;
  padding: 0.8rem;
}

table.text-left th {
  text-align: left!important;
}
tr.title {
  font-family: proxima-nova, "Helvetica", "Arial", sans-serif;
  font-weight: 700;
  font-style: normal;
  font-size: 13px;
  background-color: #e6e7e8;
  color: #232323;
  padding: 10px 0px;
  padding-right: 0px;
  padding-left: 0px;
  text-transform: uppercase;
}
.fantasyPageTeamHeader .logo {
  float: left;
  width: 100px;
  height: 100px;
  margin: 20px 20px 0 20px;
}
.fantasyPageTeamHeader .teaminfo {
  float: left;
  margin-top: 20px;
}
.teamOwners {
  font-size: 0.7em;
}
.teamName {
  line-height: 3rem;
  font-weight: 700;
  font-style: normal;
  font-size: 25px;
  color: #fff;
}
.teamRecord {
  font-family: proxima-nova, "Helvetica", "Arial", sans-serif;
  font-weight: 600;
  font-style: normal;
  font-size: 14px;
  line-height: 18px;
  color: #fff;
}
.td-left {
  text-align: left !important;
}
.teamOwnersAndSettings {
  margin-left: 20px;
  margin-top: 20px;
}
</style>
<script>
import FantasyTeamRosterplayer from "./FantasyTeamRosterplayer.vue";
import TeamRosterPlayerComponentKicker from "./TeamRosterPlayerComponentKicker.vue";
import TeamRosterPlayerComponentDefense from "./TeamRosterPlayerComponentDefense.vue";
import TeamRosterPlayerComponentSpecial from "./TeamRosterPlayerComponentSpecial.vue";

export default {
  components: {},
  filters: {
    changeFormat: function(value) {
      return Number.parseFloat(value).toFixed(2);
    },
  },
  props: {
    week: { type: Number, required: true },
    season: { required: true, type: String },
    team_id: { required: true, type: String },
    season_type: { required: true, type: String },
    league_setting_week: { type: Number, required: true },
  },
  data() {
    return {
      benchFields: [
        { key: "position", label: "POS" },
        { key: "fantasy_player.name", label: "Player" },
        { key: "fantasy_player.bye_week", label: "Bye" },
        { key: "fantasy_player.team.upcoming_opponent", label: "Opp" },
      ],
      loading: false,
      offenseTeam: [],
      kickersTeam: [],
      defenseTeam: [],
      specialTeam: [],
      bye_week_player: [],
      teams: [],
      current_team: [],
      show_modal: false,
      selected_player_id: 0,
    };
  },
  computed: {
    leagueWeek() {
      return this.$store.getters.systemSettings.week
    },
    projectedPoints() {
      //let pts = 0
      let oPts = this.getoffenseTeam.reduce((prev,next) => prev + next.projected_fantasy_points_acme,0);
      let dPts = this.getdefenseTeam.reduce((prev,next) => prev + next.projected_fantasy_points_acme,0);
      let kPts = this.getkickersTeam.reduce((prev,next) => prev + next.projected_fantasy_points_acme,0);
      let gpts = this.getspecialTeam.reduce((prev,next) => prev + next.projected_fantasy_points_acme,0);
      let total = oPts + dPts + kPts + gpts;
      return total.toFixed(2)
    },
    actualPoints() {
      //let pts = 0
      let oPts = this.getoffenseTeam.reduce((prev,next) => prev + next.fantasy_points_acme,0);
      let dPts = this.getdefenseTeam.reduce((prev,next) => prev + next.fantasy_points_acme,0);
      let kPts = this.getkickersTeam.reduce((prev,next) => prev + next.fantasy_points_acme,0);
      let gpts = this.getspecialTeam.reduce((prev,next) => prev + next.fantasy_points_acme,0);
      let total = oPts + dPts + kPts + gpts;
      return total.toFixed(2)
    },
    getoffenseTeam() {
      return this.$store.getters.getoffenseTeamPlayer(1);
    },
    getkickersTeam() {
      return this.$store.getters.getkickersTeamPlayer(1);
    },
    getdefenseTeam() {
      return this.$store.getters.getdefenseTeamPlayer(1);
    },
    getspecialTeam() {
      return this.$store.getters.getspecialTeamPlayer(1);
      //return this.$store.state.specialTeam;
    },
    getBenchFantasyPlayers() {
      // console.log('get bench');
      return this.$store.getters.getBenchFantasyPlayers(this.team_id);
    },
    getoffenseBenchTeam() {
      return this.$store.getters.getoffenseTeamBenchPlayer(1);
    },
    getkickersBenchTeam() {
      return this.$store.getters.getkickersTeamBenchPlayer(1);
    },
    getdefenseBenchTeam() {
      return this.$store.getters.getdefenseTeamBenchPlayer(1);
    },
    getspecialBenchTeam() {
      return this.$store.getters.getspecialTeamBenchPlayer(1);
    },

    getkickerByeweekTeamPlayer() {
      // console.log('getkickerByeweekTeamPlayer');
      // console.log('this.week', this.week)
      var clonedPlayers = [];
      var kickerplayers = this.$store.getters.getkickerByeweekTeamPlayer(
        this.week
      );
      kickerplayers.forEach((players) => {
        clonedPlayers.push(players.fantasy_player.name);
      });

      var offenceplayers = this.$store.getters.getoffenceByeweekTeamPlayer(
        this.week
      );
      offenceplayers.forEach((players) => {
        clonedPlayers.push(players.fantasy_player.name);
      });

      var deffenceplayers = this.$store.getters.getdeffenceByeweekTeamPlayer(
        this.week
      );
      // console.log('deffenceplayers', deffenceplayers);
      deffenceplayers.forEach((players) => {
        clonedPlayers.push(players.fantasy_player.name);
      });

      var specialplayers = this.$store.getters.getspecialByeweekTeamPlayer(
        this.week
      );
      specialplayers.forEach((players) => {
        clonedPlayers.push(players.fantasy_player.name);
      });
      var namelist = clonedPlayers.join(", ");
      // console.log("clonedPlayers", clonedPlayers)
      return namelist;
    },
  },
  created() {
    this.$store.dispatch("loadFantasyTeamData2", {
      team_id: this.team_id,
      team_id2: "",
      week: this.week,
      season: this.season,
      season_type: this.season_type,
      projection: 0,
    });

    this.$store.dispatch("getSystemSettings", {});
    this.getTeams();
  },
  methods: {
    showModal(player) {
      this.selected_player_id = player.fantasy_player.id;
      this.show_modal = true;
    },
    changeTeam(team_id) {
      window.location.href =
        "/team/roster/week/" +
        this.week +
        "/season/" +
        this.season_type +
        "/teams/" +
        team_id;
    },
    changeItem: function(week) {
      window.location.href =
        "/team/roster/week/" + week + "/season/REG/teams/" + this.team_id;
    },
    selectTab(selectedTab) {
      if (selectedTab == 3) {
        this.$store.dispatch("loadFantasyTeamData2", {
          team_id: this.team_id,
          team_id2: "",
          week: this.week,
          season: this.season,
          season_type: this.season_type,
          projection: 1,
        });
      } else {
        this.$store.dispatch("loadFantasyTeamData2", {
          team_id: this.team_id,
          team_id2: "",
          week: this.week,
          season: this.season,
          season_type: this.season_type,
          projection: 0,
        });
      }
    },
    getTeams() {
      this.loading = true;
      axios
        .get("/league/team", {
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
          },
        })
        .then((response) => {
          this.teams = response.data.allteams;
          this.teams.forEach((value, key) => {
            if (value.id == this.team_id) {
              this.current_team = value;
            }
          });
          this.loading = false;
        })
        .catch((error) => {});
    },
  },
};
</script>
