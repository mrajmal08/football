<template>
  <b-container fluid>
    <loading :active.sync="visible" :can-cancel="true"></loading>

    <div class="row">
      <div class="col-sm-12">
        <div class="bs-component">
          <div class="jumbotron">
            <div class="row">
              <div class="col">
                <h2>Roster Grid</h2>
              </div>
              <div class="col" style="display:flex">
                <h4>Week</h4>
                <b-form-select
                  v-model="selected_week"
                  v-on:change="getSelectedWeek"
                >
                  <option v-for="index in week" :key="index" :value="index">
                    {{ index }}</option
                  >
                </b-form-select>
              </div>
              <div class="col">
                <b-button variant="outline-primary" size="md"
                  ><fa-icon
                    icon="plus"
                    icon-id="botonProfile"
                    other-classes="my-bg-color"
                  />
                  ADD/DROP</b-button
                >
                <b-button variant="outline-primary" size="md"
                  ><fa-icon
                    icon="refresh"
                    icon-id="botonProfile"
                    other-classes="my-bg-color"
                  />
                  TRADES</b-button
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
      <b-table
        class="table-responsive"
        bordered
        :items="items"
        :fields="fields"
      >
        <template v-slot:cell(tqb)="data">
          <template v-for="player in data.value">
            <p>
              {{ player.fantasy_player.name }}, {{ player.fantasy_player.team }}<span v-if="player.bench">(Bench)</span>
            </p>
          </template>
        </template>
        <template v-slot:cell(rb)="data">
          <template v-for="player in data.value">
            <p>
              {{ player.fantasy_player.name }}, {{ player.fantasy_player.team }}<span v-if="player.bench">(Bench)</span>
            </p>
          </template>
        </template>
        <template v-slot:cell(wr)="data">
          <template v-for="player in data.value">
            <p>
              {{ player.fantasy_player.name }}, {{ player.fantasy_player.team }}<span v-if="player.bench">(Bench)</span>
            </p>
          </template>
        </template>
        <template v-slot:cell(te)="data">
          <template v-for="player in data.value">
            <p>
              {{ player.fantasy_player.name }}, {{ player.fantasy_player.team }}<span v-if="player.bench">(Bench)</span>
            </p>
          </template>
        </template>
        <template v-slot:cell(k)="data">
          <template v-for="player in data.value">
            <p>
              {{ player.fantasy_player.name }}, {{ player.fantasy_player.team }}<span v-if="player.bench">(Bench)</span>
            </p>
          </template>
        </template>
        <template v-slot:cell(def)="data">
          <template v-for="player in data.value">
            <p>
              {{ player.fantasy_player.name }}, {{ player.fantasy_player.team }}<span v-if="player.bench">(Bench)</span>
            </p>
          </template>
        </template>
        <template v-slot:cell(st)="data">
          <template v-for="player in data.value">
            <p>
              {{ player.fantasy_player.name }}, {{ player.fantasy_player.team }}<span v-if="player.bench">(Bench)</span>
            </p>
          </template>
        </template>
        <template slot="team" slot-scope="data">
          <b>{{ data.value }}</b>
        </template>
      </b-table>
    </div>
  </b-container>
</template>

<script>
// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  props: {
    week: { required: true },
  },
  components: {
    Loading,
  },
  data() {
    return {
      selected_week: this.week,
      visible: false,
      fields: {
        team: {
          label: "TEAM",
          sortable: false,
        },
        tqb: {
          label: "TQB",
          sortable: false,
        },
        rb: {
          label: "RB",
          sortable: false,
        },
        wr: {
          label: "WR",
          sortable: false,
        },
        te: {
          label: "TE",
          sortable: false,
        },
        k: {
          label: "K",
          sortable: false,
        },
        def: {
          label: "D",
          sortable: false,
        },
        st: {
          label: "ST",
          sortable: false,
        },
      },
      items: [],
    };
  },
  methods: {
    getSelectedWeek: function(week) {
      this.getPlayerTeam(week);
    },
    getPlayerTeam(week) {
      this.visible = true;
      axios
        .get("/team/roster-grid-data", { params: { week: week } })
        .then((response) => {
          this.items = response.data;
          //console.log(this.items);
          var self = this;
          self.visible = false;
        })
        .catch((error) => {});
    },
  },
  created() {
    this.getPlayerTeam(this.selected_week);
  },
};
</script>
