<template>
  <b-card no-body class="overflow-hidden">
    <b-row no-gutters class="bg-gradient px-1 align-items-end">
      <!--           <b-col md="2" class="my-auto">
                    &nbsp;
                  </b-col>
                -->
      <b-col md="3" offset="0">
        <b-card-img
          v-if="item.fantasy_player_id > 0"
          :src="
            item.fantasy_player.player_photo_url
              ? item.fantasy_player.player_photo_url
              : 'https://cdn.head-fi.org/g/2283245_l.jpg'
          "
          alt="Image"
          class="rounded-0"
        />
      </b-col>
      <b-col md="9">
        <b-card-body class="p-1">
          <b-card-text>
            <strong v-if="item.fantasy_player_id > 0">{{
              item.fantasy_player.name
            }}</strong>
            <p v-if="item.fantasy_player_id > 0" class="m-0">
              {{ item.fantasy_player.team }},
              {{ item.fantasy_player.position }}
            </p>
            <p>
              <i>({{ item.fantasy_team.name }})</i>
            </p>
          </b-card-text>
        </b-card-body>
      </b-col>
    </b-row>
    <b-card-footer footer-class="text-center p-1 footer-pick">
      <span class="text-muted" style="font-size: 95%"
        >Rd {{ item.round }}, Pick {{ item.round_overall_pick }}, Overall
        {{ item.league_overall_pick }}</span
      >
    </b-card-footer>

    <!--             <b-row class="rowoverlay">
              <b-col
                md="6"
                class="coloverlay"
              >
                <h6 class="mb-0 draft-pick">{{ item.league_overall_pick }}</h6>
              </b-col>
            </b-row> -->
  </b-card>
</template>

<script>
export default {
  props: {
    item: {
      required: true,
      type: Object,
      default: () => {
        return {};
      },
    },
  },
    data() {
    return {

    };
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
