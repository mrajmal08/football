<style>
#t th,
td {
  padding: 10px;

  text-align: center;
}
</style>
<template>
  <b-container fluid>
    <div class="alert alert-success" v-if="form.success > 0">Your team settings has been updated!</div>
    <div class="alert alert-danger" v-if="form.errors.length > 0">
      <span v-show="form.errors.length > 0" v-for="error in form.errors">{{ error }}</span>
    </div>

    <table id="t">
      <tbody>
        <tr>
          <td>TQB</td>
          <td width="100%">
            <v-select
              :options="tqb_player_options"
              label="name"
              id="tqb_player"
              @input="tqb_Selected"
              v-model="tqb_Selected_player"
            >
              <template slot="option" slot-scope="option">{{ option.name }}, {{ option.team }}</template>
            </v-select>
          </td>
        </tr>

        <tr>
          <td>RB</td>
          <td width="100%">
            <v-select
              :options="rb_player_options"
              label="name"
              id="rb_player"
              @input="rb_Selected"
              v-model="rb_Selected_player"
            >
              <template slot="option" slot-scope="option">{{ option.name }}, {{ option.team }}</template>
            </v-select>
          </td>
        </tr>

        <tr>
          <td>RB</td>
          <td width="100%">
            <v-select
              :options="rb2_player_options"
              label="name"
              id="rb_player"
              @input="rb2_Selected"
              v-model="rb_Selected_player2"
            >
              <template slot="option" slot-scope="option">{{ option.name }}, {{ option.team }}</template>
            </v-select>
          </td>
        </tr>

        <tr>
          <td>WR</td>
          <td width="100%">
            <v-select
              :options="wr_player_options"
              label="name"
              id="wr_player"
              @input="wr_Selected"
              v-model="wr_Selected_player"
            >
              <template slot="option" slot-scope="option">{{ option.name }}, {{ option.team }}</template>
            </v-select>
          </td>
        </tr>

        <tr>
          <td>WR</td>
          <td width="100%">
            <v-select
              :options="wr2_player_options"
              label="name"
              id="wr_player"
              @input="wr2_Selected"
              v-model="wr_Selected_player2"
            >
              <template slot="option" slot-scope="option">{{ option.name }}, {{ option.team }}</template>
            </v-select>
          </td>
        </tr>

        <tr>
          <td>TE</td>
          <td width="100%">
            <v-select
              :options="te_player_options"
              label="name"
              id="te_player"
              @input="te_Selected"
              v-model="te_Selected_player"
            >
              <template slot="option" slot-scope="option">{{ option.name }}, {{ option.team }}</template>
            </v-select>
          </td>
        </tr>

        <tr>
          <td>K</td>
          <td width="100%">
            <v-select
              :options="k_player_options"
              label="name"
              id="k_player"
              @input="k_Selected"
              v-model="k_Selected_player"
            >
              <template slot="option" slot-scope="option">{{ option.name }}, {{ option.team }}</template>
            </v-select>
          </td>
        </tr>

        <tr>
          <td>DEF</td>
          <td width="100%">
            <v-select
              :options="def_player_options"
              label="name"
              id="def_player"
              @input="def_Selected"
              v-model="def_Selected_player"
            >
              <template slot="option" slot-scope="option">{{ option.name }}, {{ option.team }}</template>
            </v-select>
          </td>
        </tr>

        <tr>
          <td>ST</td>
          <td width="100%">
            <v-select
              :options="st_player_options"
              label="name"
              id="st_player"
              @input="st_Selected"
              v-model="st_Selected_player"
            >
              <template slot="option" slot-scope="option">{{ option.name }}, {{ option.team }}</template>
            </v-select>
          </td>
        </tr>
      </tbody>
    </table>

    <b-row>
      <b-col sm="5"></b-col>
      <b-col sm="7">
        <button type="submit" class="btn btn-primary" @click.prevent="updateForm">Save Team</button>
      </b-col>
    </b-row>
  </b-container>
</template>


