import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

const tstore = new Vuex.Store({
	state: {
		offenseTeam: [],
		kickersTeam: [],
		defenseTeam: [],
		specialTeam: [],
		fantasyTeamPlayers: [],
	},
	getters: {
		offenseTeam: state => state.offenseTeam,
		kickersTeam: state => state.kickersTeam,
		defenseTeam: state => state.defenseTeam,
		specialTeam: state => state.specialTeam,
		countoffenseTeam: state => {
			return state.offenseTeam.length
		},
		getFantasyPlayers:(state) => (id) => {	  
			 return state.offenseTeam.filter(offenseTeams => offenseTeams.fantasy_team_id === id).
					concat(state.kickersTeam.filter(kickersTeams => kickersTeams.fantasy_team_id === id)).
					concat(state.defenseTeam.filter(defenseTeams => defenseTeams.fantasy_team_id === id)).
					concat(state.specialTeam.filter(specialTeams => specialTeams.fantasy_team_id === id))

				
		},
		 getPlayer:(state) => (id) => {	  
			 return state.offenseTeam.filter(offenseTeams => offenseTeams.player_id === id).
					concat(state.kickersTeam.filter(kickersTeams => kickersTeams.player_id === id)).
					concat(state.defenseTeam.filter(defenseTeams => defenseTeams.player_id === id)).
					concat(state.specialTeam.filter(specialTeams => specialTeams.player_id === id))
		}
	},
	mutations: {
		loadFantasyTeamData2(state, data) {
			state.offenseTeam 	= data.offenseTeams;
			state.kickersTeam 	= data.kickerTeams;
			state.defenseTeam 	= data.diffTeams;
			state.specialTeam 	= data.specialTeams;
		}
	},
	actions: {
		loadFantasyTeamData2 ({ commit }, { team_id, team_id2, week, season, projection }) {
			axios.get('/live-players',{
				params: {
						  team_id: team_id,
						  team_id2: team_id2,
						  week: week,
						  season: season,
						  projection: projection
						}
			}).then((response)=>{
					commit('loadFantasyTeamData2', response.data)
			});

			
		} 
	}
})

export default tstore;