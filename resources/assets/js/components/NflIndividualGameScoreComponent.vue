
<style>
.card .table th, .card .table td {
    padding: 0.15rem 0.25rem;
}
.table thead th {
    background-color: #fff !important;
	border:none;
    color: #94a1a9;
    font-size: 10px;
    line-height: 1;
    text-transform: uppercase;
    width: 14px;
}
.table td {
    padding: 0.15rem;
    vertical-align: top;
    border-top:none;
	 line-height: 1.25;
}
.team-player-stats td {

    color: #232323;
    font-size: 10px;
    letter-spacing: 0.5px;
    line-height: 1.25;

}
.table td.team {

    color: #232323;
    letter-spacing: 0.5px;
    padding-left: 0;
    text-align: left;
    white-space: nowrap;
    

}.bottom-bar a {

    font-family: "proxima-nova",Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 1px;
    line-height: 1;
    text-transform: uppercase;
    
    color: #147cd1;
    font-weight: 700;

}
.table td.team .record {

    color: #94a1a9;
    font-weight: 300;
    font-size: 12px;
    margin-left: 4px;

}.table td.team a, .table td.team span {

    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0;
    line-height: 2;

}.team-player-stats .label {

    color: #5b6c77;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1px;
    line-height: 1.5;
    padding: 0 5px 4px 0;
    text-align: left;
    text-transform: uppercase;
    

}
.table a:link, a:visited {

    color: #13161a;
    text-decoration: none;
    transition: color .2s ease;

}
.team-player-stats .team-player-stats-bold, .team-player-stats .player-name {

    display: inline-block;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
    line-height: 15px;
    margin-bottom: 3px;

}.team-player-stats td span {

    color: #232323;
    font-family: "proxima-nova",Arial,Helvetica,sans-serif;
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 2px;
    line-height: 1;
    text-transform: uppercase;
    letter-spacing: 1px;
    line-height: 1.4;
    color: #94a1a9;
    display: block;
    padding-bottom: 8px;
    padding-right: 8px;

}.mini-team-logo-small {

    height: 25px;
    width: 25px;

}
.video-link-item-content {

    background-position: center;
    background-size: cover;
    cursor: pointer;
    height: 100%;
    position: absolute;
    top: 0;
    width: 100%;

}
.video-link-item-title {

    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -moz-box-flex: 1;
    -moz-flex: 1;
    -ms-flex: 1;
    flex: 1;
    color: #232323;
    font-family: "proxima-nova",Arial,Helvetica,sans-serif;
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 0.5px;
    line-height: 1.1;
    text-transform: none;
    
    font-size: 13px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

}.video-link-item-duration {

    color: #232323;
    font-family: "proxima-nova",Arial,Helvetica,sans-serif;
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 0.5px;
    line-height: 1.1;
    text-transform: none;
    background-color: #5b6c77;
    border-radius: 2px;
    color: #fff;
    float: right;
    font-size: 12px;
    margin-left: 10px;
    

}.video-link-item {

    clear: both;
    position: relative;
    width: 100%;

}.video-link-item-spacer {

    padding-top: 0%;

}
</style>
<template>
	<div>
		<b-card title="Final" style="max-width: 35rem;" class="mb-2">
			<div>
				<table class="table">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th v-if="team_data.home_away_team_score.score_data.is_overtime==1">OT</th>
							<th>T</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="team">
								<span class="marker"><span class="icon-moon-caret-right"></span></span>
								<img :src="team_data.away_team.team_data.wikipedia_logo_url" class="mini-team-logo-small" />
								<a href="#" class="team">{{ team_data.away_team.team_data.name }}</a>
								<span class="record">{{ team_data.away_team.team_record.wins }}- {{ team_data.away_team.team_record.losses }} -{{ team_data.away_team.team_record.ties }}</span>
							</td>
							<td class="scores">{{ team_data.away_team.score_data.away_score_quarter1 }}</td>
							<td class="scores">{{ team_data.away_team.score_data.away_score_quarter2 }}</td>
							<td class="scores">{{ team_data.away_team.score_data.away_score_quarter3 }}</td>
							<td class="scores">{{ team_data.away_team.score_data.away_score_quarter4 }}</td> 
							<td class="total-score" v-if="team_data.home_away_team_score.score_data.is_overtime==1">{{ team_data.home_away_team_score.score_data.away_score_overtime }}</td>
							<td class="total-score"  >{{ team_data.home_away_team_score.score_data.away_score }}</td>
						</tr>
						<tr>
							<td class="team">
								<img :src="team_data.home_team.team_data.wikipedia_logo_url" class="mini-team-logo-small" />


								<a href="#" class="team">{{ team_data.home_team.team_data.name }}</a>

								<span class="record">{{ team_data.home_team.team_record.wins }}- {{ team_data.home_team.team_record.losses }} -{{ team_data.home_team.team_record.ties }}</span>
							</td>
							<td class="scores">{{ team_data.home_team.score_data.home_score_quarter1 }}</td>
							<td class="scores">{{ team_data.home_team.score_data.home_score_quarter2 }}</td>
							<td class="scores">{{ team_data.home_team.score_data.home_score_quarter3 }}</td>
							<td class="scores">{{ team_data.home_team.score_data.home_score_quarter4 }}</td>
							<td class="total-score" v-if="team_data.home_away_team_score.score_data.is_overtime==1" >{{ team_data.home_away_team_score.score_data.home_score_overtime }}</td>
							<td class="total-score" >{{ team_data.home_away_team_score.score_data.home_score }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		<!--	<div class="video-link-item" data-pcid="" data-game-abbr="">
				<video width="320" height="150" controls>
					<source :src="team_data.video_details.video_url" type="video/mp4">
				</video>

				<div class="video-link-item-spacer"></div>
				<div>
					<div class="video-link-item-play image-icon-overlay size-medium type-video"></div>
					<div class="video-link-item-footer">
						<h3 class="video-link-item-title">
						{{ team_data.video_details.video_headline }}
						</h3>
					</div>
				</div>
			</div>-->
			<div class="team-player-stats">
				<table class="table ">
					<thead>
						<tr>
							<th class="label"></th>
							<th class="label">{{ team_data.away_team.team_data.name }}</th>
							<th class="label">{{ team_data.home_team.team_data.name }}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-if="team_data.away_team.players.pass">
							<td class="label">PASS</td>
							<td>
								<a href="#" class="player-name" target="_blank">{{ team_data.away_team.players.pass.name }}</a>
								<span>{{ team_data.away_team.players.pass.passing_yards }} YDs, {{ team_data.away_team.players.pass.passing_touchdowns }} TD, {{ team_data.away_team.players.pass.passing_interceptions }} INT</span>
							</td>
							<td>
								<a href="#" class="player-name" target="_blank">{{ team_data.home_team.players.pass.name }}</a>
								<span>{{ team_data.home_team.players.pass.passing_yards }} YDs, {{ team_data.home_team.players.pass.passing_touchdowns }} TD, {{ team_data.home_team.players.pass.passing_interceptions }} INT</span>
							</td>
						</tr>
						<tr>
							<td class="label">RUSH</td>
							<td>
								<a href="#" class="player-name" target="_blank">{{ team_data.away_team.players.rush.name }}</a>
								<span>{{ team_data.away_team.players.rush.rushing_attempts }} ATT, {{ team_data.away_team.players.rush.rushing_yards }} YDs, {{ team_data.away_team.players.rush.rushing_touchdowns }} TD </span>
							</td>
							<td>
								<a href="#" class="player-name" target="_blank">{{ team_data.home_team.players.rush.name }}</a>
								<span>{{ team_data.home_team.players.rush.rushing_attempts }} ATT, {{ team_data.home_team.players.rush.rushing_yards }} YDs, {{ team_data.home_team.players.rush.rushing_touchdowns }} TD</span>
							</td>
						</tr>
						<tr>
							<td class="label">REC</td>
							<td v-if="team_data.home_team.players">
								<a href="#" class="player-name" target="_blank">{{ team_data.away_team.players.rec.name }}</a>
								<span>{{ team_data.away_team.players.rec.receptions }} REC, {{ team_data.away_team.players.rec.receiving_yards }} YDs, {{ team_data.away_team.players.rec.receiving_touchdowns }} TD</span>
							</td>
							<td v-if="team_data.home_team.players">
								<a href="#" class="player-name" target="_blank">{{ team_data.home_team.players.rec.name }}</a>
								<span>{{ team_data.home_team.players.rec.receptions }} REC, {{ team_data.home_team.players.rec.receiving_yards }} YDs, {{ team_data.home_team.players.rec.receiving_touchdowns }} TD</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bottom-bar-container">
				<div class="bottom-bar narrow">
					<table class="table">
						<tbody>
							<tr>
								<td class="">
									<a class="" :href="'/scores/nfl-games/box-scores/' + team_data.game_key +'/' + week+'/'+season"  target="_blank">Box Score</a>
								</td>
								<td class="">
                                    <a class="" href="#" target="_blank">Recap</a>
                                </td>
                             </tr>
						</tbody>
					</table>
				</div>
			</div>
		</b-card>
	</div>
</template>

<script>
    export default {
	
	props:{
	
     team_data: { type: Object},
     week: { type: Number},
     season: { required: false},
	  
    },
	data () {
		return {
		 // team_data: this.team
		  
		}
	},
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
