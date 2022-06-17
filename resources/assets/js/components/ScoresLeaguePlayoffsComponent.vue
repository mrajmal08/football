<template>
  <b-container fluid>
    <div>
      <b-dropdown id="ddown1" @click="changeItem" text="Select Week" class="m-md-2">
        <b-dropdown-item v-for="index in 4" @click="changeItem(index)" :key="index" :value="index">
          {{ index }}
        </b-dropdown-item>
      </b-dropdown>
      <span> Week {{week}} </span>
    </div>
    <div v-if="week == leagueWeek && currentTime.isBefore(revealTime)" style="min-height: 400px;" >
      <h3 class="text-center">Please wait until {{ revealTimeUser }}</h3>
    </div>
    <div v-else>
      <loading :active.sync="isLoading" color="#007bff" :height="128" :width="128"></loading>
      <div style="position: fixed;
      bottom: 50px;
      left: 10px; z-index:100;">
        <button class="btn btn-secondary zoomButton" data-type="prev" data-root=".zoomViewport">Prev</button>
        <button class="btn btn-secondary zoomButton" data-type="next" data-root=".zoomViewport">Next</button>
      </div>
      <live-team-score-post-component :seasondetails="seasonData" :week="week" v-if="!loading && error ==''">
      </live-team-score-post-component>
      <b-col md="12" class="alert alert-info text-center" v-if="!loading && error !=''">
        {{error}}
      </b-col>
    </div>
  </b-container>
</template>
<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
  props: {
    week: { type: Number, required: true },
  },
  components: {
    Loading
  },
  mounted() {
    console.log('Component mounted.');
  },
  data() {
    return {
      seasonData: [],
      isLoading: false,
      loading: true,
      error: '',
      currentTime: 0,
      showPlayoffs: false,
      revealTime: null,
      revealTimeUser: null,
      gettingData: false
    }
  },
  created() {
    this.isLoading = true;
    this.revealTime = moment([2021, 1, 1, 19, 0, 0, 0]).tz("America/Chicago"); // Year, Month (0=Jan), Day, Hour, Min, Sec, Micro
    // this.revealTime = moment([2021, 0, 31, 13, 2, 0, 0]).tz("America/Chicago"); // Year, Month (0=Jan), Day, Hour, Min, Sec, Micro
    this.$store.dispatch("getSystemSettings", {});
    this.getCurrentTime();
  },
  mounted() {
    this.getPostSeasonData();

    // If we haven't shown the playOff data yet, check every second to show it.
    if (!this.showPlayoffs)
    {
        setInterval(() => {
          if(!this.showPlayoffs)
            this.getCurrentTime();
      }, 1000)
    }


    setInterval(() => {
      if (this.gettingData) {
        // console.log('skip data');
        return;
      }
      this.getPostSeasonData();
      // Only do time stuff if we aren't showing the playoffs yet.
      if (!this.showPlayoffs)
        this.getCurrentTime();
    }, 20000)
  },
  computed: {
    leagueWeek() {
      return this.$store.getters.systemSettings.week
    },
  },
  methods: {
    getCurrentTime: function() {
      // console.log('getCurrentTime')
      this.currentTime = moment().tz("America/Chicago");
      this.revealTimeUser = this.revealTime.tz("MST").format("dddd, MMMM Do, h:mm:ss a z");

      // Don't continue if we already know to show the Playoff data
      if(this.showPlayoffs == true)
        return;

      if(this.leagueWeek) {
        if (this.leagueWeek == this.week){
          if(this.currentTime.isAfter(this.revealTime)){
              this.showPlayoffs = true;
              return;
          }
        } else {
          this.showPlayoffs = true;
          return;
        }
      }
      this.showPlayoffs = false;
    },
    changeItem: function(week) {
      window.location.href = '/scores/league-playoffs/' + week;
    },
    getPostSeasonData() {
      // if(!this.showPlayoffs)
      //   return;
      // console.log('getPostSeasonData');
      this.gettingData = true;
      axios.get('/season-post-details', {
          params: {
            week: this.week,
          }
        })
        .then((response) => {
          this.isLoading = false;
          this.loading = true;
          this.gettingData = false;
          if (typeof(response.data.error) != "undefined") {
            this.error = response.data.error;
            this.loading = false;
          } else {
            this.loading = false;
            this.seasonData = response.data;
            this.error = '';
          }
        })
        .catch(error => {});
    }
  }
}

</script>
