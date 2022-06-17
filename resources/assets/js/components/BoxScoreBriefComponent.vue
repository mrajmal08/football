<template>
   <div class="linescore-gameinfo-container">
		<table class="linescore">
			<thead>
				<tr class="line-score-header">
					<td>&nbsp;</td>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
					<td v-if="team_data.home_away_team_score.score_data.is_overtime==1">OT</td>
					<td>T</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="team">
						<img :src="team_data.away_team.team_data.wikipedia_logo_url"/>
						<span class="rank"></span>
						<span class="name">{{ team_data.away_team.team_data.name }}</span>
						<span class="record">{{ team_data.away_team.team_record.wins }}- {{ team_data.away_team.team_record.losses }} -{{ team_data.away_team.team_record.ties }}</span>
					</td>
					<td class="score">{{ team_data.away_team.score_data.away_score_quarter1 }}</td>
					<td class="score">{{ team_data.away_team.score_data.away_score_quarter2 }}</td>
					<td class="score">{{ team_data.away_team.score_data.away_score_quarter3 }}</td>
					<td class="score">{{ team_data.away_team.score_data.away_score_quarter4 }}</td> 
					<td class="total-score" v-if="team_data.home_away_team_score.score_data.is_overtime==1">{{ team_data.home_away_team_score.score_data.away_score_overtime }}</td>
					<td class="total-score"  >{{ team_data.home_away_team_score.score_data.away_score }}</td>
				</tr>
				<tr>
					<td class="team">
						<img :src="team_data.home_team.team_data.wikipedia_logo_url"/>
						<span class="rank"></span>
						<span class="name">{{ team_data.home_team.team_data.name }}</span>
						<span class="record">{{ team_data.home_team.team_record.wins }}- {{ team_data.home_team.team_record.losses }} -{{ team_data.home_team.team_record.ties }}</span>
					</td>
					<td class="score">{{ team_data.home_team.score_data.home_score_quarter1 }}</td>
					<td class="score">{{ team_data.home_team.score_data.home_score_quarter2 }}</td>
					<td class="score">{{ team_data.home_team.score_data.home_score_quarter3 }}</td>
					<td class="score">{{ team_data.home_team.score_data.home_score_quarter4 }}</td>
					<td class="total-score" v-if="team_data.home_away_team_score.score_data.is_overtime==1" >{{ team_data.home_away_team_score.score_data.home_score_overtime }}</td>
					<td class="total-score" >{{ team_data.home_away_team_score.score_data.home_score }}</td>
				</tr>
			</tbody>
		</table>
		<div class="game-meta-data linescore-variation">
			<div class="game-meta-odds-and-venue extended">
				<div class="game-meta-odds">
					<div class="BettingOddsDisplay">
						{{team_data.home_away_team_score.score_data.home_team}} {{team_data.home_away_team_score.score_data.point_spread}}, O/U {{team_data.home_away_team_score.score_data.over_under}} 
					</div>
				</div>
				<div class="game-meta-venue">{{team_data.home_away_team_score.score_data.score_stadium.name}} <span class="light-text">{{team_data.home_away_team_score.score_data.score_stadium.city}}, {{team_data.home_away_team_score.score_data.score_stadium.state}}</span></div>
			</div>
		</div>
	</div>
</template>
<script>
    export default {
		props:{
			team_data: { type: Object},
		},
		data () {
			return {
			}
		},
		mounted() {
			console.log('Component mounted.')
		}
	}
</script>
<style>
.linescore-gameinfo-container {
    border-bottom: 2px solid #D6DDE1;
    margin-bottom: 8px;
    position: relative;
}
.linescore{
	margin: 0 20px 0 0;
	width: 100%;
}
.linescore .line-score-header td {
	color: #94A1A9;
	font-size: 12px;
	font-weight: 400;
	text-align: center;
}

.linescore .team {
    color: #232323;
    font-size: 16px;
    font-weight: 600;
    height: 30px;
}

.linescore .score {
    color: #94A1A9;
    font-size: 16px;
    font-weight: 400;
    text-align: center;
    width: 6%;
}

.linescore .total-score {
    color: #232323;
    font-size: 16px;
    font-weight: 700;
    text-align: center;
    width: 6%;
}

a:link, a:visited {
    text-decoration: none;
    transition: color .2s ease;
}

.linescore .team img {
    height: 25px;
    margin: 0 5px 0 0;
    vertical-align: text-bottom;
    width: 25px;
}

.linescore .team .rank {
    color: #94A1A9;
    font-size: 12px;
    font-weight: 300;
    letter-spacing: 0.5px;
    padding-left: 0;
}

.linescore .team .record {
    color: #94A1A9;
    font-size: 12px;
    font-weight: 400;
}

.game-meta-data.linescore-variation {
    background-color: #f8f8f8;
    padding: 6px;
}

.game-meta-data {
    font-size: 14px;
    overflow: hidden;
    padding: 0 5px;
}

.game-meta-series.extended, .game-meta-odds-and-venue.extended {
    max-width: 100%;
}

.game-meta-series, .game-meta-odds-and-venue {
    float: left;
    max-width: 60%;
}

.game-meta-series-details, .game-meta-series-status, .game-meta-odds, .game-meta-venue {
    display: inline-block;
    font-weight: 600;
    padding: 0 2px;
}
.game-meta-data .light-text {
    color: #94a1a9;
    font-weight: 400;
}
</style>