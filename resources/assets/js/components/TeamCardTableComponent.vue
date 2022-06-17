<template>
  <div class="card">
    <h4 class="card-header">
      Rosters
    </h4>
    <div class="card-body p-0">
      <div class="card-title">
        <b-form-select v-model="selectedTeamId">
          <option v-for="option in teams" :key="option.id" :value="option.id">
            {{ option.name }}
          </option>
        </b-form-select>
      </div>
      <div id="league-draft-pick">
        <div
          v-for="(player, index) in roundDraftPicks"
          :key="index"
          class="draftpick-item"
          :class="{
            anim:
              player.league_overall_pick ==
              draftData.currentDraft.league_overall_pick - 1,
          }"
        >
          <player-draft-card :item="player" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    teams: {
      required: true,
      type: Array,
      default: () => {
        return [];
      },
    },
  },
  data() {
    return {
      selectedTeamId: 0,
    };
  },

  computed: {
    draftData() {
      return this.$store.state.leagueDraftData;
    },
    roundDraftPicks() {
      return this.draftData.draftRoundData.filter(
        (draftPick) => draftPick.fantasy_team_id === this.selectedTeamId
      );
    },
  },
  watch: {},
  // TODO 05-16-20 look into why this doesn't work. draft data is blank when logged in as a different user.
  mounted() {
    let match = this.teams.find(
        (team) => {
          // console.log('team is', team);
          // console.log('draftdata is', this.draftData);
          return team.id === this.draftData.user_team_id
        }
      )
    // console.log('match is', match)
    this.selectedTeamId = this.teams[0].id;
  },
  created() {},

  methods: {},
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
