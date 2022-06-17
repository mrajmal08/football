<template>
	<div id="player-stats-container" class="player-stats-container">
		<loading :active.sync="visible" :can-cancel="true"></loading>
		<div id="player-stats-away" class="player-stats-item-container away-team">
			<div class="stats-nav">
				<div class="team-logo">
					<a href="javascript:void(0)">
						<img :src="away_team.wikipedia_logo_url">
					</a>
				</div>
				<div class="team-name">
					<a href="javascript:void(0)">
						{{away_team.city}}
					</a>
				</div>
				<div class="stats-select nav-filter-menu">
					<div class="selected-value">
						<span class="value">Offense</span>
					</div>
				</div>
			</div>
			<div class="stats-ctr-container">
				<div class="passing-ctr" v-bind:style="{minHeight: passingHeight + 'px' }">
					<div class="stats-header">
						<table class="data-five stats-table">
							<tbody>
								<tr class="header-row">
									<td class="name-element">
										Passing
									</td>
									<td class="number-element">
										CP/ATT
									</td>
									<td class="number-element">
										YDS
									</td>
									<td class="number-element">
										TD
									</td>
									<td class="number-element">
										INT
									</td>
                                    <td class="number-element">
										FPTS
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="stats-rows">
						<table class="data-five stats-table">
							<tbody>
								<tr class="no-hover data-row" v-for="item in away_details.pass">
									<td class="hover-element"></td>
									<td class="name-element">
										{{item.short_name}}
									</td>
									<td class="number-element">
										{{item.passing_completions}} / {{item.passing_attempts}}
									</td>
									<td class="number-element">
										{{item.passing_yards}}
									</td>
									<td class="number-element">
										{{item.passing_touchdowns}}
									</td>
									<td class="number-element">
										{{item.passing_interceptions}}
									</td>
									<td class="number-element">
										{{item.fantasy_points_acme}}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="rushing-ctr" v-bind:style="{minHeight: rushingHeight + 'px' }">
					<div class="stats-header">
						<table class="data-five stats-table">
							<tbody>
								<tr class="header-row">
									<td class="name-element">
										Rushing
									</td>
									<td class="number-element">
										ATT
									</td>
									<td class="number-element">
										YDS
									</td>
									<td class="number-element">
										TD
									</td>
									<td class="number-element">
										LG
									</td>
									<td class="number-element">
										FPTS
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="stats-rows">
						<table class="data-five stats-table">
							<tbody>
								<tr class="no-hover data-row" v-for="item in away_details.rush">
									<td class="hover-element"></td>
									<td class="name-element">
										{{item.short_name}}
									</td>
									<td class="number-element">
										{{item.rushing_attempts}}
									</td>
									<td class="number-element">
										{{item.rushing_yards}}
									</td>
									<td class="number-element">
										{{item.rushing_touchdowns}}
									</td>
									<td class="number-element">
										{{item.rushing_long}}
									</td>
									<td class="number-element">
										{{item.fantasy_points_acme}}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="receiving-ctr">
					<div class="stats-header">
						<table class="data-six stats-table">
							<tbody>
								<tr class="header-row">
									<td class="name-element">
										Receiving
									</td>
									<td class="number-element">
										TAR
									</td>
									<td class="number-element">
										REC
									</td>
									<td class="number-element">
										YDS
									</td>
									<td class="number-element">
										TD
									</td>
									<td class="number-element">
										LG
									</td>
									<td class="number-element">
										FPTS
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="stats-rows">
						<table class="data-six stats-table">
							<tbody>
								<tr class="no-hover data-row" v-for="item in away_details.rec">
									<td class="hover-element"></td>
									<td class="name-element">
										{{item.short_name}}
									</td>
									<td class="number-element">
										{{item.receiving_targets}}
									</td>
									<td class="number-element">
										{{item.receptions}}
									</td>
									<td class="number-element">
										{{item.receiving_yards}}
									</td>
									<td class="number-element">
										{{item.receiving_touchdowns}}
									</td>
									<td class="number-element">
										{{item.receiving_long}}
									</td>
									<td class="number-element">
										{{item.fantasy_points_acme}}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div id="player-stats-home" class="player-stats-item-container home-team">
			<div class="stats-nav">
				<div class="team-logo">
					<a href="javascript:void(0)">
						<img :src="home_team.wikipedia_logo_url">
					</a>
				</div>
				<div class="team-name">
					<a href="javascript:void(0)">
						{{home_team.city}}
					</a>
				</div>
				<div class="stats-select nav-filter-menu">
					<div class="selected-value">
						<span class="value">Offense</span>
					</div>
				</div>
			</div>
			<div class="stats-ctr-container">
				<div class="passing-ctr"v-bind:style="{minHeight: passingHeight + 'px' }">
					<div class="stats-header">
						<table class="data-five stats-table">
							<tbody>
								<tr class="header-row">
									<td class="name-element">
										Passing
									</td>
									<td class="number-element">
										CP/ATT
									</td>
									<td class="number-element">
										YDS
									</td>
									<td class="number-element">
										TD
									</td>
									<td class="number-element">
										INT
									</td>
                                    <td class="number-element">
										FPTS
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="stats-rows">
						<table class="data-five stats-table">
							<tbody>
								<tr class="no-hover data-row" v-for="item in home_details.pass">
									<td class="hover-element"></td>
									<td class="name-element">
										{{item.short_name}}
									</td>
									<td class="number-element">
										{{item.passing_completions}} / {{item.passing_attempts}}
									</td>
									<td class="number-element">
										{{item.passing_yards}}
									</td>
									<td class="number-element">
										{{item.passing_touchdowns}}
									</td>
									<td class="number-element">
										{{item.passing_interceptions}}
									</td>
									<td class="number-element">
										{{item.fantasy_points_acme}}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="rushing-ctr" v-bind:style="{minHeight: rushingHeight + 'px' }">
					<div class="stats-header">
						<table class="data-five stats-table">
							<tbody>
								<tr class="header-row">
									<td class="name-element">
										Rushing
									</td>
									<td class="number-element">
										ATT
									</td>
									<td class="number-element">
										YDS
									</td>
									<td class="number-element">
										TD
									</td>
									<td class="number-element">
										LG
									</td>
									<td class="number-element">
										FPTS
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="stats-rows">
						<table class="data-five stats-table">
							<tbody>
								<tr class="no-hover data-row" v-for="item in home_details.rush">
									<td class="hover-element"></td>
									<td class="name-element">
										{{item.short_name}}
									</td>
									<td class="number-element">
										{{item.rushing_attempts}}
									</td>
									<td class="number-element">
										{{item.rushing_yards}}
									</td>
									<td class="number-element">
										{{item.rushing_touchdowns}}
									</td>
									<td class="number-element">
										{{item.rushing_long}}
									</td>
									<td class="number-element">
										{{item.fantasy_points_acme}}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="receiving-ctr">
					<div class="stats-header">
						<table class="data-six stats-table">
							<tbody>
								<tr class="header-row">
									<td class="name-element">
										Receiving
									</td>
									<td class="number-element">
										TAR
									</td>
									<td class="number-element">
										REC
									</td>
									<td class="number-element">
										YDS
									</td>
									<td class="number-element">
										TD
									</td>
									<td class="number-element">
										LG
									</td>
									<td class="number-element">
										FPTS
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="stats-rows">
						<table class="data-six stats-table">
							<tbody>
								<tr class="no-hover data-row" v-for="item in home_details.rec">
									<td class="hover-element"></td>
									<td class="name-element">
										{{item.short_name}}
									</td>
									<td class="number-element">
										{{item.receiving_targets}}
									</td>
									<td class="number-element">
										{{item.receptions}}
									</td>
									<td class="number-element">
										{{item.receiving_yards}}
									</td>
									<td class="number-element">
										{{item.receiving_touchdowns}}
									</td>
									<td class="number-element">
										{{item.receiving_long}}
									</td>
									<td class="number-element">
										{{item.fantasy_points_acme}}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
