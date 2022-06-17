<template>
  <div>
    <snackbar />
    <div class="card">
      <h4 class="card-header">
        Players
      </h4>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-lg-6">
            <b-form-group
              id="fieldset-horizontal"
              label-cols-sm="4"
              label="Position"
              label-for="position-options"
            >
              <b-button-group id="position-options" class="py-2">
                <b-button
                  :class="{
                    notactive: selectedPosition != null,
                    active: selectedPosition == null,
                  }"
                  @click="setPositionFilter(null)"
                >
                  ALL
                </b-button>
                <b-button
                  :class="{
                    notactive: selectedPosition != 'TQB',
                    active: selectedPosition == 'TQB',
                  }"
                  @click="setPositionFilter('TQB')"
                >
                  TQB
                </b-button>
                <b-button
                  :class="{
                    notactive: selectedPosition != 'RB',
                    active: selectedPosition == 'RB',
                  }"
                  @click="setPositionFilter('RB')"
                >
                  RB
                </b-button>
                <b-button
                  :class="{
                    notactive: selectedPosition != 'WR',
                    active: selectedPosition == 'WR',
                  }"
                  @click="setPositionFilter('WR')"
                >
                  WR
                </b-button>
                <b-button
                  :class="{
                    notactive: selectedPosition != 'TE',
                    active: selectedPosition == 'TE',
                  }"
                  @click="setPositionFilter('TE')"
                >
                  TE
                </b-button>
                <b-button
                  :class="{
                    notactive: selectedPosition != 'K',
                    active: selectedPosition == 'K',
                  }"
                  @click="setPositionFilter('K')"
                >
                  K
                </b-button>
                <b-button
                  :class="{
                    notactive: selectedPosition != 'DEF',
                    active: selectedPosition == 'DEF',
                  }"
                  @click="setPositionFilter('DEF')"
                >
                  D
                </b-button>
                <b-button
                  :class="{
                    notactive: selectedPosition != 'ST',
                    active: selectedPosition == 'ST',
                  }"
                  @click="setPositionFilter('ST')"
                >
                  ST
                </b-button>
              </b-button-group>
            </b-form-group>
          </div>
          <div class="col-12 col-lg-4 text-left">
            <b-form-group
              label="Filter"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="sm"
              label-for="filterInput"
              class="mb-0"
            >
              <b-input-group size="sm" >
                <b-form-input
                  id="filterInput"
                  v-model="searchFilter"
                  type="search"
                  placeholder="Search"
                  debounce="500"
                />
                <b-input-group-append>
                  <b-button
                    :disabled="!searchFilter"
                    @click="searchFilter = ''"
                  >
                    Clear
                  </b-button>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col">
            <b-form inline>
              <label class="mr-sm-2" for="inline-form-custom-select-pref"
                ><h6>Stats Season:</h6></label
              >
              <b-form-select
                v-model="season"
                class="mb-2 mr-sm-2 mb-sm-0"
                @change="setSeason"
              >
                <option
                  v-for="aSeason in seasons"
                  :key="aSeason"
                  :value="aSeason"
                >
                  {{ aSeason }}
                </option>
              </b-form-select>
              <b-form-select
                v-model="seasonType"
                class="mb-2 mr-sm-2 mb-sm-0"
                @change="setSeasonType"
              >
                <option
                  v-for="(seasonTypeItem, index) in seasonTypes"
                  :key="index"
                  :value="seasonTypeItem.type"
                >
                  {{ seasonTypeItem.label }}
                </option>
              </b-form-select>
              <!-- <b-form-group id="input-group-4 ">
                  <b-form-checkbox-group  id="checkboxes-4" class="mb-2 mr-sm-2 mb-sm-0">

                  <b-form-checkbox value="that">Show my team</b-form-checkbox>
                    </b-form-checkbox-group>
                  </b-form-group> -->
            </b-form>
          </div>
          <div class="col">
            <b-form inline>
              <label class="mr-sm-2" for="inline-form-custom-select-pref"
              ><h6>NFL Team:</h6></label
              >
              <b-form-select
                      v-model="selectedTeam"
                      class="mb-2 mr-sm-2 mb-sm-0"
                      @change="teamChange"
              >
                <option
                        v-for="team in nflTeams"
                        :key="team"
                        :value="team"
                >
                  {{ team }}
                </option>
              </b-form-select>
              <!-- <b-form-group id="input-group-4 ">
                  <b-form-checkbox-group  id="checkboxes-4" class="mb-2 mr-sm-2 mb-sm-0">

                  <b-form-checkbox value="that">Show my team</b-form-checkbox>
                    </b-form-checkbox-group>
                  </b-form-group> -->
            </b-form>
          </div>
        </div>
        <div v-if="isCommissioner && !draftComplete" class="row">
          <div class="col">
            <label>Enable Commissioner Mode</label>
            <b-form-checkbox
              v-model="enableCommissionerMode"
              inline
              name="check-button"
              switch
              size="lg"
              button-variant="success"
            />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <b-tabs id="player_tabs" pills content-class="">
              <!-- STATS TAB AND TABLE -->
              <b-tab title="STATS">
                <div class="col-12 p-0">
                  <b-table
                    striped
                    id="stats-table"
                    ref="stats-table"
                    small
                    sticky-header
                    hover
                    sort-icon-left
                    :busy="isLoading"
                    show-empty
                    responsive="false"
                    :items="filteredPlayers"
                    :fields="fields"
                    :current-page="currentPage"
                    :filterIncludedFields="filterOn"
                    :per-page="perPage"
                    :filter="filter"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    @filtered="onFiltered"
                    @row-clicked="rowClicked"
                  >
                  <template slot="thead-top" slot-scope="data">
                    <tr v-if="selectedPosition == 'TQB'" >
                      <th colspan="4" >&nbsp;</th>
                      <th colspan="5" class="thead-top-style"><div>Passing</div></th>
                      <th colspan="5" class="thead-top-style"><div>Rushing</div></th>
                      <th colspan="3" class="thead-top-style"><div>FPTS</div></th>
                    </tr>
                    <tr v-else-if="['K'].includes(selectedPosition)">
                      <th colspan="4" >&nbsp;</th>
                      <th colspan="3" class="thead-top-style"><div>Total</div></th>
                      <th colspan="1" class="thead-top-style"><div>1-19</div></th>
                      <th colspan="1" class="thead-top-style"><div>20-29</div></th>
                      <th colspan="1" class="thead-top-style"><div>30-39</div></th>
                      <th colspan="1" class="thead-top-style"><div>40-49</div></th>
                      <th colspan="1" class="thead-top-style"><div>50+</div></th>
                      <th colspan="2" class="thead-top-style"><div>XP</div></th>
                      <th colspan="3" class="thead-top-style"><div>FPTS</div></th>
                    </tr>
                    <tr v-else-if="selectedPosition == 'DEF'" >
                      <th colspan="4" >&nbsp;</th>
                      <th colspan="2" class="thead-top-style"><div>Turnovers</div></th>
                      <th colspan="2" class="thead-top-style"><div>Scoring</div></th>
                      <th colspan="2" class="thead-top-style"><div>Yards Against</div></th>
                      <th colspan="2" class="thead-top-style"><div>Points Against</div></th>
                      <th colspan="3" class="thead-top-style"><div>FPTS</div></th>
                    </tr>
                    <tr v-else-if="selectedPosition == 'ST'" >
                      <th colspan="4" >&nbsp;</th>
                      <th colspan="3" class="thead-top-style"><div>Kick Off</div></th>
                      <th colspan="3" class="thead-top-style"><div>Punt</div></th>
                      <!-- <th colspan="2" class="thead-top-style"><div>Blocks</div></th> -->
                      <th colspan="3" class="thead-top-style"><div>FPTS</div></th>
                    </tr>
                    <tr v-else>
                      <th colspan="4" >&nbsp;</th>
                      <th colspan="4" class="thead-top-style"><div>Rushing</div></th>
                      <th colspan="5" class="thead-top-style"><div>Receiving</div></th>
                      <th colspan="1" class="thead-top-style"><div>Fumbles</div></th>
                      <th colspan="3" class="thead-top-style"><div>FPTS</div></th>
                    </tr>
                  </template>
                    <template v-slot:table-busy>
                      <div class="text-center text-danger my-2">
                        <b-spinner class="align-middle" />
                        <strong>Loading...</strong>
                      </div>
                    </template>
                    <template v-slot:cell(action)="data">
                      <!-- Data about who owns player -->
                      <span v-if="data.item.fantasy_team_owned_by.id">
                        <strong>{{
                          data.item.fantasy_team_owned_by.owner_name
                        }}</strong>
                      </span>

                      <!-- Show Buttons -->
                      <span v-if="showButtons">

                        <!-- BEGIN Draft Specific Buttons -->

                        <!-- BEGIN Logged In User: -->
                        <span v-if="!enableCommissionerMode">

                          <!-- Data about Max Reached -->
                          <span
                            v-if="
                              userFantasyTeam.position[data.item.position]
                                .maxReached && !data.item.fantasy_team_owned_by.id
                            "
                          >
                            <strong>Max Reached</strong>
                          </span>

                          <!-- Logged in User Draft ("Add") Available Player -->
                          <b-button
                            v-if="showAddButton(data.item)"
                            size="small"
                            :disabled="checkDisabled(data.item)"
                            @click="playerTransaction(data.item.id, 1)"
                            ><b-icon
                              icon="person-plus"
                              aria-hidden="true"
                            ></b-icon> Add</b-button>

                          <!-- <b-button
                                v-if="!data.item.fantasy_team_owned_by"
                                variant="outline-primary"
                                @click="playerTransaction(data.item.id,4)"
                              >Watch</b-button> -->
                        </span>
                        <!-- END Logged In User -->

                        <!-- BEGIN Commissioner Draft Specific Buttons -->
                          <span
                            v-if="
                              enableCommissionerMode &&
                                draftData.currentDraft.fantasy_team_id !=
                                  draftData.user_team_id">

                              <!-- Commissioner Draft Player for On Clock User -->
                                <b-button
                                  v-if="
                                    !data.item.fantasy_team_owned_by.id && commissionerCurrentDraftPlayerCountsLoaded &&
                                      !commissionerCurrentDraftPlayerCounts.position[data.item.position]
                                        .maxReached
                                  "
                                  variant="warning"
                                  @click="
                                    playerTransaction(
                                      data.item.id,
                                      1,
                                      draftData.currentDraft.fantasy_team_id
                                    )
                                  "
                                  ><b-icon
                                    icon="person-plus"
                                    aria-hidden="true"
                                  ></b-icon
                                  >{{
                                    draftData.currentDraft.fantasy_team.sys_short_name
                                  }}
                                </b-button>

                                <!-- Data about Max Reached -->
                                <span
                                  v-if="commissionerCurrentDraftPlayerCountsLoaded &&
                                    commissionerCurrentDraftPlayerCounts.position[data.item.position].maxReached && !data.item.fantasy_team_owned_by.id
                                  "
                                >
                                  <strong>Max Reached</strong>
                                </span>

                          </span>
                        <!-- END Draft Specific Buttons -->

                        <!-- BEGIN REGULAR GAME BUTTONS
                            Logic for when a draft is completed (i.e. regular weekly gameplay) -->

                        <!-- If the player is owned by someone -->
                        <template
                          v-if="
                            data.item.fantasy_team_owned_by.id &&
                              draftData.league.draft_completed">

                          <!-- Logged In User: Drop From team -->
                          <b-button
                            v-if="showDropBenchButton(data.item)"
                            @click="playerTransaction(data.item.id, 2)"
                            ><b-icon
                              icon="person-dash"
                              aria-hidden="true"
                            ></b-icon
                            >Drop</b-button>

                          <!-- Logged In User: Move to Bench -->
                          <b-button
                            v-if="showBenchButton(data.item)"
                            variant="outline-primary"
                            @click="playerTransaction(data.item.id, 8)">Bench</b-button>

                          <!-- Logged In User: Move to Starter -->
                          <b-button
                            v-if="showMoveToStarterButton(data.item)"
                            variant="outline-primary"
                            @click="playerTransaction(data.item.id, 9)"
                            >Move to Starter</b-button>
                        </template>
                      </span>

                      <!-- END Logged In User Specific Actions -->

                    </template>
                    <template slot="actions" slot-scope="row">
                      <b-button size="sm" @click="row.toggleDetails">
                        {{ row.detailsShowing ? "Hide" : "Show" }} Details
                      </b-button>
                    </template>
                    <template v-slot:cell(name_pos_team)="data">
                      {{ data.item.name }} <br /><span class="text-small"
                        >{{ data.item.position }} | {{ data.item.team }}</span
                      >
                      <font-awesome-icon
                        v-if="data.item.player.injury_status != null"
                        :icon="['fas', 'plus-circle']"
                        :style="{ color: 'red' }"
                      />
                      <font-awesome-icon
                        v-if="data.item.player.status == 'Suspended'"
                        :icon="['fab', 'stripe-s']"
                        :style="{ color: 'red' }"
                      />
                      <font-awesome-icon
                        v-if="data.item.fantasy_player_news.length > 0"
                        :icon="['fas', 'sticky-note']"
                        :style="{ color: '#FDB026' }"
                      />
                    </template>
                  </b-table>
                  <b-row>
                    <b-col md="6" class="my-1">
                      <b-pagination
                        v-model="currentPage"
                        :total-rows="totalRows"
                        :per-page="perPage"
                        class="my-0"
                      />
                    </b-col>
                  </b-row>
                </div>
              </b-tab>
            </b-tabs>
          </div>
        </div>
      </div>
    </div>
    <template>
      <player-detail-modal-component
        :player_id="player_id"
        :playerData="playerData"
        :commissioner="isCommissioner"
        :user-id="userId"
        :draftComplete="draftComplete"
        :showModal="show_modal"
        :showButtons="showButtons"
        :enableCommissionerMode="enableCommissionerMode"
        @update:showModal="show_modal = $event"
      />
    </template>
    <div class="container p-0 player-tabs" />
    <b-row>
      <div>
        <appadds-component />
      </div>
    </b-row>
  </div>
