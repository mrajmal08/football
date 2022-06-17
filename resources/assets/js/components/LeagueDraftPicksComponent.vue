<template>
  <ul v-if="page == 'league-draft'" id="league-draft-pick" class="list-group">
    <player-detail-modal-component
      :player_id="player_id"
      :showModal="show_modal"
      @update:showModal="show_modal = $event"
    />

    <li
      v-for="item in roundDraftPicks"
      :key="item.fantasy_player_id"
      class="list-group-item"
    >
      <div @click="rowClicked(item.fantasy_player_id)">
        ({{ item.created_at }}) <b>{{ item.fantasy_team.name }} </b>-
        {{ item.fantasy_player.status }} : {{ item.fantasy_player.name }},
        {{ item.fantasy_player.team }},
        {{ item.fantasy_player.position }}
      </div>
    </li>
  </ul>

  <div v-else class="card">
    <h4 class="card-header">
      Draft Round Data
    </h4>
    <div class="card-body p-0">
      <div class="card-title">
        <b-form-select v-model="roundSelected">
          <option v-for="option in rounds" :key="option" :value="option">
            {{ getOrdinalNum(option) }}
          </option>
        </b-form-select>
      </div>
      <div id="league-draft-pick">
        <div
          v-for="(item, index) in roundDraftPicks"
          :key="index"
          class="draftpick-item"
          :class="{
            anim:
              item.league_overall_pick ==
              draftData.currentDraft.league_overall_pick - 1,
          }"
        >
          <div v-if="item.fantasy_player_id > 0">
            <player-draft-card :item="item" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    week: { required: true },
    team: { required: true },
    page: { required: true },
  },
  data() {
    return {
      show_modal: false,
      showPopup: false,
      leagueDraftList: [],
      leagueRoundDraftList: [],
      team_id: this.team,
      player_id: "",
      current_week: this.week,
      // showGlow: true,
      rounds: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
      roundSelected: 0,
    };
  },

  computed: {
    draftData() {
      return this.$store.state.leagueDraftData;
      // Or return store.getters.something
    },
    roundDraftPicks() {
      // If the draft is going on then show all picks in reverse order.
      //Catch the 0 index for all
      //         return (this.draftData.league.draft_completed) ? this.draftData.draftRoundData : this.draftData.draftRoundData.reverse()

      if (this.roundSelected < 1) {
        if (this.draftData.league.draft_completed)
          return this.draftData.draftRoundData;
        else
          return [
            ...this.$store.getters.leagueDraftData.draftRoundData,
          ].reverse();
        //return this.draftData.draftRoundData.reverse() //okay to ignore this: https://stackoverflow.com/questions/52458203/simple-vue-js-computed-properties-clarification
      }
      return this.draftData.draftRoundData.filter(
        (draftPick) => draftPick.round === this.roundSelected
      );
    },
    // show() {
    //   this.getLeaguePickTable();
    // },
  },
  watch: {
    team: function(newVal, oldVal) {
      this.team_id = newVal;
      // this.getLeaguePickTable();
      // setTimeout(
      //   function() {
      //     this.showGlow == true;
      //   }.bind(this),
      //   1000
      // );
    },
  },
  created() {
    //this.$store.dispatch("loadLeagueDraftPick");
    //this.$store.dispatch('loadLeagueRoundDraftPick');
  },

  methods: {
    getOrdinalNum(n) {
      if (n < 1) return "All Picks";
      let ordinal =
        n +
        (n > 0
          ? ["th", "st", "nd", "rd"][
              (n > 3 && n < 21) || n % 10 > 3 ? 0 : n % 10
            ]
          : "");
      return ordinal + " Round";
    },
    // getLeaguePickTable() {
    //   let draft_round_data = this.$store.state.leagueRoundDraftList;
    //   this.leagueRoundDraftList = draft_round_data;

    //   let draftdata = this.$store.state.leagueDraftList;
    //   let week_id = this.current_week;
    //   let teamid = this.team_id;
    //   var clonedPlayers = [];

    //   if (teamid == "all" && week_id == "all") {
    //     this.leagueDraftList = draftdata;
    //   } else if (teamid == "all" && week_id != "all") {
    //     draftdata.forEach(function(item) {
    //       if (item.week == week_id) {
    //         clonedPlayers.push(item);
    //       }
    //     });

    //     this.leagueDraftList = clonedPlayers;
    //   } else if (week_id == "all" && teamid != "all") {
    //     draftdata.forEach(function(item) {
    //       if (item.fantasy_team_id == teamid) {
    //         clonedPlayers.push(item);
    //       }
    //     });

    //     this.leagueDraftList = clonedPlayers;
    //   } else {
    //     draftdata.forEach(function(item) {
    //       if (item.fantasy_team_id == teamid && item.week == week_id) {
    //         clonedPlayers.push(item);
    //       }
    //     });

    //     this.leagueDraftList = clonedPlayers;
    //   }
    // },

    rowClicked(player_id) {
      this.player_id = player_id;
      this.showModal();
    },
    showModal() {
      //console.log('PlayersTableComponent show modal. player_id ='+this.player_id)
      this.show_modal = true;
    },
    onShow() {
      /* This is called just before the popover is shown */
      /* Reset our popover "form" variables */
    },
    onShown() {
      /* Called just after the popover has been shown */
      /* Transfer focus to the first input */
      this.focusRef(this.$refs.draftname);
    },
    onHidden() {
      /* Called just after the popover has finished hiding */
      /* Bring focus back to the button */
      this.focusRef(this.$refs.draftname);
    },
  },
};
</script>

<style scoped lang="scss">
.footer-pick {
  background-color: black;
  color: white;
}
.rowoverlay {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
  bottom: 0;
  right: 0;
  height: 100%;
}

.bg-gradient {
  background: rgb(0, 50, 97);
  background: linear-gradient(
    90deg,
    rgba(0, 50, 97, 1) 0%,
    rgba(255, 255, 255, 0.3617822128851541) 50%
  );
}

.draft-pick {
  overflow: hidden;
  font-size: 55px;
  transform: rotate(20deg);
  color: black;
  opacity: 0.2;
  position: relative;
  top: 10px;
  left: -2px;
  /*  &:before {
      content: "#";
      position: absolute;
      z-index: 1;
      font-size: 50px;
      letter-spacing: -0.05em;
      font-style: italic;
      color: black;
      opacity: 0.2;
      transform: rotate(-20deg);
      top: -10px;
    }*/
}
.card-img-left {
  width: auto;
  height: 100%;
}
.card-body {
  padding-bottom: 0;
}
@keyframes glow-draft-list-recent-pick {
  0% {
    background: #017d32;
  }
  15% {
    background: #01a340;
  }
  30% {
    background: #02bb4a;
  }
  50% {
    background: white;
  }
  70% {
    background: #02bb4a;
  }
  80% {
    background: #01a340;
  }
  90% {
    background: #017d32;
  }
  100% {
    background: white;
  }
}

@keyframes glowing {
  0% {
    box-shadow: 0 0 -10px #017d32;
  }
  25% {
    box-shadow: 0 0 -10px #01a340;
  }
  40% {
    box-shadow: 0 0 20px #02bb4a;
  }
  60% {
    box-shadow: 0 0 20px #2fcc6c;
  }
  75% {
    box-shadow: 0 0 -10px #a9d9bc;
  }
  90% {
    box-shadow: 0 0 -10px #white;
  }
  100% {
    box-shadow: 0 0 -10px #a9d9bc;
  }
}

.anim {
  animation: glowing 2s 3;
  -webkit-animation: glowing 2s 3; /* Safari and Chrome */
}
</style>
