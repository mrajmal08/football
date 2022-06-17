<template>
<div class="tournament-view">
	<div class="tournament-view-top">
		<div class="t-top--head head-text align-center text-uppercase font-bold">League<br/>Tournament </div>
		<div class="bottom-container">
			<div class="bottom-section">
				<div class="text-uppercase align-center font-bold">National fantasy football conference</div>
				<div class="t-three-section d-flex d-align-center align-center">
					<div class="t-three-section-dev t-three-space"></div>
					<div class="t-three-section-dev t-three-letter text-uppercase align-center font-bold"><p>Division playoff</p><p>week 15</p></div>
					<div class="t-three-section-dev t-three-letter text-uppercase align-center font-bold"><p>conference championship</p><p>week 16</p></div>
				</div>
			</div>
			<div class="text-uppercase align-center bottom-section bottom-section-middel-text font-bold">
				<p>week 17</p>
				<p>Tournament championship finals</p>
			</div>
			<div class="bottom-section">
				<div class="text-uppercase align-center font-bold">American Fantasy football conference</div>
				<div class="text-uppercase t-three-section d-flex d-align-center align-center">

					<div class="t-three-section-dev t-three-letter text-uppercase align-center font-bold"><p>conference championship</p><p>week 16</p></div>
					<div class="t-three-section-dev t-three-letter text-uppercase align-center font-bold"><p>division playoff</p><p>week 15</p></div>
					<div class="t-three-section-dev t-three-space"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="tournament-view-bottom">
	<div class="bottom-container">
			<div class="bottom-section">
				<div class="t-three-section d-flex d-align-center align-center">
					<!-- North section start -->
					<div class="t-three-space t-three-section-dev team-list orange-color text-uppercase align-left direction">North</div>
					<div class="t-three-letter align-center t-three-section-dev">
						<div id="start_1"></div>
						<div v-for="(team, tindex) in north_division.week[15]" class="align-center team-list orange-color bottom-line">
							<span>
								 {{team.teamName}}  ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})
							</span>
						</div>
						<div id="start_2"></div>
				    </div>


					<div class="t-three-letter align-center t-three-section-dev">
						<p class="points">8.5 Points</p>
						<div id="north_home_team" class="align-center team-list orange-color bottom-line link-list" >
							<span v-if=national_conference.national_home_team.name> {{national_conference.national_home_team.name}} ({{national_conference.national_home_team.winCount}}-{{national_conference.national_home_team.lossCount}})</span></div>
					</div>
				</div>
				<div class="t-three-section d-flex d-align-center align-center">
					<!-- South section start -->
					<div class="t-three-space t-three-section-dev team-list blue-color text-uppercase align-left direction direction-space">South</div>
					<div class="t-three-letter align-center t-three-section-dev">
						<p class="points">6.5 Points</p>
						<div id="start_3"></div>
						<div v-for="team in south_division.week[15]" class="align-center team-list blue-color bottom-line">
							<span>
								 {{team.teamName}}  ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})
							</span>
						</div>
						<div id="start_4"></div>
				    </div>
					<div class="t-three-letter align-center t-three-section-dev">
						<div id="south_home_team" class="align-center team-list blue-color bottom-line link-list">
							<span v-if=national_conference.national_away_team.name> {{national_conference.national_away_team.name}} ({{national_conference.national_away_team.winCount}}-{{national_conference.national_away_team.lossCount}})</span></div>
					</div>
				</div>

			</div>
			<div class="align-center bottom-section bottom-section-middel-text d-flex d-align-center">
				<div class="bottom-section-middel-div">
					<p class="points">11.5 Points</p>
					<div id="championship_final_1" :class="championship_home_class" class="align-center team-list bottom-line">
						{{championship_details.conference_home_team}}
					</div>
				</div>
				<div class="text-vs">VS</div>
				<div class="bottom-section-middel-div">
					<p class="points">11.5 Points</p>
					<div id="championship_final_2" :class="championship_away_class" class="align-center team-list bottom-line">
						{{championship_details.conference_away_team}}
					</div>
				</div>
			</div>
			<div class="bottom-section">
				<div class="t-three-section d-flex d-align-center align-center">
					<div class="t-three-section-dev t-three-letter align-center">
						<p class="points">8.5 Points</p>
						<div id="east_conference_1" class="align-center team-list yellow-color bottom-line link-list">
            <span v-if=american_conference.american_home_team.name>
             {{american_conference.american_home_team.name}} ({{american_conference.american_home_team.winCount}}-{{american_conference.american_home_team.lossCount}})
          </span></div>
					</div>
					<div class="t-three-section-dev t-three-letter  align-center">
						<div id="start_5"></div>
						<div v-for="team in east_division.week[15]" class="align-center team-list yellow-color bottom-line">
							<span>
								 {{team.teamName}}  ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})
							</span>
						</div>
						<div id="start_6"></div>
					</div>
					<div class="t-three-section-dev t-three-space">
						<div class="align-center text-uppercase team-list yellow-color align-right direction">East</div>
					</div>
				</div>
				<div class="t-three-section d-flex d-align-center align-center">
					<div class="t-three-section-dev t-three-letter align-center">
						<div id="west_conference_1" class="align-center team-list green-color bottom-line link-list ">
                          <span v-if=american_conference.american_away_team.name>
             {{american_conference.american_away_team.name}} ({{american_conference.american_away_team.winCount}}-{{american_conference.american_away_team.lossCount}})
          </span>