</template>
<script>
// Import component
// import Loading from "vue-loading-overlay";
// Import stylesheet
//import 'vue-loading-overlay/dist/vue-loading.css';
//import {ClientTable, Event} from 'vue-tables-2';
//Vue.use(Event);
//var debounce = require('lodash.debounce');
import { mapGetters } from "vuex";
export default {
  // components: {
  //   Loading
  // },
  filters: {},
  props: {
    //show_team: { type: Boolean, required: false, default: true },
    //from_stat: { type: Boolean, required: false, default: false },
    //default_page: { type: Boolean, required: false, default: false },
    isCommissioner: { type: Boolean, required: false, default: false },
    userId: { type: Number, required: false, default: 0 },
    league: { type: Object, default: () => {}, required: true },
    //fantasyLeagueId: { type: Number, required: false, default: 0 },
    // draftData: {type: Object, required: false, default: () => {}},
    draftComplete: { type: Boolean, required: false, default: false },
    waiverPeriodEnabled: { type: Boolean, required: false, default: false },
  },
  data() {
    return {
      selectedTeam: 'ALL',
      nflTeams: ['ALL'],
      enableCommissionerMode: false,
      statsPlayerList: [],
      projectionItems: [],
      fields: [],
      sharedFptFields:
        {
          key: "played",
          label: "Games",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
      rbwrtefields: [
        {
          key: "action",
          label: "ACTION",
          sortable: false,
        },
        // {
        //   key: "available_status",
        //   label: "Avail",
        //   sortable: false,
        // },
        //{ key: "name", label: "PLAYER", sortable: true, sortDirection: "desc" },
        // Virtual Columns made up of multiple columns
        {
          key: "name_pos_team",
          label: "Player",
          sortable: false,
        },
        {
          key: "player_upcoming_game_opponent",
          label: "Opp",
          sortable: false,
        },
        // { key: "ovp", label: "Ovp", sortable: false },
        {
          key: "bye_week",
          label: "Bye",
          sortable: false,
        },
        // {
        //   key: "trend_own",
        //   label: "Own",
        //   sortable: false
        // },
        // {
        //   key: "trend_start",
        //   label: "START",
        //   sortable: false
        // },

        // {
        //   key: "pos_expert",
        //   label: "EXPERT",
        //   sortable: true,
        //   sortDirection: "desc"
        // },

        {
          key: "rushing_attempts",
          label: "Att",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "rushing_yards",
          label: "Yrds",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "rushing_yards_per_attempt",
          label: "Avg",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "rushing_touchdowns",
          label: "TD",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },

        {
          key: "receiving_targets",
          label: "Tar",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "receptions",
          label: "Rec",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "receiving_yards",
          label: "Yds",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "receiving_yards_per_reception",
          label: "Avg",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "receiving_touchdowns",
          label: "TD",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },

        {
          key: "fumbles_lost",
          label: "Lost",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "played",
          label: "Games",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "fantasy_points_per_game_average",
          label: "Avg",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            let avgpts = 0;
            let games_played = this.statisticsFormatter(value, "played", item);
            if (games_played > 0) {
              avgpts =
                this.statisticsFormatter(value, "fantasy_points_acme", item) /
                games_played;
            }
            return avgpts.toFixed(2);
          },
        },
        {
          key: "fantasy_points_acme",
          label: "Season",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
      ],
      kfields: [
        {
          key: "action",
          label: "ACTION",
          sortable: true,
          sortDirection: "desc",
        },
        // {
        //   key: "available_status",
        //   label: "Avail",
        //   sortable: true,
        //   sortDirection: "desc",
        // },
        {
          key: "name_pos_team",
          label: "Player",
          sortable: true,
          sortDirection: "desc",
        },
        {
          key: "player_upcoming_game_opponent",
          label: "Opp",
          sortable: false,
        },
        // { key: "ovp", label: "Ovp", sortable: true, sortDirection: "desc" },
        {
          key: "bye_week",
          label: "Bye",
          sortable: true,
          sortDirection: "desc",
        },

        // {
        //   key: "trend_own",
        //   label: "Own",
        //   sortable: true,
        //   sortDirection: "desc"
        // },
        // {
        //   key: "trend_start",
        //   label: "START",
        //   sortable: true,
        //   sortDirection: "desc"
        // },

        // {
        //   key: "pos_expert",
        //   label: "EXPERT",
        //   sortable: true,
        //   sortDirection: "desc"
        // },

        {
          key: "field_goals_made",
          label: "FG",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "field_goals_attempted",
          label: "Att",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "field_goals_longest_made",
          label: "Att",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "field_goals_made0to19",
          label: "Made",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        // {
        //   key: "fg_att_1_19",
        //   label: "1-19 Att",
        //   sortable: true,
        //   sortDirection: "desc",
        //   sortByFormatted: true,
        //   formatter: (value, key, item) => { return this.statisticsFormatter(value,key,item)},
        // },
        {
          key: "field_goals_made20to29",
          label: "Made",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        // {
        //   key: "fg_att_20_29",
        //   label: "20-29 Att",
        //   sortable: true,
        //   sortDirection: "desc",
        //   sortByFormatted: true,
        //   formatter: (value, key, item) => { return this.statisticsFormatter(value,key,item)},
        // },
        {
          key: "field_goals_made30to39",
          label: "Made",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        }, // {
        //   key: "fg_att_30_39",
        //   label: "30-39 Att",
        //   sortable: true,
        //   sortDirection: "desc",
        //   sortByFormatted: true,
        //   formatter: (value, key, item) => { return this.statisticsFormatter(value,key,item)},
        // },
        {
          key: "field_goals_made40to49",
          label: "Made",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        }, // {
        //   key: "fg_att_40_49",
        //   label: "40-49 Att",
        //   sortable: true,
        //   sortDirection: "desc",
        //   sortByFormatted: true,
        //   formatter: (value, key, item) => { return this.statisticsFormatter(value,key,item)},
        // },
        {
          key: "field_goals_made50_plus",
          label: "Made",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        }, // {
        //   key: "fg_att_50",
        //   label: "50+ Att",
        //   sortable: true,
        //   sortDirection: "desc",
        //   sortByFormatted: true,
        //   formatter: (value, key, item) => { return this.statisticsFormatter(value,key,item)},
        // },
        {
          key: "extra_points_made",
          label: "Made",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "extra_points_attempted",
          label: "ATT",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "played",
          label: "Games",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "fantasy_points_per_game_average",
          label: "Avg",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            let avgpts = 0;
            let games_played = this.statisticsFormatter(value, "played", item);
            if (games_played > 0) {
              avgpts =
                this.statisticsFormatter(value, "fantasy_points_acme", item) /
                games_played;
            }
            return avgpts.toFixed(2);
          },
        },
        {
          key: "fantasy_points_acme",
          label: "Fpts Season",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
      ],
      tqbfields: [
        {
          key: "action",
          label: "ACTION",
          sortable: true,
          sortDirection: "desc",
        },
        // {
        //   key: "available_status",
        //   label: "Avail",
        //   sortable: true,
        //   sortDirection: "desc",
        // },
        {
          key: "name_pos_team",
          label: "Player",
          sortable: false,
        },

        {
          key: "player_upcoming_game_opponent",
          label: "Opp",
          sortable: false,
        },
        // { key: "ovp", label: "Ovp", sortable: true, sortDirection: "desc" },
        {
          key: "bye_week",
          label: "Bye",
          sortable: false,
        },

        // {
        //   key: "trend_own",
        //   label: "Own",
        //   sortable: true,
        //   sortDirection: "desc"
        // },
        // {
        //   key: "trend_start",
        //   label: "START",
        //   sortable: true,
        //   sortDirection: "desc"
        // },

        // {
        //   key: "pos_expert",
        //   label: "EXPERT",
        //   sortable: true,
        //   sortDirection: "desc"
        // },

        {
          key: "passing_attempts",
          label: "Att",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "passing_completions",
          label: "Cmp",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "passing_yards",
          label: "Yds",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "passing_touchdowns",
          label: "TD",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "passing_interceptions",
          label: "INT",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },

        {
          key: "rushing_attempts",
          label: "Att",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "rushing_yards",
          label: "Yds",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "rushing_yards_per_attempt",
          label: "Avg",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "rushing_touchdowns",
          label: "TD",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "fumbles_lost",
          label: "Lost",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "played",
          label: "Games",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "fantasy_points_per_game_average",
          label: "Avg",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            let avgpts = 0;
            let games_played = this.statisticsFormatter(value, "played", item);
            if (games_played > 0) {
              avgpts =
                this.statisticsFormatter(value, "fantasy_points_acme", item) /
                games_played;
            }
            return avgpts.toFixed(2);
          },
        },
        {
          key: "fantasy_points_acme",
          label: "Season",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
      ],
      deffields: [
        {
          key: "action",
          label: "ACTION",
          sortable: true,
          sortDirection: "desc",
        },
        // {
        //   key: "available_status",
        //   label: "Avail",
        //   sortable: true,
        //   sortDirection: "desc",
        // },
        {
          key: "name_pos_team",
          label: "Player",
          sortable: true,
          sortDirection: "desc",
        },

        {
          key: "player_upcoming_game_opponent",
          label: "Opp",
          sortable: false,
        },

        {
          key: "bye_week",
          label: "Bye",
          sortable: true,
          sortDirection: "desc",
        },

        // {
        //   key: "trend_own",
        //   label: "Own",
        //   sortable: true,
        //   sortDirection: "desc"
        // },
        // {
        //   key: "trend_start",
        //   label: "START",
        //   sortable: true,
        //   sortDirection: "desc"
        // },
        {
          key: "sacks",
          label: "Sacks",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "fumbles_forced",
          label: "FUM",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "interceptions",
          label: "INT",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "touchdowns_scored",
          label: "Def TD",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "safeties",
          label: "Sfty",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },

        {
          key: "yards_avg",
          label: "Yrds Allow / Per Game",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            let avgpts = 0;
            let games_played = this.statisticsFormatter(value, "games", item);
            if (games_played > 0) {
              avgpts =
                this.statisticsFormatter(
                  value,
                  "offensive_yards_allowed",
                  item
                ) / games_played;
            }
            return avgpts.toFixed(2);
          },
        },
        {
          key: "offensive_yards_allowed",
          label: "Yrds Allowed",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "points_avg",
          label: "Pts per game",
          sortable: true,
          sortDirection: "desc",
          formatter: (value, key, item) => {
            let avgpts = 0;
            let games_played = this.statisticsFormatter(value, "games", item);
            if (games_played > 0) {
              avgpts =
                this.statisticsFormatter(value, "points_allowed", item) /
                games_played;
            }
            return avgpts.toFixed(2);
          },
        },
        {
          key: "points_allowed",
          label: "Tot Pts Allowed",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "games",
          label: "Games",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "fantasy_points_per_game_average",
          label: "Avg",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            let avgpts = 0;
            let games_played = this.statisticsFormatter(value, "games", item);
            if (games_played > 0) {
              avgpts =
                this.statisticsFormatter(value, "fantasy_points_acme", item) /
                games_played;
            }
            return avgpts.toFixed(2);
          },
        },
        {
          key: "fantasy_points_acme",
          label: "Season",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
      ],
      stfields: [
        {
          key: "action",
          label: "ACTION",
          sortable: true,
          sortDirection: "desc",
        },
        // {
        //   key: "available_status",
        //   label: "Avail",
        //   sortable: true,
        //   sortDirection: "desc",
        // },
        {
          key: "name_pos_team",
          label: "Player",
          sortable: true,
          sortDirection: "desc",
        },

        {
          key: "player_upcoming_game_opponent",
          label: "Opp",
          sortable: true,
          sortDirection: "desc",
        },

        {
          key: "bye_week",
          label: "Bye",
          sortable: true,
          sortDirection: "desc",
        },
        {
          key: "kick_return_yards",
          label: "YDS",
          sortable: true,
          sortDirection: "desc",
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "kick_return_yards_per_attempt",
          label: "AVG",
          sortable: true,
          sortDirection: "desc",
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "kick_return_touchdowns",
          label: "TD",
          sortable: true,
          sortDirection: "desc",
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },

        {
          key: "punt_return_yards",
          label: "YDS",
          sortable: true,
          sortDirection: "desc",
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "punt_return_yards_per_attempt",
          label: "AVG",
          sortable: true,
          sortDirection: "desc",
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "punt_return_touchdowns",
          label: "TD",
          sortable: true,
          sortDirection: "desc",
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        // {
        //   key: "blocked_kicks_blocked",
        //   label: "BLOCKED",
        //   sortable: true,
        //   sortDirection: "desc",
        // },
        // {
        //   key: "blocked_kicks_blocked2",
        //   label: "BLOCKED",
        //   sortable: true,
        //   sortDirection: "desc",
        // },
        // {
        //   key: "blocked_kicks_punt",
        //   label: "PUNT",
        //   sortable: true,
        //   sortDirection: "desc",
        // },
        {
          key: "played",
          label: "Games",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
        {
          key: "fantasy_points_per_game_average",
          label: "Avg",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            let avgpts = 0;
            let games_played = this.statisticsFormatter(value, "played", item);
            if (games_played > 0) {
              avgpts =
                this.statisticsFormatter(value, "fantasy_points_acme", item) /
                games_played;
            }
            return avgpts.toFixed(2);
          },
        },
        {
          key: "fantasy_points_acme",
          label: "Season",
          sortable: true,
          sortDirection: "desc",
          sortByFormatted: true,
          formatter: (value, key, item) => {
            return this.statisticsFormatter(value, key, item);
          },
        },
      ],
      totalRows: 0,
      currentPage: 1,
      perPage: 100,
      sortBy: 'fantasy_points_acme',
      sortDesc: true,
      sortDirection: "asc",
      filter: null,
      searchFilter: "",
      infoModal: {
        id: "info-modal",
        title: "",
        content: "",
      },
      filterOn: [],
      search_term: "",
      show_modal: false,
      fullPage: true,
      selectedPosition: 'TQB',
      current_status: "all",
      season: "2021",
      players: [],
      myTeamList: [],
      // playerList: [],
      player_id: "",
      watched: "",
      record: "",
      added: "",
      not_allowed: "",
      available: "",
      max_reached: "",
      componentKey: 0,
      remove: "",
      owned_by: "",
      photo_url: "",
      seasons: ["2021 Projection", "2021", "2020"],
      seasonTypes: [
        { type: 1, label: "Regular" },
      ],
      seasonType: 1,
      show_timer: false,
      show_teams: false,
      deadline: "0000-00-00 00:00:00",
      rounds: 1,
      curUserId: 0,
      draft_completed: 0,
      clock_team: "",
      page: "team-draft",
      selectMode: "single",
      user_team_id: "",
      isProjection: false,
      commissionerCurrentDraftPlayerCounts: {},
      commissionerCurrentDraftPlayerCountsLoaded: false,
      playerData: {}
    };
  },
  computed: {
    // mix the getters into computed with object spread operator
    // ...mapGetters({
    //   statsPlayerList: 'playerList',
    // }),

    filteredPlayers: function() {
      let filteredItems = this.statsPlayerList;
      if (this.searchFilter) {
        const regexp = new RegExp(this.searchFilter, "i");
        filteredItems = filteredItems.filter((player) =>
          player.name.match(regexp)
        );
      }
      return filteredItems;
      // return this.statsPlayerList.filter(this.searchFilter)
      // .filter(this.searchFilter)
      // .filter(this.setPositionFilter)
    },

    draftData() {
      return this.$store.state.leagueDraftData;
    },
    systemSettings() {
      return this.$store.state.systemSettings;
    },
    newOnClock() {
      if (this.draftData.currentDraft)
        return this.draftData.currentDraft.deadline;
      return 0;
    },
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
    isLoading() {
      return this.$store.state.isLoading;
    },
    // TODO: This is not being dispatched. But it appears to store information about a team.
    // Probably better to switch to vuex
    getMyTeam() {
      return this.$store.state.myTeamList;
    },
    userFantasyTeam() {
      return this.$store.state.userFantasyTeam;
    },
    showButtons() {
      //Handle completed draft
      if(this.systemSettings.season_type == 3)
        return false;
      if (this.draftData.league.draft_completed) return true;
      if (this.draftData.league.draft_started) {
        return true;
        // if (
        //   this.draftData.currentDraft.fantasy_team_id ==
        //   this.draftData.user_team_id
        // )
        //   return true;
        // Allow to show draft button but draft for the user on clock.
        // If the user is a commissioner then show the draft button
        // if(this.isCommissioner)
        //   return true;
      }
      return false;
    },
    // statsPlayerList() {
    //   return this.$store.getters.playerList;
    // },
    // totalStatsItems() {
    //   return this.statsItems.length
    // }
  },
  watch: {

    // The !! forces boolean https://www.samanthaming.com/tidbits/19-2-ways-to-convert-to-boolean/
    season: function(newSeason, old) {
      if(newSeason.indexOf('Projection') !== -1)
        this.isProjection = true
      else
        this.isProjection = false
      //this.isProjection = !!newSeason.indexOf('Projection') !== -1
    },
    // TODO: This needs to be websocket or more efficient methods.
    draftData: function(newRequest, oldRequest) {
      if(this.enableCommissionerMode) {
        this.getPositionCounts();
      }
    },

    enableCommissionerMode: function() {
      // console.log('commissioner mode watch enabled');
      this.getPositionCounts();
    },

    //Watch the selected position and handle the table column of information we want to display.
    selectedPosition: function(newSelectedPosition, oldSelectedPosition) {
      switch (newSelectedPosition) {
        case "TQB":
          this.fields = this.tqbfields;
          break;
        case "ST":
          this.fields = this.stfields;
          break;
        case "DEF":
          this.fields = this.deffields;
          break;
        case "K":
          this.fields = this.kfields;
          break;
        default:
          this.fields = this.rbwrtefields;
      }
    },
  },
  created() {
    //this.$store.dispatch('loadMyTeamTable');
    //this.$store.dispatch('loadDraftTeams');
    //this.getDraftTeams();
    this.initialize();
  },
  mounted() {
    // Get League Draft Data
    this.$store.dispatch("loadLeagueDraftData");
    this.$store.dispatch("getSystemSettings", {});
    // League Transactions in real time
    // console.log(`league transaction, league: ` + this.league.id);
    Echo.private(`league.` + this.league.id).listen(
      ".league.transaction",
      (e) => {
        // console.log(
        //   "e.transaction.fantasy_player_id: ",
        //   e.transaction.fantasy_player_id
        // );
        // console.log("league.transaction: ", e);
        //Find the index of the player
        let pIndex = this.statsPlayerList.findIndex(
          (player) => player.id == e.transaction.fantasy_player_id
        );
        // If it doesn't find a player exit out because we can't update.
        // May not find the player because the user is viewing a different position group and the new draft pick was another position
        if(pIndex < 1)
          return;
        // console.log('pIndex: ',pIndex)
        //Update the list of players with the new information
        // If the player was a "drop" then let's drop the data
        // TODO 04/05/20: Should this really be saving the drop transaction type?
        if (!e.transaction.active && !e.transaction.bench){
          //Not on bench and not active anymore so the transaction was to "drop"
          // console.log('pIndex ', pIndex);
          Vue.set(this.statsPlayerList[pIndex], "fantasy_team_owned_by", {});
        }
        else{
          Vue.set(
            this.statsPlayerList[pIndex],
            "fantasy_team_owned_by",
            e.transaction
          );
        }
        //this.statsPlayerList.filter(player => player.id == e.transaction.fantasy_player_id)
      }
    );
    // this.changeSelectedPosition(null);
    //console.log('mounted')
    //this.getLoggedInUserDetails();
    //this.getSeasons();
    //this.getPlayers();
    // window.setInterval(() => {
    //   if (this.draft_completed != 1) {
    //     this.getDraftTeams();
    //   }
    // }, 1000);
    // Set the initial number of items
  },
  methods: {

    showMoveToStarterButton(player)
    {
      // return true;
      //console.log(player)
      if(player.fantasy_team_owned_by.fantasy_team_id == this.userId && player.fantasy_team_owned_by.bench && this.draftComplete)
        return true;
      return false
    },

    showBenchButton(player)
    {
      // if(this.remove == 1 && this.claim_removed !=1)
      //   return true;
      if(player.fantasy_team_owned_by.fantasy_team_id == this.userId){
        if(player.current_player_game){
          if(player.current_player_game.started)
            return false;
        }
        if(!player.player_injuries)
          return false;

        if(this.showMoveToStarterButton(player))
          return false;

        return true;
      }
      return false;
    },

    showAddButton(player)
    {
      if(this.waiverPeriodEnabled)
        return false;

      if(player.fantasy_team_owned_by.fantasy_team_id == this.userFantasyTeam.id)
        return false;

      if(!player.fantasy_team_owned_by.id && !this.userFantasyTeam.position[player.position].maxReached && !this.enableCommissionerMode){
        return true;
      }

      // Check for injured player stuff
      let position = this.userFantasyTeam.position[player.position];
      let positionCheck = this.userFantasyTeam.injuries[player.position];

      // If we have an injured position we need to only show the add button for the specific player on the same team
      // if(positionCheck) {
      //   if(positionCheck[player.team.key])
      //     return true;
      //   else
      //     return false;
      // }


      return false;
    },

    showDropBenchButton(player)
    {
      if(player.fantasy_team_owned_by.fantasy_team_id == this.userId){
        if(player.current_player_game){
          if(player.current_player_game.started)
            return false;
        }
        return true;
      }

      return false;
    },

    checkDisabled(player)
    {
      //console.log('return true');
      //return true;
      if(this.draftComplete)
        return false //return player.fantasy_team_owned_by.id != this.userFantasyTeam.id
      else
        return this.userFantasyTeam.id != this.draftData.currentDraft.fantasy_team_id
    },

    initialize() {
      // Get the user's roster
      this.getUserFantasyTeamRoster();
      // Set Season dropdown
      //this.getSeasons();
      //Request all the players data
      this.getPlayers();
      this.getNFLTeams();
      //Set the table fields to to initial fields for "all"
      this.fields = this.rbwrtefields;
    },
    getLoggedInUserDetails() {
      var curUserId = $("#curUserId").val();
      if (curUserId) {
        this.curUserId = curUserId;
      }
    },
    // Value is not used. This would be if we need to upercase something, etc .
    // Key is the column of data (rushing_yards, passing_touchdowns)
    // item is the specific row item.
    statisticsFormatter(value, key, item) {
      // let returnValue = 0
      if(this.isProjection) {

        //console.log('stats formatter is Projection');
        if (Array.isArray(item.player_season_projection) && item.player_season_projection.length)
          return item.player_season_projection.reduce((a, b) => a + (b[key] || 0), 0);
        if (Array.isArray(item.fantasy_defense_season_projection) && item.fantasy_defense_season_projection.length && item.position == "DEF")
          return item.fantasy_defense_season_projection.reduce((a, b) => a + (b[key] || 0),0);
      } else {
        //console.log('stats formatter is NOT Projection');
      if (Array.isArray(item.player_season) && item.player_season.length)
        return item.player_season.reduce((a, b) => a + (b[key] || 0), 0);
      if (
        Array.isArray(item.fantasy_defense_season) &&
        item.fantasy_defense_season.length
      )
        return item.fantasy_defense_season.reduce(
          (a, b) => a + (b[key] || 0),
          0
        );
      }
      // return returnValue;
    },
    changeSelectedPosition(position) {
      this.selectedPosition = position;
    },
    rowSelected(items) {
      //console.log(items[0].id);
      this.player_id = items[0].id;
      this.showModal();
    },
    rowClass(item, type) {
      if (!item) return;
      if (item.available_status === "No") return "table-dark";
    },
    // getDraftTeams() {
    //   let data = this.draft_team_data;

    //   if (data) {
    //     this.items = data.draftTeams;
    //     if (data.currentDraft) {
    //       this.deadline = data.currentDraft.deadline;
    //       this.curId = data.currentDraft.fantasy_team_id;
    //       this.curUserId = data.currentDraft.user_id;
    //       this.rounds = data.currentDraft.round;
    //       this.clock_team = data.currentDraft.name;
    //       this.user_team_id = data.user_team_id;
    //       this.allow_add = 1; //TODO: Update to have allow_add be default for add action logic.
    //     }
    //     this.draft_completed = data.draftCompleted;
    //     this.draft_started = data.draftStarted;
    //     this.showButtons = true;

    //     this.show_teams = true;
    //     this.show_timer = true;
    //   } else {
    //     this.show_teams = false;
    //     this.show_timer = false;
    //   }
    // },

    info(item, index, button) {
      this.infoModal.title = `Row index: ${index}`;
      this.infoModal.content = JSON.stringify(item, null, 2);
      this.$root.$emit("bv::show::modal", this.infoModal.id, button);
    },
    resetInfoModal() {
      this.infoModal.title = "";
      this.infoModal.content = "";
    },
    filterByName: function(player) {
      // no search, don't filter :
      if (this.searchFilter.length === 0) {
        return true;
      }
      return (
        player.fantasy_player.name
          .toLowerCase()
          .indexOf(this.searchFilter.toLowerCase()) > -1
      );
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      // console.log('onFiltered', filteredItems.length)
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    show() {
      // do AJAX here
      this.visible = true;
    },
    setPositionFilter: function(position) {
      // console.log('setPositionFilter', position)

      //Clear any typed search.
      this.searchFilter = '';

      this.selectedPosition = position;
      //Set the filter to use the position column
      this.filterOn = ["position"];
      //Set the "filter"
      this.filter = this.selectedPosition;
      this.getPlayers();
      if(this.enableCommissionerMode)
        this.getPositionCounts()
    },
    // This would be if we want to filter based on "available" or "not available"
    getStatus: function(event) {
      this.current_status = event;
    },
    edit(warehouseId) {
      // The id can be fetched from the slot-scope row object when id is in columns
    },
    onLoaded() {
      //console.log('table loaded')
    },

    // TODO 04/05/2020: Do we need this? Cleanup
    getNFLTeams() {
      axios
        .get("/players/team")
        .then((response) => {
          // this.teamOptions = [];
          response.data.forEach((value, key) => {
            this.nflTeams.push(value);
          });
        })
        .catch((error) => {});
    },
    // TODO 04/05/2020: Do we need this? Cleanup
    getPlayerPosition() {
      axios
        .get("/players/positions")
        .then((response) => {
          this.playerPositions = [{ value: null, text: "ALL" }];
          response.data.positions.forEach((value, key) => {
            this.playerPositions.push({ text: value, value: value });
          });
        })
        .catch((error) => {});
    },

    // TODO 07/30/2020: Implement this feature so that the max allowed text would display for the Commissioner when toggled on.
    getPositionCounts() {
      this.commissionerCurrentDraftPlayerCountsLoaded = false;
      // console.log('get position counts')
      axios
        .get("/getUserFantasyTeamRoster/"+ this.draftData.currentDraft.fantasy_team_id)
        .then((response) => {
          this.commissionerCurrentDraftPlayerCounts = response.data;
          this.commissionerCurrentDraftPlayerCountsLoaded = true;
        })
        .catch((error) => {});
    },
    // TODO 04/05/2020: Do we need this? Cleanup
    getSeasons2() {
      axios
        .get("/get_three_seasons")
        .then((response) => {
          this.seasons = response.data;
        })
        .catch((error) => {});
    },
    getPlayers() {
      // console.log('get players')
      // let season = this.season;
      // console.log('season is ', season)
      // let isProjection = season.indexOf('Projection') !== -1

      // console.log('isProjection', this.isProjection)
      this.$store
        .dispatch("loadPlayerList", {
          selectedTeam: this.selectedTeam,
          selectedPosition: this.selectedPosition,
          season: this.season.replace(/\D/g,''),
          seasonType: this.seasonType,
          isProjection: this.isProjection
        })
        .then(
          (response) => {
            // console.log("loadPlayerList")
            // Set initial pagination which is what the vuex would store based on above params
            // console.log('loadPlayerList response', response)
            this.totalRows = this.$store.getters.playerList.length;
            this.statsPlayerList = response.data.players;
            //Refresh the table
            this.$refs.stats - table.refresh();
          },
          (error) => {
            console.error(
              "Got nothing from server. Prompt user to check internet connection and try again"
            );
          }
        );
    },
    getUserFantasyTeamRoster() {
      this.$store
        .dispatch("getUserFantasyTeamRoster", {
          season: this.season,
          seasonType: this.seasonType,
        })
        .then(
          (response) => {
            // TODO: 04/12/20 See if we want to return the response or keep getting it from state?
            //console.log("Got some data, now lets show something in this component")
            // console.log(response)
            // this.userFantasyTeam = response.data
          },
          (error) => {
            console.error(
              "Got nothing from server. Prompt user to check internet connection and try again"
            );
          }
        );
    },
    teamChange: function(team) {
      this.selectedTeam = team;
      this.getPlayers();
    },
    setSeason: function(season) {
      this.projection = 0;
      this.season = season;
      this.getPlayers();
    },
    setSeasonType: function(type) {
      this.seasonType = type;
      this.getPlayers();
    },
    rowClicked(items) {
      //console.log(items)
      //console.log(items.id)
      this.player_id = items.id;
      this.playerData = items;
      this.showModal();
    },

    showModal() {
      //console.log('PlayersTableComponent show modal. player_id ='+this.player_id)
      this.show_modal = true;
    },
    onClose() {
      //this.popoverShow = false;
      this.$refs.popover.$emit("close");
    },
    onShow() {
      /* This is called just before the popover is shown */
      /* Reset our popover "form" variables */
    },

    //TODO: Update to not hard code transaction_id
    // transaction_id
    // 1=add 2=drop 3=trade 4=watch 5=claim, 6=claim reject 7=claim approve, 8=active to bench, 9=bench to active
    playerTransaction(player_id, transaction_id, fantasy_team_id = null) {
      axios
        .post("/players/player-transaction", {
          player_id: player_id,
          transaction_id: transaction_id,
          fantasy_team_id: fantasy_team_id,
        })
        .then((response) => {
          if (response.data.success) {
            // console.log("success player transacton");
            // Get the new roster for the user since it has changed.
            this.getUserFantasyTeamRoster();
            if(this.enableCommissionerMode)
              this.getPositionCounts()
            this.$store.dispatch("showSnackBarSuccess", {
              message: response.data.message,
            });

            // Reload current players table to show latest buttons
            this.getPlayers();
          } else {
            // console.log("fail player transaction");
            this.$store.dispatch("showSnackBarFailure", {
              message: response.data.message,
            });
          }
        })
        .catch((error) => {});
    },
    //TODO 05-10-20: See if anything useful here.
    // addPlayerDraft(player_id, method) {
    //   axios
    //     .post(
    //       "/players/player-draft_transaction",
    //       {
    //         player_id: player_id,
    //         current_team_id: this.curId,
    //         transaction_id: transaction_id,
    //         method: method
    //       },
    //     )
    //     .then(response => {
    //       if (response.data.success == 1) {
    //         this.$store.dispatch("showSnackBarSuccess", {
    //           message: response.data.message
    //         });
    //       } else {
    //         this.$store.dispatch("showSnackBarFailure", {
    //           message: response.data.message
    //         });
    //       }
    //     })
    //     .catch(error => {});
    //   //this.$refs.popover.$emit('close')
    // },
    range(start, end) {
      return Array(end - start)
        .join(0)
        .split(0)
        .map(function(val, id) {
          return id + start;
        });
    },
    getSeasons() {
      var year = new Date().getFullYear() + 1;
      var start_year = year - 4;
      this.seasons = this.range(start_year, year);
    },

    availableChange: function(e) {
      var showAvailableOnly = e.target.value;
      var selectedPosition = this.positions;
      var selectedTeam = this.teams;
      var season = this.season;
      this.getPlayers(
        selectedTeam,
        selectedPosition,
        showAvailableOnly,
        season
      );
    },
  },
};
</script>

<style>

.thead-top-style, th.table-b-table-default {
  text-transform: uppercase;
}

/*.notactive {
  color: #42a2dc;
  background-color: transparent;
}*/
.bs-component {
  padding-top: 10px;
  padding-bottom: 10px;
}
/*.table_super_heading {
  text-align: center;
  border-bottom: 1px solid #c1cacf;
}*/
.table thead th {
  vertical-align: bottom;
  border-bottom: none;
  /*  background-color: #f5f5f6 !important;*/
}
.jumbo-container {
  background: #0055a6;
  color: #fff;

  left: 0;

  position: relative;
  width: 100%;
  z-index: 0;
}

/** force the container full width in the draft room. hackish but works **/
/*.draft-players-table-container .container.player-tabs {
  max-width: 97% !important;
}*/

button.disabled {
  cursor: not-allowed;
}

table#stats-table tr td, .card .table th, .card .table td {
     padding: 0.3rem;
}

.thead-top-style {
  padding: 10px 5px 0px 5px !important;
/*  border-bottom-style: solid!important;
  border-bottom-width:1px!important;*/
  text-align: center;
}

.thead-top-style > div {
    border-bottom: 1px solid #c1cacf;
    margin: 0 auto;
    padding-bottom: 5px;
    text-align: center;
    width: 100%;
}

table.b-table > thead > tr > .table-b-table-default {
  background-color: #e6ecf0!important;
}
</style>
