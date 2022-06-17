<template>
  <b-container fluid>
    <div v-if="loading" class="text-center">
        <b-spinner variant="primary" type="grow" label="Spinning" class="m-5 mb-0"></b-spinner>
        <h4>Loading games..</h4>
    </div>
    <div v-else>
      <div>
        <b-row>
          <div class="col-md-1">Year: </div>
          <div class="col-md-4">
            <b-form-select v-on:change="changeYear" v-model="season">
              <option>2021</option>
            </b-form-select>
          </div>
          <div class="col-md-1">Week: </div>
          <div class="col-md-4">
            <b-form-select v-on:change="getSelectedItem" v-model="week">
              <option v-for="index in 18" :key="index" :value="index" @change="changeWeek(index)"> {{ index }}</option>
            </b-form-select>
          </div>
        </b-row>
      </div>
      </br>
      <b-row>
        <div class="col-md-6" v-for="item in items">
          <fantasy-team-weekly-matchup-result-component :item="item" :league_result="item.league_result">
          </fantasy-team-weekly-matchup-result-component>
          </hr>
        </div>
      </b-row>
    </div>
  </b-container>
</template>
<script>
export default {
  props: {
    week: { type: Number, required: true },
    season: { type: String, required: true },

  },
  data() {
    return {
      items: [],
      options: [
        { value: null, text: 'Please select an option' },
        { value: 1, text: 1 },
        { value: 2, text: 2 },
      ],
      loading: true
    }
  },
  created() {

    axios.post('/get-matchup-result', {

        week: this.week,
        season: this.season,

      })
      .then((response) => {
        this.items = response.data.teamData;
        this.loading = false;
      });
  },
  methods: {

    getSelectedItem: function(week) {

      window.location.href = '/standings/overall/' + this.season + '/' + week;
    },
    changeWeek(week) {

      window.location.href = '/standings/overall/' + this.season + '/' + week;


    },
    changeYear: function(year) {

      window.location.href = '/standings/overall/' + year + '/' + this.week;


    }
  }


}

</script>
