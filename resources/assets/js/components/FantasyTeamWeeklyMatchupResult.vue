<template>
  <div>
    <div class="card">
      <div class="row no-gutters">
        <div class="col align-self-center">
          <div class="card-block">
            <h4 class="card-title division-name"><b>{{item.teamName}}</b></h4>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Vs</th>
                  <th scope="col">Head to Head</th>
                  <th scope="col">Overall</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="list in item.league_statics" :class="['team-'+list.away_team_id]" :dataset="list.away_team_id">
                  <th scope="row"><b>{{list.teamName}}</b></th>
                  <td>{{list.played_win}}-{{list.played_loss}}-{{list.played_tie}}</td>
                  <td>{{list.sim_win}}-{{list.sim_loss}}-{{list.sim_tie}}</td>
                </tr>
                <tr>
                  <th scope="row"><b>Total</b></th>
                  <td v-if="league_result">{{league_result.total_result_win}}-{{league_result.total_result_loss}}-{{league_result.total_result_tie}}</td>
                  <td v-if="league_result">{{league_result.all_win}}-{{league_result.all_loss}}-{{league_result.all_tie}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!--
<div  class="team-info">{{item.teamName}}</div>




 <div  class="team-status">
    <b-row class="fantasy-matchup">
        <b-col sm="4">Vs</b-col>
        <b-col sm="4">PLAYED</b-col>
    <b-col sm="4">ALL</b-col>
    </b-row>
  </div>
  <hr size="5">


    <div  v-for="list in item.league_statics" v-on:mouseover="mouseOver(list.away_team_id)" v-on:mouseout="mouseOut(list.away_team_id)"  :class="['team-'+list.away_team_id]" :dataset="list.away_team_id" >


  <b-row class="fantasy-matchup" >
        <b-col sm="4"><b>{{list.teamName}}</b></b-col>
        <b-col sm="4">{{list.played_win}}-{{list.played_loss}}-{{list.played_tie}}</b-col>
    <b-col sm="4">{{list.sim_win}}-{{list.sim_loss}}-{{list.sim_tie}}</b-col>
    </b-row>
  <hr size="10">

  </div>



  <b-row class="fantasy-matchup">
        <b-col sm="4"><b>Total</b></b-col>
        <b-col sm="4" v-if="league_result">{{league_result.total_result_win}}-{{league_result.total_result_loss}}-{{league_result.total_result_tie}}</b-col>
    <b-col sm="4" v-if="league_result">{{league_result.all_win}}-{{league_result.all_loss}}-{{league_result.all_tie}}</b-col>
    </b-row>
  <br/>


  -->
  </div>
</template>
<script>
export default {
  props: {
    item: { type: Object, required: false },
    league_result: { type: Object, required: false },
  },
  data() {
    return {
      active: false
    }


  },
  methods: {

    mouseOver: function(id) {

      $(".team-" + id).addClass("team_bgclass");

    },
    mouseOut: function(id) {

      $(".team-" + id).removeClass("team_bgclass");

    }
  }

}

</script>
