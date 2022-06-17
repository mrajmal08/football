
<template>
<div>
      <div class="row py-1" v-if="draftData.league.draft_completed">
    <b-col>
        <b-alert show variant="info" class="p-3 m-0 text-center" >
          <div >
            <h2>Your draft is complete! <a title="View Roster" href="/team/roster">View your roster</a>.</h2>
          </div>
        </b-alert>
    </b-col>
  </div>
  <div class="row py-1" v-if="!draftData.league.draft_started">
    <b-col>
        <b-alert show variant="info" class="p-3 m-0 text-center" >
          <div v-if="loadingDetails">
            <h2>Loading Draft Details..</h2>
          </div>
          <div v-else-if="draftData.league.draft_date == null && commissioner">
            <h2>Your draft date has not been set yet. <a href="/settings#/league" title="League settings" target="_blank">Set your draft date now.</a></h2>
          </div>
          <div v-else-if="draftData.league.draft_completed">
            <h2>Your draft is complete! <a title="View Roster" href="/team/roster">View your roster</a>.</h2>
          </div>
          <div v-else-if="user_draft_date && !draftData.league.draft_completed && draft_date_onclock != null">
            <h2>Your draft is {{user_draft_date}}<span class="small">({{draft_date_onclock}})</span></h2>
          </div>
          <div v-else>
            <h2>Loading Draft Details..</h2>
          </div>
        </b-alert>
    </b-col>
  </div>

		<!--<b-row v-if="commissioner > 0">
			<b-col md="12" class="my-1 text-center" v-if="draft_completed == 0"> <b-btn @click="generateDraft(); " size="sm" variant="primary">Generate Draft Order</b-btn></b-col>
		</b-row>-->

		<!--<b-row v-model="deadline" class="my-1 align-items-center" >
			<div class="col-sm-4 countdown-div" v-if="show_timer">
				<countdown-component :curId="curId" :rounds="rounds" :date="deadline"></countdown-component>
				{{clock_team}} on the clock
			</div>
			<div class="">
				<league-draft-picks :week="week" team="all" :page="page"></league-draft-picks>
			</div>
		</b-row>-->

		<!-- Only show row if we want to show a timer or teams -->
		<b-row  v-if="draftData.league.draft_order_generated && !draftData.league.draft_completed">
			<b-col>
				<div class="card m-0">
					<div class="card-body p-0">
						<b-row>
							<div class="col-sm-2 countdown-div my-auto">
								<template v-if="draftData.league.draft_order_generated">
									<countdown-component />
								</template>
							</div>
							<b-col md="10" class="my-1" v-if="draftData.league.draft_order_generated && items.length > 0">
								<ul id="team-draft">
									<li v-for="item in items"> <!--v-bind:class="{'current-draft':(draftData.user_team_id == item.fantasy_team_id && rounds == item.round)}" -->
										<img :src="item.fantasy_team.logo_url != null ? item.fantasy_team.logo_url : 'https://cdn.head-fi.org/g/2283245_l.jpg'" style="border-radius: 50%;border: 2px solid #fff;width: 50px;height: 50px;" fluid /></br>
										<strong>{{ item.fantasy_team.name }}</strong>
										<div class="text-small">
											Rd {{ item.round }}: Pick {{ item.round_overall_pick }}<br/>
											(Overall {{ item.league_overall_pick }})
										</div>
									</li>
								</ul>
								<input type="hidden" :value="curUserId" id="curUserId">
							</b-col>
						</b-row>
					</div>
				</div>
			</b-col>
		</b-row>
	</div>
</template>

<script>

var moment=require('moment');
var momentDurationFormatSetup = require("moment-duration-format");
momentDurationFormatSetup(moment);

export default {
	props:{
		commissioner: { type: Boolean, required: true, default: false },
    },
    data () {
		return {
      loadingDetails: true,
		  curUserId:'',
      user_draft_date: false,
      draft_date_onclock: null,
      crowd_audio: "http://acmeff.test/audio/crowd.mp3",
      clock_audio: "http://acmeff.test/audio/ticktock.mp3",
      whistle_audio: "http://acmeff.test/audio/whistle.mp3",
		}
	},
  computed: {
    draftData() {
      return this.$store.state.leagueDraftData;
    },
    items() {
      function compare(a, b) {
        if (a.league_overall_pick < b.league_overall_pick)
          return -1;
        if (a.league_overall_pick > b.league_overall_pick)
          return 1;
        return 0;
      }

      // Filter all items by empty fantasy_player_id
      // Sort them by the overall_pick to get the next 12 in the correct order (regardless of if/when the data comes in from websocket)
      let items = []
      items = this.draftData.draftRoundData.filter( draftItem => {
        return draftItem.fantasy_player_id == null
      });
      items = items.sort(compare)
      return items.slice(0,12);
    }
  },

	watch: {
		draftData: function(newRequest, oldRequest) {
      // console.log(newRequest);
      this.loadingDetails = false;
      this.updateCurrentTime();

      // When draftData changes play the ding sound
      // console.log('old: ', oldRequest)
      // console.log('new: ', newRequest)

		},

    },
  created() {

    },

  mounted() {
    window.setInterval(() => {
      if(!this.draftData.league.draft_completed){
        //console.log('run');
        this.updateCurrentTime();
      }
    },1000);
  },

	methods: {
		updateCurrentTime() {
			var end = moment(new Date()).utc(); //todays date in utc
			var momentDraftDate = moment.utc(this.draftData.league.draft_date); // Draft date as utc
			var duration = moment.duration(momentDraftDate.diff(end));
			var secondsDuration = duration.asSeconds();
      //var tz = moment.tz.guess();
			//Prevent the message from showing unless we have a duration.
      //console.log(secondsDuration)

			if(secondsDuration > 1)
			{
				this.draft_date_onclock='Starts in '+ moment.duration(secondsDuration, "seconds").format("d [days], h [hours], m [minutes], s [seconds]", {
					useSignificantDigits: true,
					precision:0
				});
        this.user_draft_date = moment(momentDraftDate).tz(moment.tz.guess()).format('llll z'); //Preset https://devhints.io/moment
			} else {
        this.draft_date_onclock = null;
      }
		},
		playSound(sound) {
			if(sound) {
        var audio = new Audio(sound);
        audio.play();
      }
		},
	},
}


</script>


<style scoped>
  #team-draft {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
  }

  #team-draft li {
    float: left;
    display: inline-block;
    width: 7.5%;
    margin-right: 7.8px;
    background: #fff;
    min-height: 130px;
    box-shadow: 2px 2px 7px #ddd;
    position: relative;
    text-align: center;
  }

  #team-draft .current-draft{
    background-color:#007bff;
    color: white;
  }

  @keyframes zoominoutsinglefeatured {
    0% {
      transform: scale(1,1);
    }
    50% {
      transform: scale(1.2,1.2);
    }
    100% {
      transform: scale(1,1);
    }
  }

  #team-draft .current-draft img{
    animation: zoominoutsinglefeatured 3s infinite ;
  }

  .countdown-div {
    text-align: center;
  }

</style>
