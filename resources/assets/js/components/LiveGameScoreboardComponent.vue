<template>
  <b-container>
<!--     <div>
      <b-dropdown
        id="ddown1"
        text="Select Week"
        class="m-md-2"
        @click="changeItem"
      >
        <b-dropdown-item
          v-for="index in league_setting_week"
          :key="index"
          :value="index"
          @click="changeItem(index)"
        >
          {{ index }}
        </b-dropdown-item>
      </b-dropdown>
       <span> Week {{ week }} </span>
    </div> -->
    <b-row>
      <b-col md="12">
        <div>
          <league-scoreboard-component
            :week="week"
            :season_type="season_type"
            :season="season"
          />
        </div>
      </b-col>

      <b-col md="12">
        <div class="score-header">
          <div class="pull-left col-md-5">
            <div>
              <div class="pull-left">
                <div class="pull-left team-photo">
                  <b-img
                    class="spark-nav-profile-photo"
                    rounded="circle"
                    :src="items.teamOneLogo != null ? items.teamOneLogo : 'https://cdn.head-fi.org/g/2283245_l.jpg'"
                  />
                </div>
                <div class="pull-right">
                  <span><b>{{ items.teamOneName }}</b></span><br>
                  <span>{{ items.teamOneManager }}</span><br>
                  <span>{{ items.teamOneRecord }}</span>
                </div>
              </div>
              <div class="pull-right">
                <p class="current-score"><b>{{ teamOneTotal }}</b></p>
                <p class="predicted-score">Proj: {{ teamOneExpectedTotal }}</p>
              </div>
            </div>
          </div>

          <div class="pull-left col-md-2">
            <span class="middle-text">{{ teamOneTotalPlayed}} Played {{ teamTwoTotalPlayed }}</span>
            <span class="middle-text">{{ teamOneTotalNotPlayed }} Yet to Play {{ teamTwoTotalNotPlayed }}</span>
            <span class="middle-text last">{{ teamOneMinutesRemaining }} PMR {{ teamTwoMinutesRemaining }}</span>
          </div>

          <div class="pull-left col-md-5">
            <div>
              <div class="pull-left">
                <p class="current-score"><b>{{ teamTwoTotal }}</b></p>
                <p class="predicted-score">Proj: {{ teamTwoExpectedTotal }}</p>
              </div>
              <div class="pull-left col-md-7 team-two-det">
                <span><b>{{ items.teamTwoName }}</b></span><br>
                <span>{{ items.teamTwoManager }}</span><br>
                <span>{{ items.teamTwoRecord }}</span>
              </div>
              <div class="pull-right team-photo">
                <b-img
                  class="spark-nav-profile-photo"
                  rounded="circle"
                  :src="items.teamTwoLogo != null ? items.teamTwoLogo : 'https://cdn.head-fi.org/g/2283245_l.jpg'"
                />
              </div>
            </div>
          </div>
        </div>
      </b-col>

      <b-col md="12">
        <div class="starters">
          <span style="padding-left:15px"><b>STARTERS</b></span>
          <span style="padding-left:70px"><!-- P: PLAYING YTP: YET TO PLAY PMR: PLAYER MINUTES REMAINING PROJ: PROJECTION - PROJECTIONS UPDATE LIVE BASED ON PLAYER'S PERFORMANCE --></span>
        </div>
      </b-col>
      <b-col
        v-if="!loading"
        md="12"
      >
        <live-team-score-component
          :isPlayer="false"
          :team_one_id="items.teamOneId"
          :team_two_id="items.teamTwoId"
          :week="week"
          :season_type="season_type"
          @childToParentTeamOneTotal="onChildTeamoneTotal"
          :season="season"
          @teamOneTotalPlayed="onChildTeamOnePlayed"
          @teamTwoTotalPlayed="onChildTeamTwoPlayed"
          @teamOneTotalNotPlayed="onChildTeamOneNotPlayed"
          @teamTwoTotalNotPlayed="onChildTeamTwoNotPlayed"
          @teamOneTotalMinutesRemaining="onChildTeamOneMinutesRemaining"
          @teamTwoTotalMinutesRemaining="onChildTeamTwoMinutesRemaining"
          @childToParentTeamTwoTotal="onChildTeamTwoTotal"
          @childToParentTeamOneExpectedTotal="onChildTeamOneExpectedTotal"
          @childToParentTeamTwoExpectedTotal="onChildTeamTwoExpectedTotal"
        />
      </b-col>
      <b-col md="12">
				<div class="starters" style="margin-top: 30px;">
					<span style="padding-left:15px"><b>BENCH</b></span>
				</div>
				<live-team-bench-component
					:isPlayer="false"
					:team_one_id="items.teamOneId"
					:team_two_id="items.teamTwoId"
					:week="week"
					:season="season"></live-team-bench-component>
			</b-col>
    </b-row>
  </b-container>
</template>



<script>
import LiveTeamScoreComponent from "./LiveTeamScoreComponent.vue";
export default {
	components: { LiveTeamScoreComponent},
	props:{
    week: { type: Number, required: true },
	  league_setting_week: { type: Number, required: true },
    season_type: { type: String, required: true },
	  game: { type: String, required: true },
	  season: { type: Number, required: true }
    },
	data () {
		return {
			items: [],
			loading: false,
			teamOneTotal:0,
			teamTwoTotal: 0,
			teamOneExpectedTotal:0,
			teamTwoExpectedTotal:0,
      teamOneTotalPlayed: 0,
      teamTwoTotalPlayed: 0,
      teamOneTotalNotPlayed: 0,
      teamTwoTotalNotPlayed: 0,
      teamOneMinutesRemaining: 0,
      teamTwoMinutesRemaining: 0
		}
	},
	created(){
		this.getScoreboardHeader();
      this.$store.dispatch("getSystemSettings", {});
	},
	methods:{
		getScoreboardHeader(){
			this.loading = true;
			//TOOD: Update to add season to params
			axios.get('/scores/get-live-scoreboard',{
				 params: {
					week: this.week,
					season_type: this.season_type,
					game: this.game,
				  }
			})
			.then((response)=>{
				this.items 	= response.data;
				this.loading = false;
			})
			.catch(error => {});
		},
		onChildTeamoneTotal (value) {
			this.teamOneTotal = value
		},
		onChildTeamTwoTotal (value) {
			this.teamTwoTotal = value
		},
        onChildTeamOnePlayed( value ) {
		  this.teamOneTotalPlayed = value
        },
        onChildTeamTwoPlayed( value ) {
          this.teamTwoTotalPlayed = value
        },
        onChildTeamOneNotPlayed( value ) {
          this.teamOneTotalNotPlayed = value
        },
        onChildTeamTwoNotPlayed( value ) {
          this.teamTwoTotalNotPlayed = value
        },
		onChildTeamOneExpectedTotal (value) {
            //console.log('onChildTeamOneExpectedTotal', value)
			this.teamOneExpectedTotal = value.toFixed(2)
		},
        onChildTeamOneMinutesRemaining( value ) {
          //console.log(value);
          this.teamOneMinutesRemaining = parseInt(value)
        },
        onChildTeamTwoMinutesRemaining( value ) {
          this.teamTwoMinutesRemaining = parseInt(value)
        },
		onChildTeamTwoExpectedTotal (value) {
			this.teamTwoExpectedTotal = value.toFixed(2)
		},
		changeItem: function(week) {
			window.location.href = '/scores/fantasy-games/week/'+week+'/season_type/'+this.season_type+'/season/'+this.season;
		},
	}
}
</script>
