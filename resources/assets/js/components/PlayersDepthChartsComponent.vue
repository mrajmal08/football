<template>
  <b-container fluid>
    <player-detail-modal-component :player_id="selected_player_id" :showModal="show_modal" :draftComplete="true" @update:showModal="show_modal = false" />
    <loading :active.sync="visible" :can-cancel="true"></loading>
    <div class="row">
      <div class="col-sm-12">
        <div class="bs-component">
          <div class="jumbotron">
            <h2>Depth Charts </h2>
            <b-row>
              <b-col cols="6">
                <ul class="list-group list-group-horizontal">
                  <li class="list-group-item">
                    <h4>Position</h4>
                  </li>
                  <li class="list-group-item">
                    <b-form-select v-model="selected_position" v-on:change="getSelectedPosition">
                      <option value="QB"> QB</option>
                      <option value="RB"> RB</option>
                      <option value="WR"> WR</option>
                      <option value="TE"> TE</option>
                      <option value="K"> K</option>
                    </b-form-select>
                  </li>
                </ul>
              </b-col>
              <b-col cols="6">
              </b-col>
            </b-row>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="starters"><span style="padding-left: 15px;"><b>NFC TEAMS</b></span> <span style="padding-left: 70px;"></span></div>
      <table id="__BVID__16" aria-busy="false" aria-colcount="8" class="table b-table table-bordered">
        <thead class="">
          <tr>
            <th class="">TEAM</th>
            <th class=""><span v-if="selected_position!='WR'">Starter</span><span v-else>WR1</span></th>
            <th v-if="selected_position=='RB' || selected_position=='QB'|| selected_position=='WR' || selected_position=='TE'  "><span v-if="selected_position!='WR'">Backup</span><span v-else>WR2</span></th>
            <th v-if="selected_position=='WR'">WR3</th>
            <th class="">Reservers</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(value, key) in items.NFC">
            <td>{{key}}</td>
            <td>
              <span v-if="value.starter" v-on:click="showModal(value.starter[0])" class="player-modal-link">{{ value.starter[0].name }}
                <span v-if='value.starter[0].current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span>
              </span>
            </td>
            <td v-if="selected_position=='RB' || selected_position=='QB' || selected_position=='WR' || selected_position=='TE' ">
              <span v-if="value.backup" v-on:click="showModal(value.backup[0])" class="player-modal-link">{{ value.backup[0].name }} <span v-if='value.backup[0].current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span></span>
            </td>
            <td v-if="selected_position=='WR'">
              <span v-if="value.reservers" v-on:click="showModal(value.reservers[0])" class="player-modal-link">{{ value.reservers[0].name }}<span v-if='value.reservers[0].current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span></span>
            </td>
            <td><span v-for="(value, key) in value.reservers">
                <span v-if="key != 0 && value.position=='WR'"  v-on:click="showModal(value)" class="player-modal-link">{{ value.name }} <span v-if='value.current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span> <br />
                </span>
                <span v-if="value.position != 'WR'" v-on:click="showModal(value)" class="player-modal-link">
                  {{ value.name }} <span v-if='value.current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span> <br />
                </span>
              </span>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="starters"><span style="padding-left: 15px;"><b>AFC TEAMS</b></span> <span style="padding-left: 70px;"></span></div>
      <table id="__BVID__16" aria-busy="false" aria-colcount="8" class="table b-table table-bordered">
        <thead class="">
          <tr>
            <th class="">TEAM</th>
            <th class=""><span v-if="selected_position!='WR'">Starter</span><span v-else>WR1</span></th>
            <th v-if="selected_position=='RB' || selected_position=='QB'|| selected_position=='WR' || selected_position=='TE'  "><span v-if="selected_position!='WR'">Backup</span><span v-else>WR2</span></th>
            <th v-if="selected_position=='WR'">WR3</th>
            <th class="">Reservers</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(value, key) in items.AFC">
            <td>{{key}}</td>
            <td>
              <span v-if="value.starter" v-on:click="showModal(value.starter[0])" class="player-modal-link">{{ value.starter[0].name }}
                <span v-if='value.starter[0].current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span>
              </span>
            </td>
            <td v-if="selected_position=='RB' || selected_position=='QB' || selected_position=='WR' || selected_position=='TE' ">
              <span v-if="value.backup" v-on:click="showModal(value.backup[0])" class="player-modal-link">{{ value.backup[0].name }} <span v-if='value.backup[0].current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span></span>
            </td>
            <td v-if="selected_position=='WR'">
              <span v-if="value.reservers" v-on:click="showModal(value.reservers[0])" class="player-modal-link">{{ value.reservers[0].name }}<span v-if='value.reservers[0].current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span></span>
            </td>
            <td><span v-for="(value, key) in value.reservers">
                <span v-if="key != 0 && value.position=='WR'"  v-on:click="showModal(value)" class="player-modal-link">{{ value.name }} <span v-if='value.current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span> <br />
                </span>
                <span v-if="value.position != 'WR'" v-on:click="showModal(value)" class="player-modal-link">
                  {{ value.name }} <span v-if='value.current_status!="Healthy"'> <i class="fas fa-plus-square"></i></span> <br />
                </span>
              </span>
            </td>
          </tr>
        </tbody>
      </table>
      <b-row>
        <div>
          <appadds-component></appadds-component>
        </div>
      </b-row>
    </div>
  </b-container>
</template>
<style>
.fa-plus-square {
  color: red;
}

.starters {
  font-size: 13px;
  background: #e2e4e6;
  height: 40px;
  padding-top: 5px;
}

</style>
<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {

  components: {
    Loading
  },
  data() {
    return {
      week: 1,
      selected_position: 'RB',
      visible: false,
      selected_player_id: '',
      show_modal: false,
      items: []
    }
  },
  methods: {
    showModal: function(player) {
      this.selected_player_id = player.fantasy_player.id;
      this.show_modal = true;
    },
    getSelectedPosition: function(position) {
      this.getPlayerTeam(position);
    },
    getPlayerTeam(position) {
      this.visible = true;
      axios.get('/players-depthchart', {
          params: { position: position }
        })
        .then((response) => {
          this.items = response.data;
          var self = this;
          self.visible = false;

        })
        .catch(error => {});
    }
  },
  created() {

    this.getPlayerTeam(this.selected_week);
  }
}

</script>
