<template>
  <b-container fluid>
    <loading :active.sync="visible" :can-cancel="true"></loading>
    <div class="row">
      <div class="col-sm-12">
        <div class="jumbotron">
          <div class="bs-component">
            <h2>Injury Report</h2>
            <b-row>
              <b-col cols="3">
                <h6>POSITION</h6>
                <b-form-select v-on:change="getSelectedPosition" v-model="selected_position">
                  <option value="all">All</option>
                  <option v-for="team in playerPositions" :value="team.value">
                    {{ team.text }}
                  </option>
                </b-form-select>
              </b-col>
<!--               <b-col cols="3">
                <h6>TYPE</h6>
                <b-form-select v-model="selected_type">
                  <option value="all">All</option>
                </b-form-select>
              </b-col> -->
            </b-row>
          </div>
        </div>
      </div>
    </div>
    <b-row>
      <b-table responsive :items="items" :fields="fields">
        <template slot="team" slot-scope="data">
          <span v-if="data.item.fantasy_player && data.item.fantasy_player.team_roster && data.item.fantasy_player.team_roster.fantasy_team">
            {{ data.item.fantasy_player.team_roster.fantasy_team.name }}
          </span>
          <span v-else>
            Free Agent
          </span>
        </template>
        <template slot="name" slot-scope="data">
          <b>{{ data.item.name }}</b> {{ data.item.position }} | {{ data.item.team }}
        </template>
      </b-table>
    </b-row>
  </b-container>
</template>
<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
  components: {
    Loading
  },
  data() {
    return {
      visible: false,
      selected_position: 'all',
      selected_type: 'all',
      playerPositions: [],
      fields: [{
          key: "updated_at",
          label: 'UPDATED',
          sortable: true,
          formatter: value => {
            return moment(value).format('MM/DD/YY')
          }
        }, {
          key: "name",
          label: "PLAYER",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
        },
        {
          key: 'team',
          label: 'TEAM',
          sortable: true,
          tdClass: 'player-team'
        },
        {
          key: 'current_status',
          label: 'STATUS',
          sortable: true
        },
        {
          key: 'injury_body_part',
          label: 'INURY',
          sortable: false
        },
        {
          key: 'injury_notes',
          label: 'INJURY NOTES',
          sortable: false,
          tdClass: 'injury_notes'
        },

      ],
      items: []
    }
  },
  methods: {
    getSelectedPosition: function(position) {
      this.getPlayerInjuryReport(position);
    },

    getPlayerPosition() {
      axios.get('/players/positions')
        .then((response) => {

          response.data.positions.forEach((value, key) => {
            this.playerPositions.push({ text: value, value: value })
          })
        })
        .catch(error => {});
    },
    getPlayerInjuryReport(position) {
      this.visible = true;
      axios.get('/players-injury-report', {
          params: { position: position }
        })
        .then((response) => {
          this.items = response.data;
          console.log(this.items);
          var self = this;
          self.visible = false;

        })
        .catch(error => {});
    }
  },
  created() {

    this.getPlayerInjuryReport('all');
    this.getPlayerPosition();
  }
}

</script>
