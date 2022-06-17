<style>
.mini-team-logo-small {
    height: 105px;
    width: 105px;
}.key-players-container {
    border-bottom: 2px solid #e6e7e9;
    display: none;
    margin-bottom: 20px;
    padding-bottom: 20px;
    width: 100%;
}.key-players-container table .headshot {
    width: 25%;
}
.key-players-container table .headshot-img-ctr {
    margin: 0 10px 0 12px;
}
.headshot-img-ctr {
    display: inline-block;
    position: relative;
}.headshot-img-ctr .player-img {
    border-radius: 50%;
    box-sizing: border-box;
    background-color: #f5f6f7;
    border-radius: 50%;
    display: inline-block;
    overflow: hidden;
    text-transform: lowercase;
    vertical-align: middle;
    height: 68px;
    width: 68px;
	margin-bottom: 16px;
}.headshot-img-ctr .headshot-logo {
    bottom: 0;
    height: 24px;
    left: 44px;
    position: absolute;
    width: 24px;
}.key-players-container table .content {
    font-size: 10px;
    line-height: 1.3;
    vertical-align: middle;
}.key-players-container table .fpts {
    padding-right: 15px;
    vertical-align: middle;
}.key-players-container table .fpts .fpts-value {
    color: #232323;
    font-size: 24px;
    font-weight: 600;
    line-height: 1;
    margin-bottom: 3px;
    text-align: right;
}.key-players-container table .fpts .fpts-label {
    color: #94a1a9;
    font-size: 10px;
    font-weight: 400;
    line-height: 1;
    text-align: right;
}.key-players-container .name-formatting {
    color: #232323;
    font-size: 1.2rem;
    font-weight: 600;
}.key-players-container .player-formatting {
    color: #94a1a9;
    font-size: 11px;
    text-transform: uppercase;
}
.key-players-container .header {
    padding-left: 12px;
}
.key-players-container .header {
    background-color: #f8f8f8;
    color: #232323;
    font-family: "proxima-nova",Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1px;
    line-height: 1.1;
    padding: 10px 15px;
    text-transform: uppercase;
    border-bottom: 0;
    border-top: 2px solid #e6e7e9;
}
</style>
<template>
	<div id="key-players-container" class="key-players-container pregame" style="display: block;">
		<div class="header">
			Key Players
		</div>
		<table>
			<tbody>
				<tr v-for="team in top_key_players">
					<template v-if="team">
						<td class="headshot">
							<div class="headshot-img-ctr">
								<div class="player-img" v-if="team.player">
									<a href="#" target="_blank">
										<img :src="team.player.photo_url" class="player-headshot" />
									</a>
								</div>
								<div class="headshot-logo" v-if="team.wikipedia_logo_url">
									<img :src="team.player.wikipedia_logo_url" class="mini-team-logo-small" />
								</div>
							</div>
						</td>
						<td class="content">
							<span class="name-formatting">
								<a href="#" target="_blank">
								{{team.name}}
								</a>
							</span>
							<div class="player-formatting"><span>{{team.position}}</span><br>
								<span v-if="team.position=='RB'">{{ team.rushing_attempts }} ATT, {{ team.rushing_yards }} YDs, {{ team.rushing_touchdowns }} TD </span>
								<span v-if="team.position=='WR' || team.position=='TE' || team.position=='K' ">
								{{ team.receptions }} REC, {{ team.receiving_yards }} YDs, {{ team.receiving_touchdowns }} TD </span>
								<span v-if="team.position=='TQB' || team.position=='QB'  ">
								{{ team.passing_yards }} YDS, {{ team.passing_touchdowns }} TD, <span v-if="team.passing_interceptions > 0 ">2 INT </span>
								</span>
							</div>
						</td>
						<td class="fpts">
							<div class="fpts-value">
							{{team.fantasy_points_acme}}
							</div>
							<div class="fpts-label">
							FPTS
							</div>
						</td>
					</template>
				</tr>
			</tbody>
		</table>
	</div>
</template>

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
			week: { type: Number, required: true},
			season: { type: Number, required: true},
		},
		data() {
			return {
				visible: false,
				selected_season:2018,
				selected_week:1,
				top_key_players:[]
			}
		},  
		created() {
			this.getPlayerTeam();
		},
		methods: {
			getPlayerTeam(){
				this.visible = true;
				axios.get('/nfl-key-players',{params: {week:this.week,season:this.season,game_key:this.game_key}})
				.then((response)=>{
					this.top_key_players = response.data;
					var self = this;						
					self.visible = false;
				})
				.catch(error => {});
			}
		},
		mounted() {
			console.log('Component mounted.')
		}
	}
</script>
