<template>
<!--   <ul v-if="draftData.draft_started && draftData.show_timer" class="vuejs-countdown">
    <li>
      <p class="digit">{{ minutes | two_digits }}</p>
      <p class="text">min</p>
    </li>
    <li>
      <p class="digit">{{ seconds | two_digits }}</p>
      <p class="text">Sec</p>
    </li>
  </ul> -->
  <div class="countdown" v-if="draftData.league.draft_started && timeLeft != '00:00'">
    <h4>Round {{draftData.currentDraft.round}}</h4>
    <h2>{{ timeLeft }}</h2>
    <strong>{{draftData.currentDraft.fantasy_team.name}} on the clock</strong>
    <!-- <h3>Countdown ends at <span>{{ endTime }}</span></h3> -->
  </div>
  <div v-else-if="draftData.league.draft_order_generated && !draftData.league.draft_started">
    <h2>Starting soon..</h2>
  </div>
  <div v-else-if="draftData.league.draft_started && timeLeft == '00:00' && !draftData.league.draft_completed">
    <h4>Round {{draftData.currentDraft.round}}</h4>
    <h2>The pick is in!</h2>
    <strong>{{draftData.currentDraft.fantasy_team.name}} on the clock</strong>
  </div>
  <div v-else>
    <h3>&nbsp;</h3>
  </div>
</template>
<script>
var moment = require("moment");
var intervalTimer;
let interval = null;
//import { EventBus } from "./event-bus.js";
export default {
  name: "VuejsCountDown",
  data() {
    return {
      timeLeft: '',
      endTime: '0',
      soundPlaying: false
    }
  },

  computed: {
    draftData() {
      return this.$store.state.leagueDraftData;
    },
    deadline() {
      if(this.draftData.currentDraft)
        return moment.utc(this.draftData.currentDraft.deadline);
      return 0
    },
    currentDraftTeam() {
      if(this.draftData.currentDraft.fantasy_team)
        return this.draftData.currentDraft.fantasy_team.user_id;
    },
    loggedInUserId() {
      return this.$store.state.userFantasyTeam.user_id;
    },
    draftKickedOff() {
      if(this.draftData.league.draft_started && this.draftData.currentDraft.league_overall_pick == 1 && this.timeLeft != '00:00')
        return true;
      return false;
    }
  },
  watch: {
    deadline: function(newRequest, oldRequest) {
      // console.log('watch')
      // console.log(newRequest)
      this.setTime()
    },
    currentDraftTeam: function(newRequest, oldRequest) {
      // console.log('currentDraftTeam1 ', newRequest)
      if(this.loggedInUserId == newRequest)
        this.playSound(this.draftData.on_clock_audio);
    },
    draftKickedOff: function(newRequest, oldRequest) {
      // console.log('draftKickedOff ', newRequest)
      if(newRequest)
        this.playSound(this.draftData.draft_start_audio);
    },
  },
  mounted() {
    this.setTime()
  },
  methods: {
    playSound (sound) {
      if(sound) {
        // console.log('play sound')
        this.soundPlaying = true;
        var audio = new Audio(sound);
        audio.play();
        this.soundPlaying = false;
      }
    },
    setTime() {
      //console.log('setTime with seconds: '+ time)
      clearInterval(intervalTimer);
      this.timer();
    },
    timer() {
      var now = moment(new Date()).utc(); //todays date
      var momentDraftDate = moment(this.deadline); // Draft Pick time
      this.countdown(momentDraftDate);
    },
    countdown(end) {
      // console.log('end is: ', end)
      intervalTimer = setInterval(() => {

        //if the end is in the future then get the seconds left
        let now = moment(Date.now());
        let secondsLeft = 0;
        if(end > now )
          secondsLeft = Math.round((end - now) / 1000);

        if(secondsLeft > this.draftData.league.draft_pick_max_time)
          secondsLeft = this.draftData.league.draft_pick_max_time

        //console.log('countdown secondsLeft: ',secondsLeft)

        // if(secondsLeft === 0) {
        //   this.endTime = 0;
        // }

        // if(secondsLeft < 0) {
        //   clearInterval(intervalTimer);
        //   return;
        // }
        this.displayTimeLeft(secondsLeft)
      }, 1000);
    },
    displayTimeLeft(secondsLeft) {
      //console.log('secondsLeft: ',secondsLeft)
      const minutes = Math.floor((secondsLeft % 3600) / 60);
      const seconds = secondsLeft % 60;
      this.timeLeft = `${zeroPadded(minutes)}:${zeroPadded(seconds)}`;
    },
    // displayEndTime(timestamp) {
    //   const end = new Date(timestamp);
    //   const hour = end.getHours();
    //   const minutes = end.getMinutes();

    //   this.endTime = `${hourConvert(hour)}:${zeroPadded(minutes)}`
    // },
  }
};
function zeroPadded(num) {
  // 4 --> 04
  return num < 10 ? `0${num}` : num;
}

function hourConvert(hour) {
  // 15 --> 3
  return (hour % 12) || 12;
}
</script>
<style>
.vuejs-countdown {
  padding: 0;
  margin: auto;
  text-align: center;
}
.vuejs-countdown li {
  display: inline-block;
  margin: 0 8px;
  text-align: center;
  position: relative;
}
.vuejs-countdown li p {
  margin: 0;
}
.vuejs-countdown li:after {
  content: ":";
  position: absolute;
  top: 0;
  right: -13px;
  font-size: 32px;
}
.vuejs-countdown li:first-of-type {
  margin-left: 0;
}
.vuejs-countdown li:last-of-type {
  margin-right: 0;
}
.vuejs-countdown li:last-of-type:after {
  content: "";
}
.vuejs-countdown .digit {
  font-size: 32px;
  font-weight: 600;
  line-height: 1.4;
  margin-bottom: 0;
}
.vuejs-countdown .text {
  text-transform: uppercase;
  margin-bottom: 0;
  font-size: 10px;
}
</style>