.player-stats-item-container .stats-table tr .number-element {
    padding-right: 5px;
    text-align: right;
    width: 27px;
}
.player-stats-item-container .stats-table tr .hover-element {
    position: relative;
    width: 0;
}
.player-stats-item-container .stats-table .header-row td {
    color: #fff;
	font-size: 10px;
	font-weight: 600;
	letter-spacing: 1px;
	padding-bottom: 8px;
	padding-top: 8px;
	text-transform: uppercase;
}
.player-stats-item-container .stats-table tr td {
    box-sizing: border-box;
    font-size: 12px;
    padding: 12px 0;
    vertical-align: middle;
    white-space: nowrap;
}
.player-stats-item-container .stats-table tr:last-child:not(.total-row) {
    border: 0;
}
.player-stats-item-container .stats-table .header-row {
    background: #014A8F;
}
.player-stats-item-container .stats-table{
	clear: both;
}
.player-stats-item-container .data-five{
	width: 100%;
}
.player-stats-item-container .data-six{
	width: 100%;
}
.player-stats-item-container .stats-nav .stats-select .selected-value {
    letter-spacing: 1px;
}
.player-stats-item-container .stats-nav .team-logo img {
    height: 24px;
    width: 24px;
}
.player-stats-item-container .stats-nav .stats-select{
    color: #147cd1;
    font-size: 12px;
    font-weight: 600;
    float: right;
    padding: 7px 0 0;
    text-transform: uppercase;
}
.player-stats-item-container .stats-nav .team-name {
    float: left;
    font-size: 16px;
    font-weight: 600;
    margin: 4px 0 0 5px;
}
.player-stats-item-container .stats-nav .team-logo {
    float: left;
}
.player-stats-item-container .stats-nav {
    height: 30px;
}
.player-stats-item-container.home-team {
    float: right;
}
.player-stats-container .player-stats-item-container.home-team {
    padding-left: 8px;
}
.player-stats-container .player-stats-item-container.away-team {
    padding-right: 8px;
}
.player-stats-container .player-stats-item-container {
    margin-top: 10px;
}
.player-stats-container .player-stats-item-container {
    box-sizing: border-box;
    margin: 0;
    padding-bottom: 10px;
    width: 50%;
}
.player-stats-item-container.away-team {
    float: left;
}
.player-stats-container {
    min-height: 200px;
    width: 100%;
	padding-left: 20px;
	margin-top: 10px;
}
.player-stats-item-container {
	margin-top: 10px;
    min-height: 180px;
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
	props:{
		game_key: { type: Number, required: true},
	},
	data() {
		return {
			away_details:[],
			home_details:[],
			home_team:[],
			away_team:[],
			away_passing:0,
			home_passing:0,
			away_rushing:0,
			home_rushing:0,
			away_receiving:0,
			home_receiving:0,
			passingHeight:0,
			rushingHeight:0,
			visible: false,
		}
	},  
	created() {
		this.getPlayerDetails();
	},
	methods: {
		getPlayerDetails(){
			this.visible = true;
			axios.get('/scores/get-team-player-stat',{params: {game_key:this.game_key}})
			.then((response)=>{
				this.away_details 	= response.data.away_team;
				this.home_details 	= response.data.home_team;
				this.away_team 		= response.data.team_details.away;
				this.home_team	 	= response.data.team_details.home;
				this.away_passing	= response.data.away_team.pass.length;
				this.home_passing	= response.data.home_team.pass.length;
				this.away_rushing	= response.data.away_team.rush.length;
				this.home_rushing	= response.data.home_team.rush.length;
				this.away_receiving	= response.data.away_team.rec.length;
				this.home_receiving	= response.data.home_team.rec.length;
				
				if(this.away_passing >= this.home_passing)
					this.passingHeight = this.away_passing * 72;
				else
					this.passingHeight = this.home_passing * 72;
					
				if(this.away_rushing >= this.home_rushing)
					this.rushingHeight = this.away_rushing * 60;
				else
					this.rushingHeight = this.home_rushing * 60;
				
				var self = this;						
				self.visible = false;
			})
			.catch(error => {});
		}
	},
	mounted() {
		console.log('Component mounted.')
	},
}
</script>
