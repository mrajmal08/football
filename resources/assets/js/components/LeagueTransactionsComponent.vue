<template>
  <div class="container">
    <div class="row">
      <div class="col-md-3 spark-settings-tabs"></div>
      <div class="col-md-9">
        <b-row class="md-4">
          <div class="col-md-5 md-4">
            <b-form-select v-on:change="getSelectedItem" v-model="team">
              <option value="all">All</option>
              <option v-for="team in fantasy_teams" :key="team.value" :value="team.value">{{ team.text }}</option>
            </b-form-select>
            <!--<b-dropdown id="ddown2" @click="getSelectedItem" text="Select Team" class="m-md-2">
          <b-dropdown-item key="all" value="all" @click="getSelectedItem('all')" >
          All
          </b-dropdown-item>
          <b-dropdown-item v-for="team in fantacy_teams" @click="getSelectedItem(team.value)" :key="team.value" :value="team.value" >
          {{ team.text  }}
          </b-dropdown-item>
        </b-dropdown>-->
          </div>
          <div class="col-md-3 md-4"> <span> Teams {{team}} </span></div>
        </b-row>
        <br />
        <b-row class="md-4">
          <div class="col-md-5  md-4">
            <b-form-select v-on:change="setSelectedWeek" v-model="selected_week">
              <option value="all">All</option>
              <option v-for="index in week" :key="index" :value="index">{{ index }}</option>
            </b-form-select>
            <!--

        <b-dropdown id="ddown1" @click="getSelectedWeek" text="Select Week" class="m-md-2">
          <b-dropdown-item v-for="index in week" @click="getSelectedWeek(index)" :key="index" :value="index" >
          {{ index }}
          </b-dropdown-item>
        </b-dropdown>-->
          </div>
          <div class="col-md-3 md-4"> <span> Week {{selected_week}} </span></div>
        </b-row>
        <br />
        <b-row>
          <!-- <league-draft-picks :week="selected_week" :team="team" :page="page"></league-draft-picks> -->
          <ul>
            <li v-for="item in showTransactions" :key="item.id" class="list-group-item">
              <div @click="rowClicked(item.fantasy_player_id)">
                ({{ item.created_at }}) <b>{{ item.fantasy_team.name }} </b>-
                <i>{{getTransTypeLabel(item.player_transaction_type_id)}}</i>:
                {{ item.fantasy_player.name }},
                {{ item.fantasy_player.team }},
                {{ item.fantasy_player.position }}
              </div>
            </li>
          </ul>
        </b-row>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment';
export default {

  props: {
    week: { required: true },
    teams: { type: String, required: true },
    transactions: {}

  },
  data() {
    return {
      page: 'league-draft',
      team: 'all',
      selected_week: this.week,
      fantasy_teams: JSON.parse(this.teams),
      transactionsArray: JSON.parse(this.transactions)
    }
  },

  computed: {
    showTransactions: function() {
      let theTransactions = this.transactionsArray;

      theTransactions = theTransactions.filter((item) => {
        if(this.team == 'all')
          return (this.getSelectedWeek().includes(item.week))
        else
          return (this.getSelectedWeek().includes(item.week) && (this.team == item.fantasy_team_id))
      })

      return theTransactions;
    },

  },

  methods: {
    getTransTypeLabel: function(transType) {
      let transMap = {1: 'Add', 2: 'Drop'}

      return transMap[transType];
    },

    getSelectedItem: function(team) {

      this.team = team;
    },
    setSelectedWeek: function(week) {
      this.selected_week = week;
    },

    getSelectedWeek: function() {
      let result;
      if(this.selected_week == 'all')
        result = Array.from({length: 18}, (v, k) => k+1);
      else
        result = [this.selected_week];

      //console.log('result, ', result);
      return result;
    }
  }

}

</script>
