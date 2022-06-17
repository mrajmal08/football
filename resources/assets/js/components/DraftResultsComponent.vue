<template>
  <b-container fluid>
    <loading :active.sync="visible" :can-cancel="true" />

    <div class="row">
      <div class="col-sm-12">
        <div class="bs-component">
          <div class="jumbotron">
            <h1 class="display-3">Draft Results</h1>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <b-table
          striped
          bordered
          large
          hover
          :items="items"
          :fields="fields"
        />
      </div>
    </div>
  </b-container>
</template>

<script>
// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  components: {
    Loading
  },
  data() {
    return {
      fields: [{
          key: "league_overall_pick",
          label: "Pick #"
        },
        {
          key: "round",
          label: "Round"
        },
        {
          key: "fantasy_team.name",
          label: "Team"
        },
        {
          key: "fantasy_player.name",
          label: "Player"
        },
        {
          key: "fantasy_player.position",
          label: "Position"
        }
      ],
      items: []
    }


  },
  methods: {
    getDraftPicks() {
      this.visible = true;
      axios
        .get("/league-draft-results")
        .then(response => {
          this.items = response.data;
          console.log(this.items);
          var self = this;
          self.visible = false;
        })
        .catch(error => {});
    }
  },
  created() {
    this.getDraftPicks();
  }
};
</script>