</div>
					</div>
					<div class="t-three-section-dev t-three-letter align-center">
						<p class="points">6.5 Points</p>
						<div id="start_7"></div>
						<div v-for="team in west_division.week[15]" class="align-center team-list green-color bottom-line">
							<span>
								 {{team.teamName}}  ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})
							</span>
						</div>
						<div id="start_8"></div>
					</div>
					<div class="t-three-section-dev t-three-space">
						<div class="align-center text-uppercase team-list green-color align-right direction direction-space">West</div>
					</div>
				</div>
			</div>
		</div>


	</div>

	<div class="tournament-list-table">
	<div class="d-flex">

		<div class="tournament-list-width">
			<div class="d-flex d-align-center">
				<div class="tournament-list-text tournament-list-space tournament-list-space-text">&nbsp;</div>
				<div class="text-uppercase tournament-list-text-head tournament-list-space tournament-list-title font-bold">
					<p>Consolation rounds</p>
					<div class="d-flex d-align-top">
						<div class="align-center tournament-list-head week-title">week 16</div>
					</div>
				</div>
				<div class="align-center tournament-list-head tournament-list-space tournament-list-title">
				<div class="align-title font-bold">WEEK 17<p>Consolation Finals</p></div></div>
			</div>
			<div>
				<div class="d-flex d-align-center tournament-list">
					<div class="tourn-section01-container">
						<div class="tourn-section01">
							<div class="tournament-list-text tournament-list-space tournament-list-space-text text-uppercase font-bold"><p>National conferance losers</p></div>
							<div class="align-center tournament-list-head-container">
								<p>5 Points</p>
								<div v-for="team in national_conference_consolation_details" class="align-center team-list bottom-line space-bottom"
								v-bind:class="{ 'orange-color': team.teamDivision === 'north', 'blue-color': team.teamDivision === 'south','yellow-color': team.teamDivision === 'east','green-color': team.teamDivision === 'west' }"
								>
									<span v-if="team.teamDivision === 'south'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
									<span v-else-if="team.teamDivision === 'north'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
									<span v-else-if="team.teamDivision === 'east'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
									<span v-else-if="team.teamDivision === 'west'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
								</div>
							</div>
						</div>
						<div class="tourn-section01">
							<div class="tournament-list-text tournament-list-space tournament-list-space-text text-uppercase font-bold"><p>American conferance losers</p></div>
							<div class="align-center tournament-list-head-container">
								<div v-for="team in american_conference_consolation_details" class="align-center team-list yellow-color bottom-line space-bottom"
								v-bind:class="{ 'orange-color': team.teamDivision === 'north', 'blue-color': team.teamDivision === 'south','yellow-color': team.teamDivision === 'east','green-color': team.teamDivision === 'west' }"
								>
									<span v-if="team.teamDivision === 'south'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
									<span v-else-if="team.teamDivision === 'north'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
									<span v-else-if="team.teamDivision === 'east'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
									<span v-else-if="team.teamDivision === 'west'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
								</div>
							</div>
						</div>
					</div>
					<div class="tournament-list-space-Finals">
						<div class="align-center tournament-list-head-container">
							<div v-for="team in cons_finals_team" class="align-right team-list orange-color bottom-line space-bottom"
							v-bind:class="{ 'orange-color': team.teamDivision === 'north', 'blue-color': team.teamDivision === 'south','yellow-color': team.teamDivision === 'east','green-color': team.teamDivision === 'west' }">
								<span v-if="team.teamDivision === 'south'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
								<span v-else-if="team.teamDivision === 'north'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
								<span v-else-if="team.teamDivision === 'east'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
								<span v-else-if="team.teamDivision === 'west'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
							</div>
						</div>
					</div>
				</div>
				<div class="tournament-list">
					<div class="d-flex d-align-center "></div>
					<div class="tournament-list-space-Toilet tournament-list-space-Finals">
						<div class="Toilet-head align-center font-bold">Toilet Bowl</div>
						<div class="align-center tournament-list-head-container">
							<p>2.5 Points</p>
							<div v-for="team in toilet_bowl_details" class="align-right team-list blue-color bottom-line space-bottom"
							v-bind:class="{ 'orange-color': team.teamDivision === 'north', 'blue-color': team.teamDivision === 'south','yellow-color': team.teamDivision === 'east','green-color': team.teamDivision === 'west' }"
							>

								<span v-if="team.teamDivision === 'south'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
								<span v-else-if="team.teamDivision === 'north'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
								<span v-else-if="team.teamDivision === 'east'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>
								<span v-else-if="team.teamDivision === 'west'">{{team.teamName}} ({{team.winCount}}-{{team.lossCount}}-{{team.tieCount}})</span>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tournament-list-width tournament-list-width-right">
			<div class="tournament-list-title">
				<div class="text-uppercase align-center font-bold">tournament</div>
				<div class="text-uppercase d-flex align-center tournament-list-width-right-title">
					<div class="tournament-list-right-space font-bold">Team</div>
					<div class="tournament-list-right-space tournament-list-right-points font-bold">Pts</div>
					<div class="tournament-list-right-space font-bold">Placement</div>
				</div>
			</div>
			<div class="top-space">
				<div v-for="(team,index) in tournament_teams" class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space">
						<div class="align-center team-list bottom-line" v-bind:class="{ 'orange-color': team.teamDivision === 'north', 'blue-color': team.teamDivision === 'south','yellow-color': team.teamDivision === 'east','green-color': team.teamDivision === 'west' }"
						>
							<span v-if="team.teamDivision === 'south'">{{team.teamName}}</span>
							<span v-else-if="team.teamDivision === 'north'">{{team.teamName}}</span>
							<span v-else-if="team.teamDivision === 'east'">{{team.teamName}}</span>
							<span v-else-if="team.teamDivision === 'west'">{{team.teamName}}</span>
						</div>
					</div>
					<div class="tournament-list-right-space tournament-list-right-points">{{team.PCT}}</div>
					<div class="tournament-list-right-space text-uppercase align-left">
						<span v-if="index == '0'">CHAMPION $100</span>
						<span v-else-if="index == '1'">Runner up $75</span>
						<span v-else-if="index == '2'">3rd place $50</span>
						<span v-else-if="index == '3'">4th place $40</span>
						<span v-else-if="index == '4'">5th place $30</span>
						<span v-else-if="index == '5'">6th place $20</span>
						<span v-else-if="index == '6'">7th place $10</span>
						<span v-else-if="index == '7'">8th place $5</span>
						<span v-else-if="index == '8'">9th place $4</span>
						<span v-else-if="index == '9'">10th place $3</span>
						<span v-else-if="index == '10'">11th place $2</span>
						<span v-else-if="index == '11'">12th place $1</span>

					</div>
				</div>
				<!-- <div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list blue-color bottom-line">South Team 3</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">11</div>
					<div class="tournament-list-right-space text-uppercase align-left">Runner up $75</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list orange-color bottom-line">North Team 2</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">10</div>
					<div class="tournament-list-right-space text-uppercase align-left">3rd place $50</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list green-color bottom-line">West Team 1</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">9</div>
					<div class="tournament-list-right-space text-uppercase align-left">4th place $40</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list green-color bottom-line">West Team 2</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">8</div>
					<div class="tournament-list-right-space text-uppercase align-left">5th place $30</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list orange-color bottom-line">West Team 2</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">7</div>
					<div class="tournament-list-right-space text-uppercase align-left">6th place $20</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list green-color bottom-line">West Team 2</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">6</div>
					<div class="tournament-list-right-space text-uppercase align-left">7th place $10</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list orange-color bottom-line">West Team 2</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">5</div>
					<div class="tournament-list-right-space text-uppercase align-left">8th place $5</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list yellow-color bottom-line">East Team 2</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">8</div>
					<div class="tournament-list-right-space text-uppercase align-left">4th place $30</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list blue-color bottom-line">South Team 2</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">7</div>
					<div class="tournament-list-right-space text-uppercase align-left">3th place $20</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title space-bottom">
					<div class="tournament-list-right-space"><div class="align-center team-list blue-color bottom-line">South Team 2</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">6</div>
					<div class="tournament-list-right-space text-uppercase align-left">2th place $10</div>
				</div>
				<div class="d-flex d-align-center align-center tournament-list-width-right-title">
					<div class="tournament-list-right-space"><div class="align-center team-list yellow-color bottom-line">East Team 2</div></div>
					<div class="tournament-list-right-space tournament-list-right-points">5</div>
					<div class="tournament-list-right-space text-uppercase align-left">1th place $5</div>
				</div> -->
			</div>
		</div>
		</div>
	</div>
