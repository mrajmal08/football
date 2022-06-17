import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
import snackbar from './modules/snackbar'
const store = new Vuex.Store({
	modules: {

    snackbar,

  },

	state: {
		projection:0,
		inter:null,
		offenseTeam: [],
		kickersTeam: [],
		defenseTeam: [],
		specialTeam: [],
		fantasyTeamPlayers: [],
		fantasyTeamList: [],
		myTeamList: [],
		leagueDraftList: [],
		// loadDraftTeamslist:[],
		//leagueRoundDraftList: [],
		leagueDraftData: {
		  draftRoundData: [ ],
		  currentDraft: null,
		  league: {},
		  message: "",
		  user_team_id: 0,
		  on_clock_audio: false
		},
		snackbar: {
		  show: false,
		  color: 'error',
		  text: ''
		},
		//playersListArray:[],
		isLoading:'',
		fantacyPLayer: [],

		// Organized and confirmed using for 2020
		userFantasyTeam: {}, // Used in the PlayersTable and the Draft Room
		playerList:[],  // Used in the PlayersTable
		systemSettings: {},
    playoffsShowAllFantasyTeams: false
	},
	getters: {
		fantacyPLayer: state => state.fantacyPLayer,
		systemSettings: state => state.systemSettings,
    leagueDraftData: state => state.leagueDraftData,
		offenseTeam: state => state.offenseTeam,
		kickersTeam: state => state.kickersTeam,
		defenseTeam: state => state.defenseTeam,
		specialTeam: state => state.specialTeam,
		fantasyTeamList: state => state.fantasyTeamList,
		myTeamList:  state => state.myTeamList,
		leagueDraftList: state => state.leagueDraftList,
		// loadDraftTeamslist: state => state.loadDraftTeamslist,
		leagueRoundDraftList: state => state.leagueRoundDraftList,
		playerList: state => state.playerList,
		//playersListArray: state => state.playersListArray,
		isLoading: state => state.isLoading,
		countoffenseTeam: state => {
			return state.offenseTeam.length
		},
		getFantasyPlayers:(state) => (id) => {

			 return state.offenseTeam.filter(offenseTeams => offenseTeams.fantasy_team_id === id && offenseTeams.active === 1).
					concat(state.kickersTeam.filter(kickersTeams => kickersTeams.fantasy_team_id === id && kickersTeams.active === 1)).
					concat(state.defenseTeam.filter(defenseTeams => defenseTeams.fantasy_team_id === id && defenseTeams.active === 1)).
					concat(state.specialTeam.filter(specialTeams => specialTeams.fantasy_team_id === id && specialTeams.active === 1))


		}
		,
		getBenchFantasyPlayers:(state) => (id) => {
			 return state.offenseTeam.filter(offenseTeams => offenseTeams.fantasy_team_id == id && offenseTeams.bench == 1).
					concat(state.kickersTeam.filter(kickersTeams => kickersTeams.fantasy_team_id == id && kickersTeams.bench === 1)).
					concat(state.defenseTeam.filter(defenseTeams => defenseTeams.fantasy_team_id == id && defenseTeams.bench === 1)).
					concat(state.specialTeam.filter(specialTeams => specialTeams.fantasy_team_id == id && specialTeams.bench === 1))
		},
		getPlayer:(state) => (id) => {
			 return state.offenseTeam.filter(offenseTeams => offenseTeams.fantasy_player.player_id === id ).
					concat(state.kickersTeam.filter(kickersTeams => kickersTeams.fantasy_player.player_id === id)).
					concat(state.defenseTeam.filter(defenseTeams => defenseTeams.fantasy_player.player_id === id)).
					concat(state.specialTeam.filter(specialTeams => specialTeams.fantasy_player.player_id === id))
		},
		 getoffenseTeamBenchPlayer:(state) => (id) => {
			 return state.offenseTeam.filter(offenseTeams => offenseTeams.bench === 1)
		},
		 getkickersTeamBenchPlayer:(state) => (id) => {
			 return state.kickersTeam.filter(kickersTeam => kickersTeam.bench === 1)
		},
		 getdefenseTeamBenchPlayer:(state) => (id) => {
			 return state.defenseTeam.filter(defenseTeam => defenseTeam.bench === 1)
		},
		 getspecialTeamBenchPlayer:(state) => (id) => {
			 return state.specialTeam.filter(specialTeam => specialTeam.bench === 1)
		},
		 getoffenseTeamPlayer:(state) => (id) => {
			 return state.offenseTeam.filter(offenseTeams => offenseTeams.active === 1)
		},
		 getkickersTeamPlayer:(state) => (id) => {
			 return state.kickersTeam.filter(kickersTeam => kickersTeam.active === 1)
		},
		 getdefenseTeamPlayer:(state) => (id) => {
			 return state.defenseTeam.filter(defenseTeam => defenseTeam.active === 1)
		},
		 getspecialTeamPlayer:(state) => (id) => {
			 return state.specialTeam.filter(specialTeam => specialTeam.active === 1)
		},
		getkickerByeweekTeamPlayer:(state) => (week) => {
			 return state.kickersTeam.filter(kickersTeam => kickersTeam.fantasy_player.bye_week == week)
		},
		getoffenceByeweekTeamPlayer:(state) => (week) => {
			 return state.offenseTeam.filter(offenseTeam => offenseTeam.fantasy_player.bye_week == week)
		},
		getdeffenceByeweekTeamPlayer:(state) => (week) => {
			// console.log('getdeffenceByeweekTeamPlayer week:', week)
			 return state.defenseTeam.filter(defenseTeam => defenseTeam.fantasy_player.bye_week == week)
		},
		getspecialByeweekTeamPlayer:(state) => (week) => {
			 return state.specialTeam.filter(specialTeam => specialTeam.fantasy_player.bye_week == week)
		},
		getPopupTeamPlayer:(state) => (id) => {
        return state.playerList.filter(playerList => playerList.team ===id).sort(
        (a,b) => (a.fantasy_position_depth_order > b.fantasy_position_depth_order) ? 1 : ((b.fantasy_position_depth_order > a.fantasy_position_depth_order) ? -1 : 0))
			 // return state.playerList.filter(playerList => playerList.team ===id && playerList.injury_status != 'Out').sort(
			 // 	(a,b) => (a.fantasy_position_depth_order > b.fantasy_position_depth_order) ? 1 : ((b.fantasy_position_depth_order > a.fantasy_position_depth_order) ? -1 : 0))
		},


		getOfflineFantasyPlayer:(state) => {


		//console.log(state.fantacyPLayer);
			 return state.fantacyPLayer.filter(fantacyPLayer => fantacyPLayer.TQB.id ===95)
		},
	},
	mutations: {

    playoffsShowAllFantasyTeams(state, data) {
      state.playoffsShowAllFantasyTeams = data;
    },

		showSnackBarSuccess(state, data) {
			state.snackbar.show=true;
			state.snackbar.color 	= 'success';
			state.snackbar.text 	= data;

		},
		showSnackBarFailure(state, data) {
			state.snackbar.show=true;
			state.snackbar.color 	= 'error';
			state.snackbar.text 	= data;

		},
		loadFantasyTeamData(state, data) {

			state.offenseTeam 	= data.offenseTeams;
			state.kickersTeam 	= data.kickerTeams;
			state.defenseTeam 	= data.diffTeams;
			state.specialTeam 	= data.specialTeams;
			state.projection	= 1;
		},
		loadFantasyTeamData2(state, data) {

			state.offenseTeam 	= data.offenseTeams;
			state.kickersTeam 	= data.kickerTeams;
			state.defenseTeam 	= data.diffTeams;
			state.specialTeam 	= data.specialTeams;
			state.projection	= 0;
		},

		loadFantasyPlayer(state, data) {
			state.fantacyPLayer 	= data;
		},
		loadFantasyTeamTable(state, data) {
			state.fantasyTeamList 	= data;
		},
		loadMyTeamTable(state, data) {
			state.myTeamList 	= data;
		},
		loadLeagueDraftData(state, data) {
			state.leagueDraftData 	= data;
		},
    updateLeagueDraftData(state, data) {
      // console.log('updateLeagueDraftData mutation');
      //console.log('data is:', data.updatedItem)
      // console.log('state.leagueDraftData: ', state.leagueDraftData)
      //console.log('length is ',state.leagueDraftData.draftRoundData.length)

      //If we have ALL RECORDS, that means we need to start updating records
      if(state.leagueDraftData.draftRoundData.length === 108)
      {
        // console.log('we have draftRoundData. add it or update the array.')
         var index = state.leagueDraftData.draftRoundData.findIndex(function(item, i) {
            return item.id === data.updatedItem.id;
          });

        //console.log('index is ', index)
        state.leagueDraftData.draftRoundData = [
          ...state.leagueDraftData.draftRoundData.slice(0, index),
          data.updatedItem,
          ...state.leagueDraftData.draftRoundData.slice(index + 1)
        ]

        // Check to update currentDraft Data
        if(data.updatedItem.deadline){
          // console.info('Update currentDraft', data.updatedItem)
          Vue.set(state.leagueDraftData, 'currentDraft', data.updatedItem)
        }

      }
      else // Push the item on the end of the array and set the data so that we can show things...
      {
        console.log("try to push item on array")
        state.leagueDraftData.draftRoundData.push(data.updatedItem)

        // // Order the data based on the overall pick and insert the record at correct index.
        // let draftData = state.leagueDraftData.draftRoundData;
        // draftData.splice(data.updatedItem.league_overall_pick - 1, 0, data.updatedItem)

        // Update State
        state.leagueDraftData = { ...state.leagueDraftData, show_timer: true}
        // Vue.set(state.leagueDraftData, 'draftRoundData', [...draftData])

        if(data.updatedItem.deadline){
          // console.info('Update currentDraft', data.updatedItem)
          Vue.set(state.leagueDraftData, 'currentDraft', data.updatedItem)
        }
        // console.log('after push state is: ', state.leagueDraftData)
      }
    },
    updateLeagueData(state, league) {
      //console.log('data is:', league.data)
      Vue.set(state.leagueDraftData, 'league', league.data)
    },
		// loadDraftTeams(state, data) {

		// 	state.loadDraftTeamslist 	= data;
		// },
		loadLeagueRoundDraftPick(state, data) {
			state.leagueRoundDraftList 	= data;
		},
    userFantasyTeam(state, data)
    {
      state.userFantasyTeam = data;
    },

	systemSettings(state, data)
	{
		state.systemSettings = data;
	},
		setPlayerList(state, payload) {
			// this.playersArray = [];
			// data.forEach((value, key)=>{
			// 	this.playersArray.push(value['fantasy_player_key']);
			// })
      // Example if we need to add to the array... state.users = Object.freeze([...state.users, user]);
			state.playerList	= Object.freeze(payload);
      //console.log(payload);
      //state.playerList = [ ...state.playerList, payload ]
      //TODO: Look into if we need this. It keeps a list of the player_ids in an array.
			// state.playersListArray 	= this.playersArray;
			// state.isLoading 		= payload.isLoading;
      //commit('setLoading', false);
		},
    setLoading(state,payload) {
      state.isLoading = payload
    }
	},
	actions: {
    updateLeagueDraftData ({ commit, state }, record) {
      // console.log('called updateLeagueDraftData action with record: ', record)
      commit('updateLeagueDraftData',record)
  },
      updateLeagueData ({ commit, state }, league) {
      // console.log('called updateLeagueDraftData action with record: ', record)
      commit('updateLeagueData',league)
  },
		loadFantasyTeamData ({ commit }, { team_id, team_id2, week,season_type, season, projection }) {
			axios.get('/live-players',{
				params: {
				  team_id: team_id,
				  team_id2: team_id2,
				  week: week,
				  season_type: season_type,
				  season: season,
				}
			}).then((response)=>{
				commit('loadFantasyTeamData', response.data)
			});
			//TODO: Add polling or websocket
			// setInterval(function(){
			// 	axios.get('/live-players',{
			// 		params: {
			// 		  team_id: team_id,
			// 		  team_id2: team_id2,
			// 		  week: week,
			// 		  season_type: season_type,
			// 	  	  season: season,
			// 		}
			// 	})
			// 	.then((response)=>{
			// 		commit('loadFantasyTeamData', response.data)
			// 	});

			// }, 8000);
		} ,


		loadFantasyTeamData2 ({ commit, state }, { team_id, team_id2, week,season_type, season, projection }) {

			var load_data	=	'loadFantasyTeamData';
			if(state.inter != null)
				clearInterval(state.inter);

			if(projection == 1){
				load_data	=	'loadFantasyTeamData2';
			}

			axios.get('/live-players',{
				params: {
						  team_id: team_id,
						  team_id2: team_id2,
						  week: week,
						  season_type: season_type,
				  	  	  season: season,
						  projection: projection
						}
			}).then((response)=>{
				commit(load_data, response.data)
			});

			//TODO: Turn into websocket
			// state.inter	=	setInterval(function(){
			// 	axios.get('/live-players',{
			// 		params: {
			// 		  team_id: team_id,
			// 		  team_id2: team_id2,
			// 		  week: week,
			// 		  season_type: season_type,
			// 	  	  season: season,
			// 		  projection: projection
			// 		}
			// 	})
			// 	.then((response)=>{
			// 		commit(load_data, response.data)
			// 	});

			// }, 8000);

		},

		loadFantasyTeamTable({ commit }) {
			axios.get('/team/table-list')
			.then((response)=>{
				commit('loadFantasyTeamTable', response.data.teamData)
			});

			// var interval_team_list = setInterval(function(){
			// 	axios.get('/team/table-list')
			// 	.then((response)=>{
			// 		commit('loadFantasyTeamTable', response.data.teamData)
			// 		if (response.data.draftCompleted == 1){
			// 			clearInterval(interval_team_list);
			// 		}
			// 	});

			// }, 8000);
		} ,

		loadMyTeamTable({ commit }) {
			axios.get('/team/my-team')
			.then((response)=>{
				commit('loadMyTeamTable', response.data.teamData)
			});

			var interval_team = setInterval(function(){
				axios.get('/team/my-team')
				.then((response)=>{
					commit('loadMyTeamTable', response.data.teamData)
					if (response.data.draftCompleted == 1){
						clearInterval(interval_team);
					}
				});

			}, 10000);
		} ,

		loadLeagueDraftData({ commit,state }) {
            return new Promise((resolve, reject) => {
            // Do something here... lets say, a http call using vue-resource
            axios.get('/draft/league-draft-data').then(response => {
                // http success, call the mutator and change something in state
                commit('loadLeagueDraftData', response.data)
                resolve(response);  // Let the calling function know that http is done. You may send some data back
            }, error => {
                // http failed, let the calling function know that action did not work out
                reject(error);
            })
        })


			// axios.get('/draft/league-draft-pick')
			// .then((response)=>{

			// 	this.playerKey = [];
			// 	this.playerFan = [];
			// 	response.data.draftData.forEach((value, key)=>{
			// 		this.playerKey.push(value.fantasy_player_key);
			// 	})

			// 	state.playerList.forEach((value, key)=>{
			// 		this.playerKey.forEach((values)=>{
			// 			if(values == value['fantasy_player_key']){
			// 				value.available = 'No';
			// 			}
			// 		})
			// 	})
			// 	commit('loadLeagueRoundDraftPick', response.data.draftRoundData)
			// 	commit('loadLeagueDraftPick', response.data.draftData)
			// });
		} ,
		// loadDraftTeams({ commit,state }) {
		// 	axios.get('/team-list')
		// 	.then((response)=>{

		// 		commit('loadDraftTeams', response.data,this.isLoading )
		// 	});

		// 	// var interval_pick = setInterval(function(){
		// 	// 	axios.get('/team-list')
		// 	// 	.then((response)=>{

		// 	// 		commit('loadDraftTeams', response.data,this.isLoading )
		// 	// 		if (response.data.draftCompleted == 1){
		// 	// 			clearInterval(interval_pick);
		// 	// 		}
		// 	// 	});

		// 	// }, 1000);
		// } ,
		loadPlayerList({ dispatch, commit },{ selectedTeam, selectedPosition, status, season, seasonType, isProjection}) {
			commit('setLoading', true )
            // console.log("loadPlayerList called");
      return new Promise((resolve, reject) => {
            // Do something here... lets say, a http call using vue-resource
            axios.get('/players',{
           params: {
            selectedTeam: selectedTeam,
            selectedPosition: selectedPosition,
            status: status,
            season: season,
            seasonType: seasonType,
            isProjection: isProjection
            }
        }).then(response => {
                // http success, call the mutator and change something in state
                commit('setPlayerList', response.data.players)
                commit('setLoading', false )
                resolve(response);  // Let the calling function know that http is done. You may send some data back
            }, error => {
                // http failed, let the calling function know that action did not work out
                commit('setLoading', false )
                reject(error);
            })
        })
      // TODO: 04/05/20 - See what this does for the draft and implement what we need.
			// axios.get('/players',{
			// 		 params: {
			// 			selectedTeam: selectedTeam,
			// 			selectedPosition: selectedPosition,
			// 			status: status,
			// 			season: season,
       //          seasonType: seasonType,
    			// 		  }
    			// 	})
    			// .then((response)=>{
       //      commit('setPlayerList', response.data.players)
       //      commit('userFantasyTeam', response.data.fantasy_team)
    			// 	commit('setLoading', false )
    			// });

    			/* setInterval(function(){
    				axios.get('/players',{
    					 params: {
    						selectedTeam: selectedTeam,
    						selectedPosition: selectedPosition,
    						selectedVal: selectedVal,
    					  }
    				})
    				.then((response)=>{
    					commit('loadPlayerList', response.data.players)
    				});

    			}, 3000);	 */
		} ,

    loadPlayerListPlayoffs({ dispatch, commit },{ selectedTeam, selectedPosition, status, season, seasonType, isProjection}) {
      commit('setLoading', true )
            console.log("loadPlayerListPlayoffs called");
      return new Promise((resolve, reject) => {
            // Do something here... lets say, a http call using vue-resource
            axios.get('/players2',{
           params: {
            selectedTeam: selectedTeam,
            selectedPosition: selectedPosition,
            status: status,
            season: season,
            seasonType: seasonType,
            isProjection: isProjection
            }
        }).then(response => {
                // http success, call the mutator and change something in state
                commit('setPlayerList', response.data.players)
                commit('setLoading', false )
                resolve(response);  // Let the calling function know that http is done. You may send some data back
            }, error => {
                // http failed, let the calling function know that action did not work out
                commit('setLoading', false )
                reject(error);
            })
        })
      // TODO: 04/05/20 - See what this does for the draft and implement what we need.
      // axios.get('/players',{
      //     params: {
      //      selectedTeam: selectedTeam,
      //      selectedPosition: selectedPosition,
      //      status: status,
      //      season: season,
       //          seasonType: seasonType,
          //      }
          //  })
          // .then((response)=>{
       //      commit('setPlayerList', response.data.players)
       //      commit('userFantasyTeam', response.data.fantasy_team)
          //  commit('setLoading', false )
          // });

          /* setInterval(function(){
            axios.get('/players',{
               params: {
                selectedTeam: selectedTeam,
                selectedPosition: selectedPosition,
                selectedVal: selectedVal,
                }
            })
            .then((response)=>{
              commit('loadPlayerList', response.data.players)
            });

          }, 3000);  */
    } ,

    getUserFantasyTeamRoster({ dispatch, commit },{ selectedTeam, selectedPosition, status, season, seasonType}) {
      //commit('setLoading', true )
      return new Promise((resolve, reject) => {
            // Do something here... lets say, a http call using vue-resource
            axios.get('/getUserFantasyTeamRoster',{
           // params: {
           //  selectedTeam: selectedTeam,
           //  selectedPosition: selectedPosition,
           //  status: status,
           //  season: season,
           //  seasonType: seasonType,
           //  }
        }).then(response => {
                // http success, call the mutator and change something in state
                commit('userFantasyTeam', response.data)
                //commit('setLoading', false )
                resolve(response);  // Let the calling function know that http is done. You may send some data back
            }, error => {
                // http failed, let the calling function know that action did not work out
                //commit('setLoading', false )
                reject(error);
            })
        })
    },

	getSystemSettings({ dispatch, commit },{ }) {
		//commit('setLoading', true )
		return new Promise((resolve, reject) => {
			// Do something here... lets say, a http call using vue-resource
			axios.get('/get_system_setting',{
			}).then(response => {
				// http success, call the mutator and change something in state
				commit('systemSettings', response.data)
				//commit('setLoading', false )
				resolve(response);  // Let the calling function know that http is done. You may send some data back
			}, error => {
				// http failed, let the calling function know that action did not work out
				//commit('setLoading', false )
				reject(error);
			})
		})
	},

		offlineFantasyDraftPlayerListAvailable ({ commit }) {
			axios.get('/fantasy_players',{
			}).then((response)=>{
				commit('loadFantasyPlayer', response.data)
			});

			/*setInterval(function(){
				axios.get('/fantasy_players',{

				})
				.then((response)=>{
					commit('loadFantasyPlayer', response.data)
				});

			}, 16000);	*/
		} ,

    playoffsShowAllFantasyTeams ({ commit, state }, {show}) {
      commit('playoffsShowAllFantasyTeams', show);
    },
		showSnackBarSuccess ({ commit, state }, { message}) {

			commit('showSnackBarSuccess', message);

		 setTimeout(() => {
					state.snackbar.show=false;
				  }, 5000)

		} ,
		showSnackBarFailure ({ commit, state }, { message}) {

			commit('showSnackBarFailure', message);
			setTimeout(() => {
					state.snackbar.show=false;
				  }, 5000)
		} ,



	}
})

export default store;
