<template>
  <div class="holy-grail">
    <header>
      <team-draft-card-component
        :commissioner="commissioner"
      />
    </header>

    <div class="holy-grail-body">
      <section class="holy-grail-content">
        <players-table-component
          :draft-complete=" draftData.league.draft_completed == 1 ? true : false"
          :is-commissioner="commissioner"
          :user-id="userId"
          :league="league"
        />
      </section>

      <div class="holy-grail-sidebar-1 hg-sidebar overflow-auto p-1">
        <team-card-table-component :teams="teams" />
      </div>

      <div class="holy-grail-sidebar-2 hg-sidebar overflow-auto">
        <league-draft-picks week="week" team="all" page="team-draft" />
      </div>
    </div>

<!--     <footer>
      <p>Footer</p>
    </footer> -->
  </div>
</template>

<script>
export default {
  props: {
    week: { type: Number, default: 1, required: true },
    commissioner: { type: Boolean, default: false, required: true },
    league: { type: Object, default: () => {}, required: true },
    teams: { type: Array, default: () => [], required: true },
    userId: { type: Number, default: 0, required: true },
    draftDate: {type: String, deafult: "", required: true}
    // team: {},
    // page: {}
  },
  data() {
    return {};
  },

  computed: {
    draftData() {
      return this.$store.state.leagueDraftData;
    },
    // currentDraftTeam() {
    //   if(this.draftData.currentDraft.fantasy_team)
    //     return this.draftData.currentDraft.fantasy_team.user_id;
    // }
  },

  watch: {
    // currentDraftTeam: function(newRequest, oldRequest) {
    //   console.log('currentDraftTeam new: ', newRequest)
    // },
    draftData: function(newRequest, oldRequest) {
      // console.log('newRequest: ', newRequest);
      // console.log('COMPARE DATA')
      // console.log('current id: ', newRequest.currentDraft.fantasy_team_id)
      // console.log('userID: ', this.userId)
      // if(newRequest.currentDraft.fantasy_team_id == this.userId && newRequest.draftStarted){
      //   console.log('user on clock. play the sound.')
      //   this.playSound(newRequest.on_clock_audio)
      // }
      // if(newRequest.currentDraft.league_overall_pick == 1 && newRequest.draftStarted){
      //   console.log('Draft Started Play crowd');
      //   this.playSound(newRequest.draft_start_audio)
      // }

      //if(newRequest.)
      // this.loadingDetails = false;
      // this.updateCurrentTime();

      // When draftData changes play the ding sound
      // console.log('old: ', oldRequest)
      // console.log('new: ', newRequest)
      // if(!oldRequest.draft_started && newRequest.draft_started){
      //   this.playSound(audio);
      // }
    }
  },

  mounted() {
    // console.log("Draft league " + this.league.id);

    // Listen for any websocket events

    // Draft Data changes (i.e. Draft date/time and events like draft orders generated)
    Echo.private("league." + this.league.id).listen(
      ".league.leagueOrDraftDataChanged",
      (e) => {
        // console.log("e.leagueOrDraftDataChanged: ", e);
        // Update the draft data via vuex
        // This triggers down for all components
        this.updateLeagueData(e.league);
      }
    );

    // Specific Live Draft Picks
    Echo.private("league." + this.league.id).listen(
      ".league.draftPick",
      (e) => {
        // console.log("e.draftOrder: ", e.draftOrder);
        // Update the draft data via vuex
        // This triggers down for all components
        this.updateLeagueDraftData(e.draftOrder);
      }
    );
  },
  created() {
    // console.log('created');
    this.loadLeagueDraftData();
  },
  methods: {
    // playSound (sound) {
    //   if(sound) {
    //     console.log('play sound')
    //     var audio = new Audio(sound);
    //     audio.play();
    //   }
    // },
    updateLeagueDraftData(updatedData) {
      // console.log("called: updateLeagueDraftData");
      this.$store
        .dispatch("updateLeagueDraftData", {
          updatedItem: updatedData,
        })
        .then(() => {
          //do something?
          //console.log('Dispatched the update.')
        });
    },
    updateLeagueData(updatedData) {
      //console.log("called: updateLeagueData");
      this.$store
        .dispatch("updateLeagueData", {
          data: updatedData,
        })
        .then(() => {
          //do something?
          //console.log('Dispatched the update.')
        });
    },
    loadLeagueDraftData() {
      this.$store.dispatch("loadLeagueDraftData");
    },
  },
};
</script>

<style scoped>
* {
  box-sizing: border-box;
}
html,
body {
  margin: 0;
  padding: 0;
  /*  font-family: sans-serif;
  font-size: 1.1em;
  text-align: center;
  color: #fff;*/
}
.holy-grail header,
.holy-grail footer,
.hg-sidebar,
.holy-grail-content {
  padding: 3px;
}
/*.holy-grail header,*/
.holy-grail footer {
  background: #fed0d1;
  position: fixed;
  bottom: 0;
  width: 100%;
}
.hg-sidebar {
  /*background: #f34a4e;*/
}
.holy-grail-content {
  color: #777;
}

/**
       * Flex things:
       * — Mobile first
       * — Responsive
       */
.holy-grail {
}
.holy-grail,
.holy-grail-body {
  display: flex;
  flex: 1 1 auto;
  flex-direction: column;
  max-height: calc(100vh - 155px);
}
.holy-grail-content {
  flex-grow: 0;
}
@media (min-width: 768px) {
  .holy-grail-sidebar-1 {
    order: -1;
  }
  .holy-grail-body {
    flex-direction: row;
    /*flex: 0;*/
  }
  .holy-grail-content {
    flex-shrink: 0;
    /*max-width: 300px*/
    flex-grow: 12;
    width: 600px;
  }
  .hg-sidebar {
    flex-grow: 1;
    width: 180px;
  }
}

nav.navbar-spark {
  display: none;
}
</style>