</div>
</template>
<script>
    export default {
        created(){
			this.getTournamentData();
		},
		data() {
			return {
				north_division: {['week']: 15},
				south_division: {['week']: 15},
				east_division: {['week']: 15},
				west_division: {['week']: 15},
				national_conference: {['national_home_team']:'', ['national_away_team']:''},
				american_conference: {['american_home_team']:'', ['american_away_team']:''},
				championship_details: [],
				national_conference_consolation_details: [],
				american_conference_consolation_details: [],
				cons_finals_team: [],
				tournament_teams: [],
				championship_home_class: '',
				championship_away_class: '',
				championship_home_name: '',
				championship_away_name: '',
				toilet_bowl_details: '',
			}
		},
		methods: {
			getTournamentData() {
				axios.get('/tournament-graph')
				.then((response)=>{
					this.north_division			= response.data.north_teams;
					this.south_division			= response.data.south_teams;
					this.east_division			= response.data.east_teams;
					this.west_division			= response.data.west_teams;
					this.national_conference	= response.data.national_conference_teams;
					this.american_conference	= response.data.american_conference_teams;
					this.championship_details	= response.data.championship_teams;
					if(this.championship_details.conference_home_team_division =='north'){
						this.championship_home_class	=	'orange-color';
						this.championship_home_name		=	'North';
					}else if(this.championship_details.conference_home_team_division =='south'){
						this.championship_home_class	=	'blue-color';
						this.championship_home_name		=	'South';
					}else if(this.championship_details.conference_home_team_division =='east'){
						this.championship_home_class	=	'yellow-color';
						this.championship_home_name		=	'East';
					}else if(this.championship_details.conference_home_team_division =='west'){
						this.championship_home_class	=	'green-color';
						this.championship_home_name		=	'West';
					}

					if(this.championship_details.conference_away_team_division =='north'){
						this.championship_away_class	=	'orange-color';
						this.championship_away_name		=	'North';
					}else if(this.championship_details.conference_away_team_division =='south'){
						this.championship_away_class	=	'blue-color';
						this.championship_away_name		=	'South';
					}else if(this.championship_details.conference_away_team_division =='east'){
						this.championship_away_class	=	'yellow-color';
						this.championship_away_name		=	'East';
					}else if(this.championship_details.conference_away_team_division =='west'){
						this.championship_away_class	=	'green-color';
						this.championship_away_name		=	'West';
					}

					this.toilet_bowl_details			= response.data.toilet_bowl;
					this.national_conference_consolation_details = response.data.national_conference_consolation;
					this.american_conference_consolation_details = response.data.american_conference_consolation;
					this.cons_finals_team 				= response.data.consolation_finals;
					this.tournament_teams 				= response.data.tournament_teams;
				})
				.catch(error => {});
			}
		}
    }
