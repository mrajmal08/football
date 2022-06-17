<template>
  <b-modal
    ref="refPlayerDetailModal"
    v-model="show"
    hide-footer
    title="Player Details"
    centered
    size="lg"
    @hidden="onHidden"
  >
    <b-container class="model-top">
      <b-row>
        <b-col class="text-left">
          <b-row>
            <b-col>
              <h2 ref="draftname">{{ player_data.name }}</h2>
            </b-col>
          </b-row>
          <b-row>
            <div class="text-left col-sm-3">
              <img
                :src="player_data.player_photo_url"
                class="m-1 rounded-circle player-photo"
                alt=""
                rounded="circle"
              >
            </div>
            <div class="text-left col-sm-9 m-auto">
              <span v-if="player_data.teams">
                {{ player_data.teams.city }}
              </span>
              <span>
                Exp: {{ player_data.player_experience }}yrs
              </span>
              <br>
              <span>Position: {{ player_data.position }}</span><br>
              <span v-if="player_data.player">
                <span v-if="player_data.player.height">
                  Ht: {{ player_data.player.height }} |
                </span>
                <span v-if="player_data.player.weight">
                  Wt: {{ player_data.player.weight }} lbs |
                </span>
                <span v-if="player_data.player.age">
                  Age: {{ player_data.player.age }}
                </span>
              </span><br>
              <span>Bye Week: {{ player_data.bye_week }}</span>
            </div>
          </b-row>
        </b-col>
        <b-col>
          <p v-if="added == 1">Owned By: <span>{{ owned_by }}</span> </p>	<p v-else>Free Agent</p>
          <br>
          <div class="stat">
            <div class="model-title">proj. fpts</div>
            <div class="number">
              <span v-if="player_data.player_season_projection && player_data.player_season_projection[0]">{{ player_data.player_season_projection[0].fantasy_points_acme|changeFormat }}
              </span>
              <span v-else>0</span>
            </div>
          </div>
          <div class="stat">
            <div class="model-title">adp</div>
            <div class="number">
              <span v-if="player_data.average_draft_position > 0"> {{ player_data.average_draft_position }}
              </span>
              <span v-else>NR</span>
            </div>
          </div>
          <div class="stat">
            <div class="model-title">{{ player_data.player_fantasy_position }} RANK</div>
            <div class="number">NR</div>
          </div>
          <div class="stat-last">
            <div class="model-title">
              <span v-if="player_data.previous_seasons && player_data.previous_seasons[0]"> {{ player_data.previous_seasons && player_data.previous_seasons[0].season }} </span>FPTS/G
            </div>
            <div class="number">
              <span v-if="player_data.previous_seasons && player_data.previous_seasons[0] && player_data.previous_seasons[0].activated > 0">{{ player_data.previous_seasons[0].fantasy_points_acme / player_data.previous_seasons[0].activated |changeFormat }}</span>
              <span v-else>0.00</span>
            </div>
          </div>
        </b-col>
      </b-row>
      <snackbar />
    </b-container>
    <b-container
      v-if="player_injuries != ''"
      class="injury-alert  py-2"
    >
      <b-row>
        <span v-if="player_injuries != ''">INJURY ALERT | {{ player_injuries.injury_status }} | 	{{ player_injuries.injury_body_part }}</span>
      </b-row>
    </b-container>
    <b-container
            v-if="player_data.bye_week === leagueWeek"
            class="injury-alert  py-2"
    >
      <b-row>
        <span>PLAYER ON BYE WEEK {{player_data.bye_week}}</span>
      </b-row>
    </b-container>
    <b-tabs
      id="player_tabs"
      pills
    >
      <b-tab
        title="Overview"
        active>
        <div class="tabcontent">
          <div class="row">
            <div class="col-md-4">
              <div class="leftUnderline"><span class="boldText">Player</span> News</div>
              <news-item-component :player_data="player_data" />
            </div>
            <div class="col-md-8">
              <div class="leftUnderline"><span class="boldText">Player</span> Stats</div>
              <div class="keyStatsTableWrapper">
                <table
                  v-if="(player_data.position=='WR' || player_data.position=='TE') && player_data.previous_seasons"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>Actual</th>
                      <th>G</th>
                      <th>TAR</th>
                      <th>REC</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.previous_seasons">
                      <td>{{ item.season }}</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.receiving_targets }}</td>
                      <td>{{ item.receptions }}</td>
                      <td>{{ item.receiving_yards }}</td>
                      <td>{{ item.receiving_touchdowns }}</td>
                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>
                <table
                  v-if="(player_data.position=='RB') && player_data.previous_seasons"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>Actual</th>
                      <th>G</th>
                      <th>ATT</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>TAR</th>
                      <th>REC</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.previous_seasons">
                      <td>{{ item.season }}</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.rushing_attempts }}</td>
                      <td>{{ item.rushing_yards }}</td>
                      <td>{{ item.rushing_touchdowns }}</td>
                      <td>{{ item.receiving_targets }}</td>
                      <td>{{ item.receptions }}</td>
                      <td>{{ item.receiving_yards }}</td>
                      <td>{{ item.receiving_touchdowns }}</td>
                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>
                <table
                  v-if="(player_data.position=='TQB') && player_data.previous_seasons"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>Actual</th>
                      <th>G</th>
                      <th>COMP</th>
                      <th>ATT</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>INT</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.previous_seasons">
                      <td>{{ item.season }}</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.passing_completions }}</td>
                      <td>{{ item.passing_attempts }}</td>
                      <td>{{ item.passing_yards }}</td>
                      <td>{{ item.passing_touchdowns }}</td>
                      <td>{{ item.passing_interceptions }}</td>
                      <td>{{ item.rushing_yards }}</td>
                      <td>{{ item.rushing_touchdowns }}</td>
                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>
                <table
                  v-if="(player_data.position=='K') && player_data.previous_seasons"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>Actual</th>
                      <th>G</th>
                      <th>XP</th>
                      <th>ATT</th>
                      <th>FG</th>
                      <th>ATT</th>
                      <th>FG</th>
                      <th>FG</th>
                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.previous_seasons">
                      <td>{{ item.season }}</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.extra_points_made }}</td>
                      <td>{{ item.extra_points_attempted }}</td>
                      <td>{{ item.field_goals_made }}</td>
                      <td>{{ item.field_goals_attempted }}</td>
                      <td>{{ item.field_goals_made40to49 }}</td>
                      <td>{{ item.field_goals_made50_plus }}</td>

                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>
                <table
                  v-if="(player_data.position=='DEF') && player_data.previous_def_seasons"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>Actual</th>
                      <th>G</th>
                      <th>TD</th>
                      <th>INT</th>
                      <th>SACK</th>
                      <th>FUM</th>
                      <th>PTS</th>
                      <th>TYDA</th>

                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.previous_def_seasons">
                      <td>{{ item.season }}</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.touchdowns }}</td>
                      <td>{{ item.interceptions }}</td>
                      <td>{{ item.sacks }}</td>
                      <td>{{ item.fumbles }}</td>
                      <td>0</td>
                      <td>0</td>

                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>
                <table
                  v-if="(player_data.position=='ST') && player_data.previous_seasons"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>Actual</th>
                      <th>G</th>
                      <th>TD</th>
                      <th>INT</th>
                      <th>SACK</th>
                      <th>FUM</th>
                      <th>PTS</th>
                      <th>TYDA</th>

                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.previous_seasons">
                      <td>{{ item.season }}</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.touchdowns }}</td>
                      <td>{{ item.interceptions }}</td>
                      <td>{{ item.sacks }}</td>
                      <td>{{ item.fumbles }}</td>
                      <td>0</td>
                      <td>0</td>

                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>



                <table
                  v-if="(player_data.position=='TQB') && player_data.player_season_projection"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>PROJECTION</th>
                      <th>G</th>
                      <th>COMP</th>
                      <th>ATT</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>INT</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.player_season_projection">
                      <td>Season</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.passing_completions }}</td>
                      <td>{{ item.passing_attempts }}</td>
                      <td>{{ item.passing_yards }}</td>
                      <td>{{ item.passing_touchdowns }}</td>
                      <td>{{ item.passing_interceptions }}</td>
                      <td>{{ item.rushing_yards }}</td>
                      <td>{{ item.rushing_touchdowns }}</td>
                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>
                <table
                  v-if="(player_data.position=='RB') && player_data.player_season_projection"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>PROJECTION</th>
                      <th>G</th>
                      <th>ATT</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>TAR</th>
                      <th>REC</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.player_season_projection">
                      <td>Season</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.rushing_attempts }}</td>
                      <td>{{ item.rushing_yards }}</td>
                      <td>{{ item.rushing_touchdowns }}</td>
                      <td>{{ item.receiving_targets }}</td>
                      <td>{{ item.receptions }}</td>
                      <td>{{ item.receiving_yards }}</td>
                      <td>{{ item.receiving_touchdowns }}</td>
                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>
                <table
                  v-if="(player_data.position=='WR' || player_data.position=='TE') && player_data.player_season_projection"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>PROJECTION</th>
                      <th>G</th>

                      <th>TAR</th>
                      <th>REC</th>


                      <th>YDS</th>
                      <th>TD</th>
                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.player_season_projection">
                      <td>Season</td>
                      <td>{{ item.played }}</td>

                      <td>{{ item.receiving_targets }}</td>


                      <td>{{ item.receptions }}</td>
                      <td>{{ item.receiving_yards }}</td>
                      <td>{{ item.receiving_touchdowns }}</td>





                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>

                <table
                  v-if="(player_data.position=='K') && player_data.player_season_projection"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>PROJECTION</th>
                      <th>G</th>
                      <th>XP</th>
                      <th>ATT</th>
                      <th>FG</th>
                      <th>ATT</th>
                      <th>FG</th>
                      <th>FG</th>
                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.player_season_projection">
                      <td>Season</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.extra_points_made }}</td>
                      <td>{{ item.extra_points_attempted }}</td>
                      <td>{{ item.field_goals_made }}</td>
                      <td>{{ item.field_goals_attempted }}</td>
                      <td>{{ item.field_goals_made40to49 }}</td>
                      <td>{{ item.field_goals_made50_plus }}</td>

                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>

                <table
                  v-if="(player_data.position=='ST') &&player_data.player_season_projection"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>PROJECTION</th>
                      <th>G</th>
                      <th>TD</th>
                      <th>INT</th>
                      <th>SACK</th>
                      <th>FUM</th>
                      <th>PTS</th>


                      <th>TYDA</th>

                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.player_season_projection">
                      <td>Season</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.rushing_attempts }}</td>
                      <td>{{ item.rushing_yards }}</td>
                      <td>{{ item.rushing_touchdowns }}</td>

                      <td>{{ item.receiving_targets }}</td>


                      <td>{{ item.receptions }}</td>
                      <td>{{ item.receiving_yards }}</td>
                      <td>{{ item.receiving_touchdowns }}</td>





                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>


                <table
                  v-if="(player_data.position=='DEF') &&player_data.player_season_projection"
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th>PROJECTION</th>
                      <th>G</th>
                      <th>ATT</th>
                      <th>YDS</th>
                      <th>TD</th>
                      <th>TAR</th>
                      <th>REC</th>


                      <th>YDS</th>
                      <th>TD</th>
                      <th>FPTS</th>
                    </tr>
                    <tr v-for="item in player_data.player_season_projection">
                      <td>Season</td>
                      <td>{{ item.played }}</td>
                      <td>{{ item.rushing_attempts }}</td>
                      <td>{{ item.rushing_yards }}</td>
                      <td>{{ item.rushing_touchdowns }}</td>

                      <td>{{ item.receiving_targets }}</td>


                      <td>{{ item.receptions }}</td>
                      <td>{{ item.receiving_yards }}</td>
                      <td>{{ item.receiving_touchdowns }}</td>





                      <td>{{ item.fantasy_points_acme|changeFormat }}</td>
                    </tr>
                  </tbody>
                </table>





                <div
                  v-if="player_data.player_season_projection"
                  class="leftUnderline"
                >
                  <span
                    v-if="player_data.player_season_projection[0]"
                    class="boldText"
                  >{{ system_season }}</span> Season Schedule
                </div>

                <table
                  class="table b-table table-striped table-hover table-sm"
                  style="width:100%;"
                >
                  <tbody>
                    <tr class="label">
                      <th align="left">Wk</th>
                      <th align="left">Date</th>
                      <th align="left">Opp</th>
                      <th align="right">OPP Rank</th>
                      <th
                        class="bold"
                        align="right"
                      >
                        OPP FPTS
                      </th>
                    </tr>
                    <tr
                      v-for="item in player_data.fantasy_player_game_projection"
                      class="row1"
                      valign="top"
                      align="right"
                    >
                      <td align="left">{{ item.week }}</td>
                      <td align="left">{{ item.formated_game_date }}</td>
                      <td align="left">{{ item.opponent }}</td>
                      <td align="right" />
                      <td
                        class="bold"
                        align="left"
                      >
                        {{ item.fantasy_points_acme|changeFormat }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </b-tab>

      <b-tab title="News">
        <div class="tabcontent player_contend">
          <div v-if="player_data.fantasy_player_news">
            <news-item-component :player_data="player_data" />
          </div>
          <br>
          <b v-if="player_injuries.injury_notes"> Injured from {{ player_injuries.injury_start_date }}</b>
          <br> <br>
          {{ player_injuries.injury_notes }}
        </div>
      </b-tab>
      <b-tab
        title="Game Log"
        @click="selectTab(1)">
        <div class="tabcontent">
          <table
            v-if="player_data.position=='RB' && player_data.player_game"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr
                class="label superheader"
                style="border-bottom: 2px solid #000 !important"
              >
                <th colspan="3" />
                <th
                  colspan="4"
                  style="text-align:center;"
                >
                  <div>Receiving</div>
                </th>
                <th
                  colspan="3"
                  style="text-align:center;"
                >
                  <div>Rushing</div>
                </th>
                <th
                  colspan="1"
                  style="text-align:right;"
                >
                  <div>FUM</div>
                </th>
                <th colspan="1" />
              </tr>
              <tr class="label">
                <th>WK</th>
                <th>DATE</th>
                <th style="text-align:right;">OPP</th>

                <th style="text-align:right;">ATT</th>
                <th style="text-align:right;">YDS</th>
                <th style="text-align:right;">TD</th>
                <th style="text-align:right;">TAR</th>
                <th style="text-align:right;">REC</th>
                <th style="text-align:right;">YDS</th>
                <th style="text-align:right;">TD</th>
                <th style="text-align:right;">LOST</th>
                <th>FPTS</th>
              </tr>
              <tr v-for="item in player_data.player_game">
                <td style="text-align:right;">{{ item.week }}</td>
                <td>{{ item.game_date | moment("MM/DD/YYYY") }}<span /></td>
                <td style="text-align:right;"><span v-if="item.home_or_away=='AWAY'">@</span>{{ item.opponent }}</td>


                <td style="text-align:right;">{{ item.rushing_attempts }}</td>
                <td style="text-align:right;">{{ item.rushing_yards }}</td>
                <td style="text-align:right;">{{ item.rushing_touchdowns }}</td>
                <td style="text-align:right;">{{ item.receiving_targets }}</td>
                <td style="text-align:right;">{{ item.receptions }}</td>
                <td style="text-align:right;">{{ item.receiving_yards }}</td>
                <td style="text-align:right;">{{ item.receiving_touchdowns }}</td>
                <td style="text-align:right;">{{ item.fumbles_lost }}</td>
                <td style="text-align:right;">{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>




          <table
            v-if="(player_data.position=='WR' || player_data.position=='TE') && player_data.player_game"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr
                class="label superheader"
                style="border-bottom: 2px solid #000 !important"
              >
                <th colspan="3" />
                <th
                  colspan="4"
                  style="text-align:center;"
                >
                  <div>Receiving</div>
                </th>
                <th
                  colspan="3"
                  style="text-align:center;"
                >
                  <div>Rushing</div>
                </th>
                <th
                  colspan="1"
                  style="text-align:right;"
                >
                  <div>FUM</div>
                </th>
                <th colspan="1" />
              </tr>
              <tr class="label">
                <th>WK</th>
                <th>DATE</th>
                <th style="text-align:right;">OPP</th>
                <th style="text-align:right;">TAR</th>
                <th style="text-align:right;">REC</th>
                <th style="text-align:right;">YDS</th>

                <th style="text-align:right;">TD</th>
                <th style="text-align:right;">ATT</th>



                <th style="text-align:right;">YDS</th>
                <th style="text-align:right;">TD</th>
                <th style="text-align:right;">LOST</th>
                <th style="text-align:right;">FPTS</th>
              </tr>
              <tr v-for="item in player_data.player_game">
                <td style="text-align:right;">{{ item.week }}</td>
                <td>{{ item.game_date | moment("MM/DD/YYYY") }}<span /></td>
                <td style="text-align:right;"><span v-if="item.home_or_away=='AWAY'">@</span>{{ item.opponent }}</td>

                <td style="text-align:right;">{{ item.receiving_targets }}</td>
                <td style="text-align:right;">{{ item.receptions }}</td>

                <td style="text-align:right;">{{ item.receiving_yards }}</td>
                <td style="text-align:right;">{{ item.receiving_touchdowns }}</td>

                <td style="text-align:right;">{{ item.rushing_attempts }}</td>
                <td style="text-align:right;">{{ item.rushing_yards }}</td>
                <td style="text-align:right;">{{ item.rushing_touchdowns }}</td>




                <td style="text-align:right;">{{ item.fumbles_lost }}</td>
                <td style="text-align:right;">{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>

          <table
            v-if="player_data.position=='K' && player_data.player_game"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr class="label">
                <th>WK</th>
                <th>DATE</th>
                <th style="text-align:right;">OPP</th>

                <th style="text-align:right;">FGA</th>
                <th style="text-align:right;">FG</th>
                <th style="text-align:right;">XPATT</th>
                <th style="text-align:right;">FG19</th>
                <th style="text-align:right;">FG29</th>
                <th style="text-align:right;">FG39</th>
                <th style="text-align:right;">FG49</th>
                <th style="text-align:right;">FG50</th>
                <th style="text-align:right;">FPTS</th>
              </tr>
              <tr v-for="item in player_data.player_game">
                <td style="text-align:right;">{{ item.week }}</td>
                <td>{{ item.game_date | moment("MM/DD/YYYY") }}</td>
                <td style="text-align:right;"><span v-if="item.home_or_away=='AWAY'">@</span>{{ item.opponent }}</td>


                <td style="text-align:right;">{{ item.field_goals_attempted }}</td>
                <td style="text-align:right;">{{ item.field_goals_made }}</td>
                <td style="text-align:right;">{{ item.extra_points_attempted }}</td>
                <td style="text-align:right;">{{ item.field_goals_made0to19 }}</td>
                <td style="text-align:right;">{{ item.field_goals_made20to29 }}</td>
                <td style="text-align:right;">{{ item.field_goals_made30to39 }}</td>
                <td style="text-align:right;">{{ item.field_goals_made40to49 }}</td>
                <td style="text-align:right;">{{ item.field_goals_made50_plus }}</td>
                <td style="text-align:right;">{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>

          <table
            v-if="player_data.position=='TQB' && player_data.player_game"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr
                class="label superheader"
                style="border-bottom: 2px solid #000 !important"
              >
                <th colspan="3" />
                <th
                  colspan="5"
                  style="text-align:center;"
                >
                  <div>PASSING</div>
                </th>
                <th
                  colspan="3"
                  style="text-align:center;"
                >
                  <div>Rushing</div>
                </th>

                <th colspan="1" />
              </tr>
              <tr class="label">
                <th>WK</th>
                <th>DATE</th>
                <th style="text-align:right;">OPP</th>
                <th style="text-align:right;">CMP</th>
                <th style="text-align:right;">ATT</th>


                <th style="text-align:right;">YDS</th>
                <th style="text-align:right;">TD</th>
                <th style="text-align:right;">INT</th>
                <th style="text-align:right;">ATT</th>
                <th style="text-align:right;">YD</th>
                <th style="text-align:right;">TD</th>

                <th style="text-align:right;">FPTS</th>
              </tr>
              <tr v-for="item in player_data.player_game">
                <td style="text-align:right;">{{ item.week }}</td>
                <td>{{ item.game_date | moment("MM/DD/YYYY") }}</td>
                <td style="text-align:right;"><span v-if="item.home_or_away=='AWAY'">@</span>{{ item.opponent }}</td>

                <td style="text-align:right;">{{ item.passing_completions }}</td>
                <td style="text-align:right;">{{ item.passing_attempts }}</td>

                <td style="text-align:right;">{{ item.passing_yards }}</td>
                <td style="text-align:right;">{{ item.passing_touchdowns }}</td>
                <td style="text-align:right;">{{ item.passing_interceptions }}</td>
                <td style="text-align:right;">{{ item.rushing_attempts }}</td>
                <td style="text-align:right;">{{ item.rushing_yards }}</td>
                <td style="text-align:right;">{{ item.rushing_touchdowns }}</td>

                <td style="text-align:right;">{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>



          <table
            v-if="player_data.position=='DEF' && player_data.fantasy_defense_game"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr class="label">
                <th>WK</th>
                <th>DATE</th>
                <th style="text-align:right;">OPP</th>
                <th style="text-align:right;">SACK</th>
                <th style="text-align:right;">DTD</th>
                <th style="text-align:right;">STY</th>
                <th style="text-align:right;">INT</th>


                <th style="text-align:right;">DFR</th>
                <th style="text-align:right;">PA</th>
                <th style="text-align:right;">FPTS</th>
              </tr>
              <tr v-for="item in player_data.fantasy_defense_game">
                <td style="text-align:right;">{{ item.week }}</td>
                <td>{{ item.date | moment("MM/DD/YYYY") }}</td>
                <td style="text-align:right;"><span v-if="item.home_or_away=='AWAY'">@</span>{{ item.opponent }}</td>
                <td style="text-align:right;">{{ item.sacks }}</td>

                <td style="text-align:right;">{{ item.touchdowns_scored }}</td>
                <td style="text-align:right;">{{ item.safeties }}</td>
                <td style="text-align:right;">{{ item.interceptions }}</td>


                <td style="text-align:right;">{{ item.fumbles_recovered }}</td>
                <td style="text-align:right;">{{ item.points_allowed }}</td>

                <td style="text-align:right;">{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>





          <table
            v-if="player_data.position=='ST' && player_data.player_game"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr class="label">
                <th>WK</th>
                <th>DATE</th>
                <th style="text-align:right;">OPP</th>

                <th style="text-align:right;">PUNT</th>
                <th style="text-align:right;">TD</th>

                <th style="text-align:right;">KICK</th>
                <th style="text-align:right;">TD</th>


                <th style="text-align:right;">FG</th>
                <th style="text-align:right;">XP</th>
                <th style="text-align:right;">PUNT</th>


                <th style="text-align:right;">FPTS</th>
              </tr>
              <tr v-for="item in player_data.player_game">
                <td style="text-align:right;">{{ item.week }}</td>
                <td>{{ item.date | moment("MM/DD/YYYY") }}</td>
                <td style="text-align:right;"><span v-if="item.home_or_away=='AWAY'">@</span>{{ item.opponent }}</td>
                <td style="text-align:right;">{{ item.punt_return_yards }}</td>
                <td style="text-align:right;">{{ item.punt_return_touchdowns }}</td>

                <td style="text-align:right;">{{ item.kick_return_yards }}</td>
                <td style="text-align:right;">{{ item.kick_return_touchdowns }}</td>


                <td style="text-align:right;">{{ item.field_goals_had_blocked }}</td>
                <td style="text-align:right;">{{ item.extra_points_had_blocked }}</td>
                <td style="text-align:right;">0</td>

                <td style="text-align:right;">{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </b-tab>
      <b-tab title="Fantasy Trends">
        <div class="tabcontent">
          <div class="chart-container">
            <div class="featureComponentContainer">
              <div class="featureTitle"><div class="leftUnderline"><span class="boldText">Fantasy</span> Points By Week</div><div class="rightUnderline">&nbsp;</div></div>
            </div>
            <fantasy-trends
              v-if="loaded && datacollection"
              :chart-data="datacollection"
            />

            <div class="legend">
              <div class="item">
                <div class="key fig0" />
                <div class="text"><span v-if="player_data.player_season && player_data.player_season[0]"> {{ player_data.player_season && player_data.player_season[0].season }} </span> ACTUAL FANTASY PTS</div>
              </div>
              <div class="item">
                <div class="key fig2" />
                <div class="text">PROJ FANTASY PTS</div>
              </div>
            </div>

            <div class="featureFooter"><div style="text-align:center;color:#94a1a9;font-weight:normal;font-size:10px"><sup>*</sup> Indicates player did not play that week</div></div>
          </div>
        </div>
      </b-tab>
      <b-tab
        title="Stats"
        @click="selectTab(2)">
        <div class="tabcontent">
          <table
            v-if="(player_data.position=='WR' || player_data.position=='TE') && player_data.player_game"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr
                class="label superheader"
                style="border-bottom: 2px solid #000 !important"
              >
                <th colspan="3" />
                <th
                  colspan="4"
                  style="text-align:center;"
                >
                  <div>Receiving</div>
                </th>
                <th
                  colspan="3"
                  style="text-align:center;"
                >
                  <div>Rushing</div>
                </th>
                <th
                  colspan="1"
                  style="text-align:right;"
                >
                  <div>FUM</div>
                </th>
                <th colspan="1" />
              </tr>
              <tr class="label">
                <th>SEASON</th>
                <th>TEAM</th>
                <th>G</th>

                <th style="text-align:right;">TAR</th>
                <th style="text-align:right;">REC</th>
                <th style="text-align:right;">YDS</th>

                <th style="text-align:right;">TD</th>
                <th style="text-align:right;">ATT</th>



                <th style="text-align:right;">YDS</th>
                <th style="text-align:right;">TD</th>
                <th style="text-align:right;">FL</th>
                <th style="text-align:right;">FPTS</th>
              </tr>
              <tr v-for="item in player_data.player_season">
                <td>{{ item.season }}</td>
                <td>{{ item.team }}</td>
                <td>{{ item.played }}</td>


                <td style="text-align:right;">{{ item.receiving_targets }}</td>
                <td style="text-align:right;">{{ item.receptions }}</td>

                <td style="text-align:right;">{{ item.receiving_yards }}</td>
                <td style="text-align:right;">{{ item.receiving_touchdowns }}</td>

                <td style="text-align:right;">{{ item.rushing_attempts }}</td>
                <td style="text-align:right;">{{ item.rushing_yards }}</td>
                <td style="text-align:right;">{{ item.rushing_touchdowns }}</td>

                <td style="text-align:right;">{{ item.fumbles_lost }}</td>
                <td style="text-align:right;">{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>


          <table
            v-if="(player_data.position=='RB') && player_data.player_season"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr
                class="label superheader"
                style="border-bottom: 2px solid #000 !important"
              >
                <th colspan="3" />
                <th
                  colspan="4"
                  style="text-align:center;"
                >
                  <div>Receiving</div>
                </th>
                <th
                  colspan="3"
                  style="text-align:center;"
                >
                  <div>Rushing</div>
                </th>
                <th
                  colspan="1"
                  style="text-align:right;"
                />
                <th colspan="1" />
              </tr>
              <tr class="label">
                <th>SEASON</th>
                <th>TEAM</th>
                <th>G</th>


                <th>ATT</th>
                <th>YDS</th>
                <th>TD</th>
                <th>TAR</th>
                <th>REC</th>
                <th>YDS</th>
                <th>TD</th>
                <td>FL</td>
                <th>FPTS</th>
              </tr>
              <tr v-for="item in player_data.player_season">
                <td>{{ item.season }}</td>
                <td>{{ item.team }}</td>
                <td>{{ item.played }}</td>
                <td>{{ item.rushing_attempts }}</td>
                <td>{{ item.rushing_yards }}</td>
                <td>{{ item.rushing_touchdowns }}</td>
                <td>{{ item.receiving_targets }}</td>
                <td style="text-align:right;">{{ item.receptions }}</td>
                <td style="text-align:right;">{{ item.receiving_yards }}</td>
                <td style="text-align:right;">{{ item.receiving_touchdowns }}</td>
                <td style="text-align:right;">{{ item.fumbles_lost }}</td>
                <td style="text-align:right;">{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>

          <table
            v-if="(player_data.position=='TQB') && player_data.player_season"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr
                class="label superheader"
                style="border-bottom: 2px solid #000 !important"
              >
                <th colspan="3" />
                <th
                  colspan="5"
                  style="text-align:center;"
                >
                  <div>Receiving</div>
                </th>
                <th
                  colspan="3"
                  style="text-align:center;"
                >
                  <div>Rushing</div>
                </th>
                <th />
                <th>FPTS</th>
                </th>
              </tr>
              <tr class="label">
                <th>SEASON</th>
                <th>TEAM</th>
                <th>G</th>
                <th>ATT</th>
                <th>COMP</th>

                <th>YDS</th>
                <th>TD</th>
                <th>INT</th>
                <th>ATT</th>
                <th>YDS</th>
                <th>TD</th>
                <td>FL</td>
                <th>FPTS</th>
              </tr>
              <tr v-for="item in player_data.player_season">
                <td>{{ item.season }}</td>
                <td>{{ item.team }}</td>
                <td>{{ item.played }}</td>
                <td>{{ item.passing_attempts }}</td>

                <td>{{ item.passing_completions }}</td>
                <td>{{ item.passing_yards }}</td>
                <td>{{ item.passing_touchdowns }}</td>
                <td>{{ item.passing_interceptions }}</td>
                <td>{{ item.rushing_attempts }}</td>
                <td>{{ item.rushing_yards }}</td>
                <td>{{ item.rushing_touchdowns }}</td>
                <td style="text-align:center;">{{ item.fumbles_lost }}</td>
                <td>{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>




          <table
            v-if="(player_data.position=='K') && player_data.player_season"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr
                class="label superheader"
                style="border-bottom: 2px solid #000 !important"
              >
                <th colspan="3" />
                <th
                  colspan="5"
                  style="text-align:center;"
                >
                  <div>FIELD GOALS</div>
                </th>
                <th
                  colspan="1"
                  style="text-align:center;"
                >
                  <div>EXTRA POINTS</div>
                </th>

                <th>FPTS</th>
                </th>
              </tr>
              <tr class="label">
                <th>SEASON</th>
                <th>TEAM</th>
                <th>G</th>
                <th>10-19</th>
                <th>20-29</th>

                <th>30-39</th>
                <th>40-49</th>
                <th>50+</th>

                <td />
                <th>FPTS</th>
              </tr>
              <tr v-for="item in player_data.player_season">
                <td>{{ item.season }}</td>
                <td>{{ item.team }}</td>
                <td>{{ item.played }}</td>
                <td>{{ item.field_goals_made0to19 }}</td>

                <td>{{ item.field_goals_made20to29 }}</td>
                <td>{{ item.field_goals_made30to39 }}</td>
                <td>{{ item.field_goals_made40to49 }}</td>
                <td>{{ item.field_goals_made50_plus }}</td>
                <td style="text-align:center;">{{ item.extra_points_made }}</td>

                <td>{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>

          <table
            v-if="(player_data.position=='DEF') && player_data.fantasy_defense_season"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr
                class="label superheader"
                style="border-bottom: 2px solid #000 !important"
              >
                <th colspan="5" />
                <th
                  colspan="2"
                  style="text-align:center;"
                >
                  <div>TURNOVERS</div>
                </th>
                <th
                  colspan="1"
                  style="text-align:center;"
                >
                  <div>ALLOWED</div>
                </th>

                <th>FPTS</th>
                </th>
              </tr>
              <tr class="label">
                <th>SEASON</th>
                <th>TEAM</th>
                <th>G</th>
                <th>TD</th>
                <th>SACK</th>

                <th>INT</th>
                <th>FUM</th>
                <th />
              </tr>
              <tr v-for="item in player_data.fantasy_defense_season">
                <td>{{ item.season }}</td>
                <td>{{ item.team }}</td>
                <td>{{ item.games }}</td>	<td>{{ item.touchdowns_scored }}</td>
                <td>{{ item.sacks }}</td>
                <td>{{ item.interceptions }}</td>
                <td>{{ item.fumbles_recovered }}</td>

                <td style="text-align:right;">{{ item.fumbles_recovered }}</td>

                <td>{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>

          <table
            v-if="(player_data.position=='ST') && player_data.player_season"
            class="table b-table table-striped table-hover table-sm"
            style="width:100%;"
          >
            <tbody>
              <tr
                class="label superheader"
                style="border-bottom: 2px solid #000 !important"
              >
                <th colspan="3" />
                <th
                  colspan="2"
                  style="text-align:center;"
                >
                  <div>PUNT RETURNS</div>
                </th>
                <th
                  colspan="2"
                  style="text-align:center;"
                >
                  <div>KICK RETURNS</div>
                </th>
                <th
                  colspan="3"
                  style="text-align:center;"
                >
                  <div>BLOCKS</div>
                </th>
                <th>FPTS</th>
                </th>
              </tr>
              <tr class="label">
                <th>SEASON</th>
                <th>TEAM</th>
                <th>G</th>
                <th>YDS</th>
                <th>TD</th>

                <th>YDS</th>
                <th>TD</th>
                <th>FG</th>
                <th>XP</th>
                <th>PUNT</th>
                <th />
              </tr>
              <tr v-for="item in player_data.player_season">
                <td>{{ item.season }}</td>
                <td>{{ item.team }}</td>
                <td>{{ item.played }}</td>
                <td>{{ item.punt_return_yards }}</td>
                <td>{{ item.punt_return_touchdowns }}</td>
                <td>{{ item.kick_return_yards }}</td>
                <td>{{ item.kick_return_touchdowns }}</td>
                <td>{{ item.field_goals_had_blocked }}</td>
                <td>{{ item.extra_points_had_blocked }}</td>
                <td>{{ item.punts_had_blocked }}</td>

                <td>{{ item.fantasy_points_acme|changeFormat }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </b-tab>

      <template slot="tabs-end">
        <div
          class="pull-right"
          v-if="showButtonsMaster"
        >
          <li class="nav-item-last">
            <!-- TODO: This needs better logic -->
<!--             <b-btn
              v-if="max_reached && added != 1 && !showAddToBenchButton()"
              size="sm"
              variant="primary"
              :disabled="true"
            >
              Team Max Reached
            </b-btn> -->

            <!-- Logged in User Draft ("Add") Available Player -->
             <b-button
              v-if="showAddButton()"
              size="small"
              :disabled="checkDisabled(playerResponse.player_data)"
              @click="addPlayer()"
              ><b-icon
                icon="person-plus"
                aria-hidden="true"
              ></b-icon> Add</b-button>

            <!-- Logged in User Add to Bench ("Add") Available Player -->
            <b-button
                    v-if="showAddToBenchButton()"
                    size="small"
                    :disabled="checkDisabled(playerResponse.player_data)"
                    @click="addPlayer(true)"
            ><b-icon
                    icon="person-plus"
                    aria-hidden="true"
            ></b-icon> Add Backup to Bench</b-button>



            <b-btn
              v-if="max_reached && claim_request !== 1 && remove === 0 && draftComplete && !showAddToBenchButton()"
              size="sm"
              variant="primary"
              :disabled="max_reached"
              @click="addPlayer(); componentKey++;"
            >Max Reached
            </b-btn>

            <b-btn
              v-if="draftComplete && (!max_reached && waiver_period_enabled === 1 && !claim_request && owned_by === '' )||(selected_claim_player > 0 && waiver_period_enabled === 1 && owned_by === '') "
              size="sm"
              variant="primary"
              @click="claimPlayer(); componentKey++;"
            >
              Submit Claim Request
            </b-btn>

            <b-btn
              v-if="waiver_period_enabled === 1 && claim_request === 1"
              size="sm"
              variant="primary"
              :disabled="claim_request === 1"
            >
              Claim Requested
            </b-btn>

            <b-btn
              v-if="claim_removed ==1"
              size="sm"
              variant="danger"
              @click="removeClaimPlayer(); componentKey++;"
            >
              Remove Claim
            </b-btn>

            <b-btn
              v-if="not_allowed == 1 "
              size="sm"
              variant="primary"
            >
              Not allowed. Matches another team.
            </b-btn>


<!--             <b-btn
              v-if="curUserId != '' && user_id != curUserId && commissioner && remove == 0"
              size="sm"
              variant="primary"
              :disabled="added == 1"
              @click="addPlayer(); componentKey++;"
            >
              Draft for user
            </b-btn> -->


            <b-btn
              v-if="showDropButton()"
              size="sm"
              variant="danger"
              @click="removePlayer(); componentKey++;"
            >
              Drop
            </b-btn>


            <b-btn
              v-if="showBenchButton()"
              size="sm"
              variant="primary"
              @click="playerTransaction(playerResponse.player_data.id, 8);"
            >
              Move to Bench
            </b-btn>
            <b-btn
              v-if="showMoveToStarterButton()"
              size="sm"
              variant="primary"
              @click="playerTransaction(playerResponse.player_data.id, 9);"
            >
              Move to Starter
            </b-btn>

            <b-form-select
              v-if="claim_players_count && remove == 0 && waiver_period_enabled==1 && owned_by=='' && claim_removed !=1 && draftComplete && !showAddToBenchButton()"
              v-model="selected_claim_player"
              @change="changeLocation($event)"
              size="sm"
              style="max-width: 125px;"
            >
              <b-form-select-option :value="0">Drop player if claim approved..</b-form-select-option>
              <b-form-select-option
                v-for="option in claim_players"
                :key="option.id"
                :value="option.id"
              >
                {{ option.name }}
              </b-form-select-option>
            </b-form-select>
          </li>
        </div>
      </template>
    </b-tabs>




    {{ fantasy_trends }}
  </b-modal>
</template>

<style>



</style>

<script>
import FantasyTrends from './FantasyTrends.js'

export default {
	components: {

		FantasyTrends

    },
	filters:{
		changeFormat:function(value){
			return Number.parseFloat(value).toFixed(2);
		}
	},
	props:{
    week: {required: false},
    player_id: { required: false },
    // playerData: { required: false},
	  team_qb: { required: false },
	  commissioner: { required: false },
	  user_id: { required: false },
	  showModal: {required: false, default: false},
	  team_two_id: { required: false },
    showButtons: {required: false, default: true},
    draftComplete: {type: Boolean, required: false, default: false},
    enableCommissionerMode: {type: Boolean, default: false}
    },
	data () {
      return {
        playerResponse: {
          player_data: {
            fantasy_team_owned_by:{}
          },
          user_fantasy_team_roster: {}
        },
        loaded: false,
        player_data:'',
        curUserId:'',
        componentKey:0,
        watched:'',
        experience: '',
        fantasy_draft_name: '',
        fantasy_position: '',
        photo_url: '',
        target: '',
        record: '',
        added: '',
        not_allowed: '',
        available: '',
        max_reached: true,
        remove: '',
        owned_by: '',
        show: false,
        items:[],
        game_log:[],
        stats_items:[],
        current_tab:1,
        player_injuries:[],
        claim_players:[],
        waiver_period_enabled: '',
        claim_request:'',
        claim_removed:'',
        claim_players_count:'',
        selected_claim_player:null,
        datacollection: '',
        fantasy_trends:'',
        system_season:'',
        draft_completed:0,
        ignore_game_stated: false
      }
	},
  computed: {

    showButtonsMaster() {
      if(this.$store.state.systemSettings.season_type == 1)
        return this.showButtons

      return false;
    },

    leagueWeek() {
      return this.$store.state.systemSettings.week
    },

    draftData() {
      return this.$store.state.leagueDraftData;
    },

    userFantasyTeam() {
      return this.$store.state.userFantasyTeam;
    },
  },
	watch: {
		showModal: function(newRequest, oldRequest) {
			this.getPlayerDetail();
      this.getUserFantasyTeamRoster();
			this.selected_claim_player=0
			this.show = newRequest
			//this.getClaimPlayers();
		},

    },
	methods: {
    // player_injuries

    // Check that player is on bench.
    showMoveToStarterButton()
    {
      if(this.userFantasyTeam.id === this.playerResponse.player_data.fantasy_team_owned_by.fantasy_team_id && this.playerResponse.player_data.fantasy_team_owned_by.bench === 1 && this.draftComplete)
        return true;

      return false
    },

    showAddToBenchButton()
    {
      let player = this.playerResponse.player_data;
      let show = false;

      if(!player.position)
        show = false;

      // if(this.waiver_period_enabled === 1)
      //   return false;

      if(player.fantasy_team_owned_by.fantasy_team_id === this.userFantasyTeam.id)
        show = false;

      if(!player.fantasy_team_owned_by.id && !this.enableCommissionerMode){
        console.log('step 1')
        let position = this.userFantasyTeam.position[player.position];

        // console.log(this.userFantasyTeam.injuries);
        // console.log(this.userFantasyTeam.injuries[player.position])
        let positionCheck = this.userFantasyTeam.injuries[player.position];

        let teamCheck = false;

        if(positionCheck)
          teamCheck = this.userFantasyTeam.injuries[player.position][player.team.key];

        console.log('teamCheck ', teamCheck);
        // If we have an injured position we need to only show the straight to bench button for the specific players on the same team when it is not covered (i.e. no other backup in place)
        if(teamCheck)
        {
          console.log('step 2');

          if(!teamCheck.covered)
            show = true;
        }
      }

      console.log('showAddToBenchButton(), ', show);
      return show;
    },

    // Original if statement:
    // if(playerResponse.player_data.fantasy_team_owned_by && !playerResponse.player_data.fantasy_team_owned_by.id && !userFantasyTeam.position[playerResponse.player_data.position].maxReached && !enableCommissionerMode && added == 0 && remove == 0 && max_reached == 0 && not_allowed == 0 && waiver_period_enabled!=1
    showAddButton()
    {
      console.log('start');
      let player = this.playerResponse.player_data;

      if(!player.position)
        return false;

      if(this.waiver_period_enabled === 1)
        return false;

      if(player.fantasy_team_owned_by.fantasy_team_id === this.userFantasyTeam.id)
        return false;

      if(!player.fantasy_team_owned_by.id && !this.userFantasyTeam.position[player.position].maxReached && !this.enableCommissionerMode){
        return true;
      }

      let position = this.userFantasyTeam.position[player.position];
      let positionCheck = this.userFantasyTeam.injuries[player.position];
      // If we have an injured position we need to only show the add button for the specific player on the same team
      // player.team is the whole "Team" object. Use the key value to check

      // This is for injured players
      // if(positionCheck) {
      //   if(positionCheck[player.team.key])
      //     return true;
      //   else
      //     return false;
      // }

      return false;
    },
    //
    showBenchButton()
    {
      // if(this.remove == 1 && this.claim_removed !=1)
      //   return true;
      if(this.playerResponse.player_data.fantasy_team_owned_by.fantasy_team_id === this.userFantasyTeam.id){
        // console.log('1')

        // If the player is on the bench, don't show the bench button.
        // if(this.playerResponse.player_data.fantasy_team_owned_by.bench === 1)
        //   console.log('2');return false;
        if(this.showMoveToStarterButton()){
          // console.log('2');
          return false;

        }


        // If the game started don't allow any moves
        if(this.playerResponse.player_data.current_player_game){
          // console.log('3')
          if(this.playerResponse.player_data.current_player_game.started && !this.ignore_game_stated){
            return false;
          }
        }
        // If the player does not have injuries don't allow it.
        // 09/20/20 Disabled because we should allow them to move to bench
        // if(!this.playerResponse.player_injuries){
        //   console.log('4')
        //   return false;
        // }

        // console.log('4')
        return true;
      }

      // console.log('5')
      // Not owned by the player do not show the button
      return false;
    },

    showDropButton()
    {
      // if(this.remove == 1 && this.claim_removed !=1)
      //   return true;
      if(this.playerResponse.player_data.fantasy_team_owned_by.fantasy_team_id === this.userFantasyTeam.id){
        // console.log('step1 ');
        if(this.playerResponse.player_data.current_player_game){
          // console.log('step 2 ');
          if(this.playerResponse.player_data.current_player_game.started && !this.ignore_game_stated)
            return false;
        }
        // console.log('step3 ');
        return true;
      }
// console.log('step4 ');
      return false;
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
    checkDisabled(player)
    {
      if(this.draftComplete)
        return false // return player.fantasy_team_owned_by.id != this.userFantasyTeam.id
      else
        return this.userFantasyTeam.id != this.draftData.currentDraft.fantasy_team_id
    },

		fillData () {
			if(this.player_data){
				var projection_points = $.map(this.player_data.fantasy_player_game_projection, function(v){
					return v.fantasy_points_acme;
				})

				var player_game_points = $.map(this.player_data.player_game, function(v){
					return v.fantasy_points_acme;
				})

				this.datacollection = {
					options: {
						height:206,
						legend: {
							display: false
						}
					},
					labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8', 'Week 9', 'Week 10', 'Week 11', 'Week 12', 'Week 13', 'Week 14', 'Week 15', 'Week 16','Week 17'],
					datasets: [
						{
							label: 'ACTUAL FANTASY PTS',
							backgroundColor: '#228B22',
							data: player_game_points
						},
						{
							label: 'PROJ FANTASY PTS',
							backgroundColor: '#D3D3D3',
							data: projection_points
						}
					]
				}
			}
		},
		onHidden(evt) {
			this.$emit('update:showModal', false)
		},
		changeLocation(event) {
			this.selected_claim_player=event.target.value;
		},
		getPlayerDetail(){
      // console.log('getPlayerDetail')
			axios.get('/player_eloquent',{
			params: {
				player_id: this.player_id
			  }
			})
			.then((response)=>{
        this.playerResponse = response.data;
				this.photo_url 					=response.data.photo_url;
				this.experience 				=response.data.experience;
				this.fantasy_position 			=response.data.fantasy_position;
				this.fantasy_draft_name 		=response.data.fantasy_draft_name;
				this.target 					=response.data.target;
				this.record 					=response.data.record;
				this.added 						=response.data.added;
				this.not_allowed				=response.data.not_allowed;
				this.available 					=response.data.available;
				this.max_reached 				=response.data.max_reached;
				this.remove 					=response.data.remove;
				this.owned_by 					=response.data.owned_by;
				this.is_player_def 				=response.data.is_def;
				this.is_player_st				=response.data.is_st;
				this.is_player_team_qb 			=response.data.team_qb;
				this.watched 					=response.data.watched;
				this.game_log 					=response.data.game_log;
				this.stats_items 			    =response.data.game_stats;
				this.player_injuries 			=response.data.player_injuries;
				this.claim_request 				=response.data.claim_request;
				this.claim_removed 				=response.data.claim_removed;
				this.waiver_period_enabled 		=response.data.waiver_period_enabled;
				this.claim_players 				=response.data.claim_players;
				this.claim_players_count 		=response.data.claim_players_count;
				this.player_data 				=response.data.player_data;
				this.fantasy_trends 			=response.data.fantasy_trends;
				this.system_season 				=response.data.system_season;
				this.draft_completed			=response.data.draft_completed;
				this.fillData();
				this.loaded = true;
			})
			.catch(error => {});
		},
		selectTab(selectedTab) {
			if(selectedTab ==1 ){
				this.items 					=this.player_data;
				this.current_tab=1;
			}
			else{
				this.items 					=this.player_data;
				this.current_tab=2;
			}
		},
		watchPlayer() {
			axios.post('/players/player-transaction',{
				player_id: this.player_id,
				transaction_id: 4,
				is_def: this.is_player_def,
				is_st: this.is_player_st,
				team_qb: this.is_player_team_qb
			},
			{
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
			})
			.then((response)=>{
				this.watched = 1;
				this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});
			})
			.catch(error => {});

		},
		addPlayer(isAddToBench = false) {

            let transType = isAddToBench ? 11 : 1;  // If we are adding to the bench then make it 11. Otherwise, a 1
            // console.log(transType);
            // return;
			axios.post('/players/player-transaction',{
				player_id: this.player_id,
				transaction_id: transType,
				is_def: this.is_player_def,
				is_st: this.is_player_st,
				team_qb: this.is_player_team_qb
			})
			.then((response)=>{
        this.getUserFantasyTeamRoster();
				this.added = 1;
				this.available = 'No';
				this.remove = 1;
				this.owned_by = response.data.owned_by;

              if(response.data.success){
                this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});

              }else{
                this.$store.dispatch('showSnackBarFailure',{message:response.data.message});
              }

			})
			.catch(error => {});

		},
		unWatchPlayer(){
			axios.put('/players/unwatch',{
				player_id: this.player_id,
				is_def: this.is_player_def,
				is_st: this.is_player_st,
				team_qb: this.is_player_team_qb
			},
			{
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
			})
			.then((response)=>{
				this.watched = 0;

				this.$store.dispatch('showSnackBarSuccess',{message:response.data});
			})
			.catch(error => {});

		},

		removePlayer(){
		  return this.playerTransaction(this.player_id, 2);
			// axios.put('/players/remove',{
			// 	player_id: this.player_id,
			// 	is_def: this.is_player_def,
			// 	is_st: this.is_player_st,
			// 	team_qb: this.is_player_team_qb
			// },
			// {
			// 	headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
			// })
			// .then((response)=>{
			// 	this.remove = 0;
			// 	this.added  = 0;
			// 	this.available  = 'Yes';
			// 	this.owned_by  = '';
            //
			// if(response.data.status==1){
			// 	this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});
            //
			// }else{
			// 	this.$store.dispatch('showSnackBarFailure',{message:response.data.message});
			// }
            //
			// })
			// .catch(error => {});

		},
		claimPlayer() {
			axios.post('/players/player-transaction',{
				player_id: this.player_id,
				transaction_id: 5,
				claim_request:1,
				conditional_drop: this.selected_claim_player,
				is_def: this.player_is_def,
				is_st: this.player_is_st,
				team_qb: this.player_team_qb,
				waiver_period_enabled:this.waiver_period_enabled
			})
			.then((response)=>{
				this.added = 1;
				this.claim_request=1;
				this.claim_removed=1;
				this.selected_claim_player= 0;
				this.available = 'No';
				this.remove = 1;
				this.owned_by = response.data.owned_by;
				this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});


			}).catch(error => {});
		},
		removeClaimPlayer(){
			// axios.post('/players/remove-claim-player',{
			// 	player_id: this.player_id,
			// 	is_def: this.is_def,
			// 	is_st: this.is_st,
			// 	team_qb: this.team_qb
			// },
			// {
			// 	headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
			// })
            axios.post('/players/player-transaction',{
              player_id: this.player_id,
              transaction_id: 10,
              // claim_request:1,
              waiver_period_enabled:this.waiver_period_enabled
            })
			.then((response)=>{
				this.claim_removed=0;
				this.remove = 0;
				this.claim_request='';
				this.added  = 0;
				this.available  = 'Yes';
				this.owned_by  = '';

			if(response.data.success == 1){
				this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});

			}else{
				this.$store.dispatch('showSnackBarFailure',{message:response.data.message});
			}

			})
			.catch(error => {});

		},

        // 1=add 2=drop 3=trade 4=watch 5=claim, 6=claim reject 7=claim approve, 8=active to bench, 9=bench to active
    playerTransaction(player_id, transaction_id, fantasy_team_id = null) {
      axios
        .post("/players/player-transaction", {
          player_id: this.player_id,
          transaction_id: transaction_id,
          fantasy_team_id: fantasy_team_id,
        })
        .then((response) => {
          if (response.data.success) {
            console.log("success player transacton");
            // Get the new roster for the user since it has changed.
            //this.getUserFantasyTeamRoster();
            this.$store.dispatch("showSnackBarSuccess", {
              message: response.data.message,
            });
            this.getPlayerDetail();
          } else {
            console.log("fail player transaction");
            this.$store.dispatch("showSnackBarFailure", {
              message: response.data.message,
            });
          }
        })
        .catch((error) => {});
    },
		addBenchPlayer(){
			axios.post('/players/bench-player',{
				player_id: this.player_id,
				is_def: this.is_player_def,
				is_st: this.is_player_st,
				team_qb: this.is_player_team_qb
			},
			{
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
			})
			.then((response)=>{

				this.owned_by = response.data.owned_by;

				if(response.data.already_added==1){
				this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});

				}else{
				this.$store.dispatch('showSnackBarFailure',{message:response.data.message});
				}


			})
			.catch(error => {});
		},
		addTQB(){
			axios.post('/players/tqb-player',{
				player_id: this.player_id,
				is_def: this.is_player_def,
				is_st: this.is_player_st,
				team_qb: this.is_player_team_qb

			},
			{
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
			})
			.then((response)=>{

				this.added = 1;
				this.remove = 1;
				this.owned_by = response.data.owned_by;

				if(response.data.already_added==1){
				this.$store.dispatch('showSnackBarSuccess',{message:response.data.message});

				}else{
				this.$store.dispatch('showSnackBarFailure',{message:response.data.message});
				}


			})
			.catch(error => {});
		},
	}
}
</script>