<script>
export default {
  props: {
    // fantasy_player: { required: false },
    team_id: { required: false },
    fantasy_transaction: { required: false }
  },
  data() {
    return {
      form: {
        name: "",
        errors: [],
        success: "",
        error: ""
      },
      rb_player_options: [],
      rb2_player_options: [],
      tqb_player_options: [],
      wr_player_options: [],
      wr2_player_options: [],
      te_player_options: [],
      k_player_options: [],
      def_player_options: [],
      st_player_options: [],
      st_player: "",
      def_player: "",
      k_player: "",
      te_player: "",
      wr_player: "",
      wr2_player: "",
      rb_player: "",
      rb2_player: "",
      tqb_player: "",
      players_id: [],
      tqb_Selected_player: "",
      rb_Selected_player: "",
      rb_Selected_player2: "",

      wr_Selected_player: "",
      wr_Selected_player2: "",

      te_Selected_player: "",
      k_Selected_player: "",
      def_Selected_player: "",
      st_Selected_player: "",
      tqb_select: "",
      tqb_players: "",
      rb_players: "",
      wr_players: "",
      te_players: "",
      k_players: "",
      def_players: "",
      st_players: "",
      fantasy_player: ""
    };
  },

  computed: {
    fanacy_value: {
      get() {
        return this.$store.getters.fantacyPLayer;
      },
      set(newValue) {
        this.$store.dispatch(
          "offlineFantasyDraftPlayerListAvailable",
          newValue
        );
      }
    }
  },

  watch: {
    fanacy_value: function(newRequest, oldRequest) {
      //	console.log(newRequest);
      this.fantasy_player = newRequest;

      this.update_fanacy_value();
    }
  },
  mounted() {
    this.fantasy_player=this.$store.getters.getFantasyPlayers(1);

    //console.log(this.fantasy_player);

    if (this.fantasy_transaction) {
      if (this.fantasy_transaction.TQB) {
        this.tqb_players = this.fantasy_transaction.TQB;
        this.tqb_Selected_player = this.tqb_players[0].name;
        this.players_id.push(this.tqb_players[0].fantasy_player_id);
      }
      if (this.fantasy_transaction.RB) {
        this.rb_players = this.fantasy_transaction.RB;
        this.rb_Selected_player = this.rb_players[0].name;
        this.players_id.push(this.rb_players[0].fantasy_player_id);

        if (isset(this.rb_players) && isset(this.rb_players[1])) {
          this.rb_Selected_player2 = this.rb_players[1].name;
          this.players_id.push(this.rb_players[1].fantasy_player_id);
        }
      }

      if (this.fantasy_transaction.WR) {
        this.wr_players = this.fantasy_transaction.WR;
        this.wr_Selected_player = this.wr_players[0].name;
        this.players_id.push(this.wr_players[0].fantasy_player_id);

        if (isset(this.wr_players[1])) {
          this.wr_Selected_player2 = this.wr_players[1].name;
          this.players_id.push(this.wr_players[1].fantasy_player_id);
        }
      }

      if (this.fantasy_transaction.TE) {
        this.te_players = this.fantasy_transaction.TE;
        this.te_Selected_player = this.te_players[0].name;

        this.players_id.push(this.te_players[0].fantasy_player_id);
      }

      if (this.fantasy_transaction.K) {
        this.k_players = this.fantasy_transaction.K;
        this.k_Selected_player = this.k_players[0].name;

        this.players_id.push(this.k_players[0].fantasy_player_id);
      }

      if (this.fantasy_transaction.DEF) {
        this.def_players = this.fantasy_transaction.DEF;
        this.def_Selected_player = this.def_players[0].name;
        this.players_id.push(this.def_players[0].fantasy_player_id);
      }

      if (this.fantasy_transaction.ST) {
        this.st_players = this.fantasy_transaction.ST;
        this.st_Selected_player = this.st_players[0].name;
        this.players_id.push(this.st_players[0].fantasy_player_id);
      }
      //console.log(this.players_id);
    }
    this.rb2_player_options = this.fantasy_player.RB;
    this.rb_player_options = this.fantasy_player.RB;
    this.tqb_player_options = this.fantasy_player.TQB;
    this.wr_player_options = this.fantasy_player.WR;
    this.wr2_player_options = this.fantasy_player.WR;
    this.te_player_options = this.fantasy_player.TE;
    this.k_player_options = this.fantasy_player.K;
    this.def_player_options = this.fantasy_player.DEF;
    this.st_player_options = this.fantasy_player.ST;
  },

  methods: {
    update_fanacy_value() {
      this.rb2_player_options = this.fantasy_player.RB;
      this.rb_player_options = this.fantasy_player.RB;
      this.tqb_player_options = this.fantasy_player.TQB;
      this.wr_player_options = this.fantasy_player.WR;
      this.wr2_player_options = this.fantasy_player.WR;
      this.te_player_options = this.fantasy_player.TE;
      this.k_player_options = this.fantasy_player.K;
      this.def_player_options = this.fantasy_player.DEF;
      this.st_player_options = this.fantasy_player.ST;
    },

    remove_rb_duplicates(value) {
      var removeArray = [];
      removeArray = [value];
      this.rb2_player_options = this.rb2_player_options.filter(function(obj) {
        return !this.has(obj.id);
      }, new Set(removeArray.map(obj => obj.id)));
    },
    remove_rb2_duplicates(value) {
      var removeArray2 = [];
      removeArray2 = [value];
      this.rb_player_options = this.rb_player_options.filter(function(obj) {
        return !this.has(obj.id);
      }, new Set(removeArray2.map(obj => obj.id)));
    },
    remove_wr_duplicates(value) {
      var remove_wr_Array = [];
      remove_wr_Array = [value];
      this.wr2_player_options = this.wr2_player_options.filter(function(obj) {
        return !this.has(obj.id);
      }, new Set(remove_wr_Array.map(obj => obj.id)));
    },
    remove_wr2_duplicates(value) {
      var remove_wr2_Array = [];
      remove_wr2_Array = [value];
      this.wr_player_options = this.wr_player_options.filter(function(obj) {
        return !this.has(obj.id);
      }, new Set(remove_wr2_Array.map(obj => obj.id)));
    },
    st_Selected(value) {
		if(value != null){
			this.st_player = value.id;
		}
    },
    def_Selected(value) {
		if(value != null){
			this.def_player = value.id;
		}
    },
    te_Selected(value) {
		if(value != null){
			this.te_player = value.id;
		}
    },
    k_Selected(value) {
		if(value != null){
			this.k_player = value.id;
		}
    },
    wr_Selected(value) {
		if(value != null){
			this.wr_player = value.id;
			this.remove_wr_duplicates(value);
		}
    },
    wr2_Selected(value) {
		if(value != null){
			this.wr2_player = value.id;
			this.remove_wr2_duplicates(value);
		}
    },
    rb_Selected(value) {
		if(value != null){
			this.rb_player = value.id;
			this.remove_rb_duplicates(value);
		}
    },
    rb2_Selected(value) {
		if(value != null){
			this.rb2_player = value.id;
			this.remove_rb2_duplicates(value);
		}
    },
    tqb_Selected(value) {
		if(value != null){
			this.tqb_player = value.id;
		}
    },

    updateForm() {
      this.players_id.push(this.st_player);
      this.players_id.push(this.def_player);
      this.players_id.push(this.k_player);
      this.players_id.push(this.te_player);
      this.players_id.push(this.wr_player);
      this.players_id.push(this.rb_player);
      this.players_id.push(this.tqb_player);
      this.players_id.push(this.wr2_player);
      this.players_id.push(this.rb2_player);
      //console.log(this.players_id);
      this.form.errors = [];

      axios
        .post(
          "/players/league-player-transaction",
          {
            players_id: this.players_id,
            team_id: this.team_id
          }
          // },
          // {
          //   headers: {
          //     "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
          //   }
          // }
        )
        .then(response => {
          this.players_id = [];
          if (response.data.status == "success") {
            this.$store.dispatch("offlineFantasyDraftPlayerListAvailable");

            this.form.errors = 0;
            this.form.success = 1;
            this.form.error = 0;
          } else {
            this.form.success = 0;
            this.form.error = 1;
            this.form.errors.push(response.data.message);
          }
        })
        .catch(error => {});
    }
  }
};
</script>