</script>

<style>
.tournament-view{
	max-width:1280px;
	margin: auto;
	width:100%
}
body{
margin: 0;padding:0; font-family:"Arial", sans-serif  !important;font-size:12px !important;
}
.font-bold{font-weight:600;}
.container{max-width:1200px;}
.align-center{text-align: center;}
.text-uppercase{text-transform: uppercase;}
.d-flex{display: flex;}
.d-align-center{align-items: center;}
.t-three-section div.t-three-section-dev{width: calc((100% - 100px) / 2); }
.bottom-container .bottom-section{width:calc(100%/3);}
.bottom-container{display: flex; position: relative;top: -15px;}
p{margin:5px 0; }
.t-three-space{max-width: 100px;}
.t-three-letter{white-space: nowrap;letter-spacing: -0.5px;}
.bottom-section-middel-text{top:34px;position: relative;background-color: #c0c0c0; }
.tournament-view-top{    background-color: #c0c0c0;}
.tournament-view-bottom .bottom-container{top:0;}
.tournament-view-bottom .bottom-section-middel-text{top:0;background-color: transparent;}
.text-vs{width:30px;font-weight: 600;    margin-top: 25px; }
.bottom-section-middel-div{width: calc((100% - 30px) / 2); }
.team-list{padding:5px 6px; }
.orange-color{background-color:#ff6100; }
.blue-color{background-color:#00cdff; }
.yellow-color{background-color:#feff06; }
.green-color{background-color:#9acf00; }
.bottom-line{border-bottom:2px solid #000000; }
.link-list{width:60%;min-width:70px;  margin: auto }
.tournament-view-bottom{margin-top:25px;}
.align-right{text-align: right;}
.align-left{ text-align: left;}
.d-align-top{align-items: flex-start;}
.tournament-list-table{max-width:1000px; }
.tournament-list-width{width:calc(100% / 2); }
.space-bottom{margin-bottom:20px; }
.tournament-list-space{width: calc((100% - 205px) / 2);}
.tournament-list-text{max-width:205px; width:100%;  }
.tournament-list-head div, .tournament-list-text-head{white-space: nowrap;}
.tournament-list-space-Finals{margin-left:30px; }
.Toilet-head{background-color: #c0c0c0;}
.tournament-list-space-Toilet{width: calc((100% - 235px) / 2);float: right;}
.tournament-list-width-right{    max-width: 320px;}
.tournament-list-right-space{width: calc((100% - 50px) / 2);}
.tournament-list-right-points{max-width:50px; width: 100%; }
.Toilet-head-points-table{margin-top:78px; }
.tournament-list-width-right{margin-left:30px; border-left:2px solid #000;}
.tournament-list-title{ padding: 3px 0px 3px 3px;   background-color: #c0c0c0;}
.top-space{margin-top:15px; }
.align-title{    position: relative;
    top: 24px;
    background-color: #c0c0c0;}
.week-title{display: block;    width: 100%;}
.tournament-list-table{margin-top:30px}
.direction{ display: flex;align-items: center;justify-content: center;    min-height: 68px;}
.direction-space{margin-top:23px; }
.bottom-section-middel-text .points{
	position: relative;
    top: -65px;}
.tourn-section01{
	display: flex;

    align-items: center;
}
.tourn-section01 .tournament-list-head-container{width: calc(100% - 205px);}
.tourn-section01-container{width: calc(100% - 360px);margin-top:25px;}
</style>

