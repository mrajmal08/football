<template>
  <div>
    <b-btn size="sm" variant="primary" v-if="player.details.team_max_reached && player_remove == 0" :disabled="true">Team Max Reached</b-btn>
    <b-btn v-if="player.details.max_reached && !player_remove" size="sm" variant="primary" :disabled="true" @click="addPlayer(); componentKey++;">{{player.fantasy_position}} Max Reached
    </b-btn>
    <b-btn @click="insertTransaction(1); componentKey++;" size="sm" variant="primary" v-if="player.details.allow_add && player.details.max_reached == 0 && player.details.remove != 1 && player_waiver_period_enabled!=1">Add</b-btn>
    <b-btn @click="insertTransaction(1); componentKey++;" size="sm" variant="primary" v-if="player.details.allow_flex_add && !player.details.team_max_reached && player.details.max_reached == 1 && player.details.remove != 1 && player_waiver_period_enabled!=1">Add Flex</b-btn>
    <b-btn @click="claimPlayer(); componentKey++;" size="sm" variant="primary" v-if="(player_max_reached != 1 && player_waiver_period_enabled==1 && player_claim_request=='' && player_owned_by=='' )||(player_selected_claim_player > 0 && player_waiver_period_enabled==1  && player_owned_by=='')  ">Claim</b-btn>
    <b-btn size="sm" variant="primary" v-if="player_waiver_period_enabled==1 && player_claim_request==1" :disabled="player_claim_request == 1">Claim Requested</b-btn>
    <b-btn @click="removeClaimPlayer(); componentKey++;" size="sm" variant="danger" v-if="player_claim_removed ==1">Remove Claim</b-btn>
    <b-btn size="sm" variant="primary" v-if="player.details.matches_team" :disabled="true">Not allowed. Will match another team.</b-btn>
    <!--    <b-btn @click="addPlayer(); componentKey++;" size="sm" variant="primary" v-if="player_curUserId != '' && player_user_id != player_curUserId &&  player_commissioner > 0 && player_show_draft_user == 1 && player_remove == 0" :disabled="player_added == 1">Draft for user</b-btn> -->
    <b-btn @click="insertTransaction(2); componentKey++;" size="sm" variant="danger" v-if="player.details.remove == 1 && player.details.cleam_request !=1">Remove</b-btn>
    <br />
    <br />
    <select class="form-control" @change="changeLocation($event)" v-if="player_claim_players_count && player_remove == 0 && player_waiver_period_enabled==1 && player_owned_by=='' && player_claim_removed !=1" v-model="player_selected_claim_player">
      <option value="0">Select a player to drop</option>
      <option v-for="option in claim_players" v-bind:value="option.id">{{ option.name }}</option>
    </select>
    <br />
    <!--<b-form-select size="sm"  v-if="player_max_reached == 1 && player_remove == 0 && player_waiver_period_enabled==1 && player_owned_by==''" v-model="player_selected_claim_player" :options="player_claim_players" class="mb-3"  />-->
  </div>
</template>
<style>
.progress {
  width: 100%;
  height: 31px;
  background: #808080;
  margin-top: -10px;
  position: relative;
  font-size: 0.75rem !important;
}

.info {
  position: absolute;
  top: 50%;
  left: 50%;
  height: 30%;
  width: 50%;
  margin: -15% 0 0 -25%;
  padding-top: 5px;
}

.bar {
  background: green;
  height: 30px;
  color: white;
}

.greenArea span {
  position: absolute;
  top: 5px;
  z-index: 2;
  color: #fff;
  text-align: center;
  width: 100%;
}

