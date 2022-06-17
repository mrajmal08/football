<template>
  <b-container fluid>
    <b-row>
      <b-col md="12" class="my-1 main-box">
        <b-tabs no-fade>
          <b-form inline>
            <label class="mr-sm-2" for="inline-form-custom-select-pref">
              Week:</label>
            <b-form-select v-model="week" @change="changeWeek">
              <option v-for="index in league_setting_week" :key="index" :value="index">
                {{ index }}
              </option>
            </b-form-select>
            <b-form-group id="input-group-4" style="margin-left:10px">
            </b-form-group>
          </b-form>
          <div v-for="item in items" class="main-box">
            <div v-for="(teams, tindex) in item.teamData" class="pull-left col-sm-2 league-box" @click="changeLeaque(tindex)">
              <p v-for="(val, index) in teams">
                <span>{{ val.teamName }}</span><span :class="{ higher: 1==val.isWon }" class="pull-right">{{ val.score }}</span>
                <br />
                <!-- <span>PMR : {{ val.PMR }}</span> -->
              </p>
            </div>
          </div>
        </b-tabs>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
export default {
  props: {
    week: { type: Number, required: true },
    season_type: { type: String, required: true },
    season: { type: Number, required: true }


  },
  data() {
    return {
      items: [],
      league_setting_week: []
    }
  },

  created() {
    this.getSettings();
    this.getLeagueGames();
  },

  mounted: function() {
  window.setInterval(() => {
    this.getLeagueGames()
  }, 30000)
  },
  methods: {
    getSettings() {
      axios.get('/get_system_setting')
        .then((response) => {
          let N = response.data.week;

          if(response.data.season_type == 3)
            N = 17;

          this.league_setting_week = Array(N).fill().map((_, i) => i + 1);
        })
        .catch(error => {});
    },
    getLeagueGames() {
      axios.get('/get-league-game', {
          params: {
            week: this.week,
          }
        })
        .then((response) => {
          this.items = response.data;
        })
        .catch(error => {});
    },
    changeLeaque: function(game) {

      if (game)
        window.location.href = '/scores/fantasy-games/week/' + this.week + '/season_type/' + this.season_type + '/season/' + this.season + '/game/' + game;
      else
        window.location.href = '/scores/fantasy-games/week/' + this.week + '/season_type/' + this.season_type + '/season/' + this.season;
    },

    changeWeek: function(week) {
      this.week = week;

      window.location.href = '/scores/fantasy-games/week/' + this.week + '/season_type/' + this.season_type + '/season/' + this.season;
    }
  }
}

</script>