</style>
<script>
export default {
  props: {
    player: { required: false },
    // max_reached: { required: false },
    remove: { required: false },
    added: { required: false },
    not_allowed: { required: false },
    curUserId: { required: false },
    user_id: { required: false },
    commissioner: { required: false },
    show_draft_user: { required: false },
    is_def: { required: false },
    is_st: { required: false },
    player_id: { required: false },
    team_qb: { required: false },
    waiver_period_enabled: { required: false },
    claim_request: { required: false },
    claim_removed: { required: false },
    claim_players: { required: false },
    owned_by: { required: false },
    claim_players_count: { required: false },
    team_two_id: { required: false },
    selected_claim_player: { required: false }
  },
  data() {
    return {
      show_claim: 0,
      player_player_id: '',
      player_max_reached: this.player.details.max_reached,
      player_remove: this.player.details.remove,
      player_added: '',
      player_not_allowed: '',
      player_curUserId: '',
      player_user_id: '',
      player_commissioner: '',
      player_show_draft_user: '',
      player_is_def: '',
      player_is_st: '',
      player_player_id: '',

      player_team_qb: '',

      player_waiver_period_enabled: '',

      player_claim_request: '',
      player_claim_removed: '',

      player_owned_by: '',
      player_claim_players: '',
      player_claim_players_count: '',

      player_selected_claim_player: '',

      watched: '',
      experience: '',
      fantasy_draft_name: '',
      fantasy_position: '',
      photo_url: '',
      target: '',
      record: '',
      available: '',
      componentKey: 0,
      show: false,
      items: [],
      game_log: [],
      stats_items: [],
      current_tab: 1,
      player_injuries: [],

    }
  },
  watch: {
    showModal: function(newRequest, oldRequest) {
      //this.getPlayerDetail()

      this.show = newRequest
    },

    added(val, old) {

      this.player_added = val;
    },
    selected_claim_player(val, old) {
      this.player_selected_claim_player = val;
    },
    remove(val, old) {
      this.player_remove = val;
    },
    max_reached(val, old) {
      this.player_max_reached = val;
    },
    not_allowed(val, old) {
      this.player_not_allowed = val;
    },
    curUserId(val, old) {
      this.player_curUserId = val;
    },
    user_id(val, old) {
      this.player_user_id = val;
    },
    commissioner(val, old) {
      this.player_commissioner = val;
    },
    show_draft_user(val, old) {
      this.player_show_draft_user = val;
    },
    is_def(val, old) {
      this.player_is_def = val;
    },
    team_qb(val, old) {
      this.player_team_qb = val;
    },
    waiver_period_enabled(val, old) {
      this.player_waiver_period_enabled = val;
    },
    claim_request(val, old) {
      this.player_claim_request = val;
    },
    claim_removed(val, old) {
      this.player_claim_removed = val;
    },
    owned_by(val, old) {
      this.player_owned_by = val;
    },
    claim_players(val, old) {
      this.player_claim_players = val;
    },
    claim_players_count(val, old) {
      this.player_claim_players_count = val;
    }


  },



  methods: {

    onHidden(evt) {
      this.$emit('update:showModal', false)
    },
    change() {
      this.show_claim = 1;
    },
    changeLocation(event) {
      this.player_selected_claim_player = event.target.value;
    },
    getPlayerDetail() {

      axios.get('/player', {
          params: {
            player_id: this.player_id,
            is_st: this.is_st,
            is_def: this.is_def,
            team_qb: this.team_qb,
          }
        })
        .then((response) => {
          console.log(response);
          this.photo_url = response.data.photo_url;
          this.experience = response.data.experience;
          this.fantasy_position = response.data.fantasy_position;
          this.fantasy_draft_name = response.data.fantasy_draft_name;
          this.target = response.data.target;
          this.record = response.data.record;
          this.added = response.data.details.added;
          this.not_allowed = response.data.not_allowed;
          this.available = response.data.details.available;
          this.max_reached = response.data.details.max_reached;
          this.remove = response.data.details.remove;
          this.owned_by = response.data.details.owned_by;
          // this.is_def          =response.data.is_def;
          // this.is_st             =response.data.is_st;
          // this.team_qb           =response.data.team_qb;
          this.watched = response.data.watched;
          this.game_log = response.data.game_log;
          this.stats_items = response.data.game_stats;
          this.player_injuries = response.data.player_injuries;
          // this.player_claim_request        =response.data.claim_request;
          this.player_waiver_period_enabled = response.data.waiver_period_enabled;

        })
        .catch(error => {});

    },


    selectTab(selectedTab) {

      if (selectedTab == 1) {

        this.items = this.game_log;
        this.current_tab = 1;
      } else {
        this.items = this.stats_items;
        this.current_tab = 2;
      }


    },
    // onClose () {
    //   //this.popoverShow = false;
    //   this.$refs.popover.$emit('close')
    //   console.log('closed')
    // },

    watchPlayer() {

      axios.post('/players/player-transaction', {
          player_id: this.player_id,
          transaction_id: 4,
          is_def: this.is_def,
          is_st: this.is_st,
          team_qb: this.team_qb
        }, {
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
        })
        .then((response) => {
          this.watched = 1;
          this.$store.dispatch('showSnackBarSuccess', { message: response.data.message });
        })
        .catch(error => {});

    },
    insertTransaction(type) {
      axios.post('/players/player-transaction', {
          player_id: this.player_id,
          transaction_id: type,
        })
        .then((response) => {
          this.$emit('p-action');

          if (response.data.success) {
            this.$store.dispatch('showSnackBarSuccess', { message: response.data.message });
            this.available = 'No';
            // this.player_added = 1;

            this.player_remove = 1;
            // this.player_owned_by = response.data.owned_by;

          } else {
            this.$store.dispatch('showSnackBarFailure', { message: response.data.message });
          }


        })
        .catch(error => {});

    },
    claimPlayer() {
      axios.post('/players/player-transaction', {
          player_id: this.player_id,
          transaction_id: 5,
          claim_request: 1,
          conditional_drop: this.player_selected_claim_player,
          is_def: this.player_is_def,
          is_st: this.player_is_st,
          team_qb: this.player_team_qb,
          waiver_period_enabled: this.waiver_period_enabled
        }, {
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
        })
        .then((response) => {
          this.player_added = 1;
          this.player_claim_request = 1;
          this.player_claim_removed = 1;
          this.player_selected_claim_player = 0,
            this.available = 'No';
          //this.player_remove = 1;
          //this.player_owned_by = response.data.owned_by;
          this.$store.dispatch('showSnackBarSuccess', { message: response.data.message });


        })
        .catch(error => {});

    },
    unWatchPlayer() {
      axios.put('/players/unwatch', {
          player_id: this.player_id,
          is_def: this.is_def,
          is_st: this.is_st,
          team_qb: this.team_qb
        }, {
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
        })
        .then((response) => {
          this.watched = 0;

          this.$store.dispatch('showSnackBarSuccess', { message: response.data });
        })
        .catch(error => {});


    },
    removeClaimPlayer() {
      axios.post('/players/remove-claim-player', {
          player_id: this.player_id,
          is_def: this.is_def,
          is_st: this.is_st,
          team_qb: this.team_qb
        }, {
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
        })
        .then((response) => {
          this.player_claim_removed = 0;
          this.player_remove = 0;
          this.player_claim_request = '';
          this.player_added = 0;
          this.available = 'Yes';
          this.player_owned_by = '';

          if (response.data.status == 1) {


            this.$store.dispatch('showSnackBarSuccess', { message: response.data.message });

          } else {
            this.$store.dispatch('showSnackBarFailure', { message: response.data.message });
          }

        })
        .catch(error => {});

    },
    removePlayer() {
      axios.put('/players/remove', {
          player_id: this.player_id,
          is_def: this.is_def,
          is_st: this.is_st,
          team_qb: this.team_qb
        }, {
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
        })
        .then((response) => {
          this.player_remove = 0;
          this.player_added = 0;
          this.available = 'Yes';
          this.player_owned_by = '';

          if (response.data.status == 1) {

            if (team_two_id) {
              this.$store.dispatch('loadFantasyTeamData2', { team_id: this.team_one_id, team_id2: this.team_two_id, week: this.week, season: this.season, projection: 0 });

            }


            this.$store.dispatch('showSnackBarSuccess', { message: response.data.message });
          } else {
            this.$store.dispatch('showSnackBarFailure', { message: response.data.message });
          }

        })
        .catch(error => {});

    },
    conditionalRemovePlayer() {
      axios.put('/players/conditional_remove', {
          player_id: this.player_id,
          is_def: this.is_def,
          is_st: this.is_st,
          team_qb: this.team_qb
        }, {
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
        })
        .then((response) => {
          this.player_remove = 0;
          this.player_added = 0;
          this.available = 'Yes';
          this.player_owned_by = '';

          if (response.data.status == 1) {
            this.$store.dispatch('showSnackBarSuccess', { message: response.data.message });

          } else {
            this.$store.dispatch('showSnackBarFailure', { message: response.data.message });
          }

        })
        .catch(error => {});

    },
    addBenchPlayer() {
      axios.post('/players/bench-player', {
          player_id: this.player_id,
          is_def: this.is_def,
          is_st: this.is_st,
          team_qb: this.team_qb
        }, {
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
        })
        .then((response) => {

          this.player_added = 1;
          this.player_remove = 1;
          //this.player_owned_by = response.data.owned_by;

          if (response.data.already_added == 1) {
            this.$store.dispatch('showSnackBarSuccess', { message: response.data.message });

          } else {
            this.$store.dispatch('showSnackBarFailure', { message: response.data.message });
          }


        })
        .catch(error => {});
    },
    // addTQB(){
    //  axios.post('/players/tqb-player',{
    //    player_id: this.player_id,
    //    is_def: this.is_def,
    //    is_st: this.is_st,
    //    team_qb: this.team_qb

    //  },
    //  {
    //    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
    //  })
    //  .then((response)=>{

    //    this.player_added = 1;
    //    this.player_remove = 1;
    //    this.player_owned_by = response.data.owned_by;

    //    if(response.data.already_added==1){
    //    this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});

    //    }else{
    //    this.$store.dispatch('showSnackBarFailure',{message:response.data.message});
    //    }


    //  })
    //  .catch(error => {});
    // },
  }

}

</script>
