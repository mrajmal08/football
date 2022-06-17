<template>
	<div id="jumbo-container" class="jumbo-container" >
		<div id="bg-image-container" class="bg-image-container">
			<div class="bg-img away-img">
				<img :src="team_data.away_team.team_data.wikipedia_logo_url">
			</div>
			<div class="bg-img home-img">
				<img :src="team_data.home_team.team_data.wikipedia_logo_url">
			</div>
		</div>

		<div id="bg-img-filter" class="bg-img-filter"></div>

		<div id="score-overlay" class="score-overlay">
			<div id="game-data-container" class="game-data-container jumbo-table">
				<div>
					<div class="jumbo-table-column"><!-- column group 1: Away Team --></div>
					<div class="jumbo-table-column"><!-- column group 2: Away Team Logo + Money Line--></div>
					<div class="jumbo-table-column"><!-- column group 3: Away Team Score (in-game/post-game) --></div>
					<div class="jumbo-table-column"><!-- column group 3: Away Team Win Icon --></div>
					<div class="jumbo-table-column"><!-- column group 4: Game Status + Odds --></div>
					<div class="jumbo-table-column"><!-- column group 3: Home Team Win Icon --></div>
					<div class="jumbo-table-column"><!-- column group 5: Home Team Score (in-game/post-game) --></div>
					<div class="jumbo-table-column"><!-- column group 6: Home Team Logo + Money Line --></div>
					<div class="jumbo-table-column"><!-- column group 7: Home Team --></div>
					<div class="jumbo-table-row">
						<div class="jumbo-table-cell team-name-container full away">
							<div class="city">{{team_data.away_team.team_data.city}}</div>
							<div class="nickname">
								{{team_data.away_team.team_data.name}}
							</div>
							<div class="team-record">
								{{ team_data.away_team.team_record.wins }}- {{ team_data.away_team.team_record.losses }} -{{ team_data.away_team.team_record.ties }}
							</div>
						</div>
						<div class="jumbo-table-cell team-logo-container away">
							<img :src="team_data.away_team.team_data.wikipedia_logo_url" class="mini-team-logo-large" alt="away team logo">
						</div>
						<div class="jumbo-table-cell team-score-container away">
							<div class="score-text">{{ team_data.away_team.score_data.away_score }}</div>
						</div>
						<div class="jumbo-table-cell arrow-content-container">
							<div v-if="isAwayWin" class="win away active">
								<div class="win-icon">
									<i class="fas fa-2x fa-caret-left"></i>
								</div>
							</div>
						</div>
						<div class="jumbo-table-cell center-content-container">
							<div class="final">
								<div class="final-text">{{team_data.home_away_team_score.score_data.quarter_description}}
								<span v-if="team_data.home_away_team_score.score_data.time_remaining !='null'">{{team_data.home_away_team_score.score_data.time_remaining}}</span>
								</div>
							</div>
						</div>
						<div class="jumbo-table-cell arrow-content-container">
							<div v-if="isHomeWin" class="win home active">
								<div class="win-icon">
									<i class="fas fa-2x fa-caret-right"></i>
								</div>
							</div>
						</div>
						<div class="jumbo-table-cell team-score-container home">
							<div class="score-text">{{ team_data.home_team.score_data.home_score }}</div>
						</div>
						<div class="jumbo-table-cell team-logo-container home">
							<img :src="team_data.home_team.team_data.wikipedia_logo_url" class="mini-team-logo-large" alt="away team logo">
						</div>
						<div class="jumbo-table-cell team-name-container full home">
							<div class="city">
								{{team_data.home_team.team_data.city}}
							</div>
							<div class="nickname">
								{{team_data.home_team.team_data.name}}
							</div>
							<div class="team-record">
								{{ team_data.home_team.team_record.wins }}- {{ team_data.home_team.team_record.losses }} -{{ team_data.home_team.team_record.ties }}
							</div>
						</div>
					</div>
					<div class="jumbo-table-row">
						<div class="jumbo-table-cell">
						<!-- EMPTY COLUMN 1 -->
						</div>
						<div class="jumbo-table-cell">
							<div class="jumbo-odds">
							ML:&nbsp;{{team_data.away_team.score_data.away_team_money_line}}
							</div>
						</div>
						<div class="jumbo-table-cell team-score-container">
						<!-- EMPTY COLUMN 3: display for score cell based on game state -->
						</div>
						<div class="jumbo-table-cell">
						<!-- EMPTY COLUMN 1 -->
						</div>
						<div class="jumbo-table-cell">
							<div class="jumbo-odds">
								<div class="BettingOddsDisplay">
									{{team_data.home_away_team_score.score_data.home_team}} {{team_data.home_away_team_score.score_data.point_spread}}, O/U {{team_data.home_away_team_score.score_data.over_under}} 
								</div>
							</div>
						</div>
						<div class="jumbo-table-cell">
						<!-- EMPTY COLUMN 1 -->
						</div>
						<div class="jumbo-table-cell team-score-container">
						<!-- EMPTY COLUMN 5: display for score cell based on game state-->
						</div>
						<div class="jumbo-table-cell">
							<div class="jumbo-odds">
								ML:&nbsp;{{team_data.home_team.score_data.home_team_money_line}}
							</div>
						</div>
						<div class="jumbo-table-cell">
						<!-- EMPTY COLUMN 7-->
						</div>
					</div>
				</div>
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
				isAwayWin: false,
				isHomeWin: false
			}
		},
		mounted() {
			if(this.team_data.away_team.score_data.away_score > this.team_data.home_team.score_data.home_score)
				this.isAwayWin = true;
			else
				this.isHomeWin = true;
		}
	}
</script>
<style>

.jumbo-container #score-overlay {
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
}

.jumbo-container  {
    background: #0055a6;
    color: #fff;
    height: 108px;
    left: 0;
    min-width: 980px;
    position: relative;
    width: 100%;
    z-index: 0;
	margin-bottom: 40px;
}

.jumbo-container  .bg-image-container {
    zoom: 1;
    display: block;
    height: 100%;
    margin: 0 auto;
    overflow: hidden;
    position: relative;
    width: 70%;

}
.jumbo-container  .bg-image-container .bg-img {

    -ms-transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    position: relative;
    top: 50%;

}

.jumbo-container  .bg-image-container .away-img {
    float: left;
}
.jumbo-container  .bg-image-container .bg-img img {
    height: auto;
    width: 100%;
}
img {

    height: auto;
    max-width: 100%;
    opacity: 1;
    transition: opacity .5s ease-in .5s;
    vertical-align: top;

}
.jumbo-container  .bg-image-container .home-img {
    float: right;
    text-align: right;
}
.jumbo-container  .bg-img-filter {
    background: rgba(0,74,143,0.85);
    display: block;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
}
.jumbo-container  #score-overlay #game-data-container {
    height: 100%;
    margin: 0 auto;
    position: relative;
}
.jumbo-table {
    display: table;
}
.jumbo-table-column {
    display: table-column;
}
.jumbo-table-row {
    display: table-row;
}
.jumbo-container  #score-overlay #game-data-container .team-name-container {
    height: 80px;
    position: relative;
    vertical-align: middle;
}
.jumbo-table-cell {
    display: table-cell;
}
.jumbo-container  #score-overlay #game-data-container .team-logo-container {
    height: 100%;
    padding: 0 20px;
    position: relative;
    vertical-align: middle;
}
.jumbo-container.mobile-view a, .game-data-container a {
    color: #fff;
}
a:link, a:visited {
    text-decoration: none;
    transition: color .2s ease;
}
.jumbo-container  #score-overlay #game-data-container .team-logo-container img {
    display: table-cell;
    height: 70px;
    width: 70px;
}
.jumbo-container  #score-overlay #game-data-container .team-score-container {
    height: 100%;
    margin: 0 10px;
    position: relative;
    vertical-align: middle;
    width: 60px;
}
.jumbo-container  #score-overlay #game-data-container .arrow-content-container {
    height: 100%;
    position: relative;
    vertical-align: middle;
    width: 10px;
}

.jumbo-container  #score-overlay #game-data-container .center-content-container {
    height: 100%;
    position: relative;
    vertical-align: middle;
    width: 150px;
}
.jumbo-table-row {
    display: table-row;
}
.jumbo-container  #score-overlay #game-data-container .team-score-container {
    height: 100%;
    margin: 0 10px;
    position: relative;
    vertical-align: middle;
    width: 60px;
}
.jumbo-container  #score-overlay #game-data-container .team-name-container.away .city, .jumbo-container  #score-overlay #game-data-container .team-name-container.away .nickname, .jumbo-container  #score-overlay #game-data-container .team-name-container.away .team-record {
    text-align: right;
}
.jumbo-container  #score-overlay #game-data-container .team-name-container .city {
    display: block;
}
.jumbo-container  #score-overlay #game-data-container .team-name-container .city {
    font-size: 12px;
    letter-spacing: 1px;
    line-height: 12px;
    text-transform: uppercase;
}
.jumbo-container  #score-overlay #game-data-container .team-name-container .nickname {
    font-size: 22px;
    font-weight: 600;
    line-height: 1;
    text-transform: uppercase;
}

.jumbo-container  #score-overlay #game-data-container .team-name-container .team-record {
    font-size: 12px;
    line-height: 1.4;
}
.jumbo-container.mobile-view a, .game-data-container a {
    color: #fff;
}
.jumbo-container  #score-overlay #game-data-container .team-score-container .score-text {
    font-size: 56px;
    font-weight: 600;
    line-height: 1;
    text-align: center;
    width: 100%;
}
.jumbo-container  #score-overlay #game-data-container .center-content-container .final {
    display: block;
    height: 22px;
    position: relative;
    width: 100%;
	text-transform: uppercase;
}
.jumbo-container  #score-overlay #game-data-container .arrow-content-container .win.away, .jumbo-container  #score-overlay #game-data-container .arrow-content-container .win.home {
    float: left;
}
.jumbo-container  #score-overlay #game-data-container .arrow-content-container .win {
    height: 22px;
    text-align: center;
    width: 25px;
}
.jumbo-container  #score-overlay #game-data-container .center-content-container .final .final-text {
    color: #fff;
    float: left;
    font-size: 22px;
    font-weight: 600;
    line-height: 1;
    position: relative;
    text-align: center;
    width: 100%;
}
.jumbo-odds {
    color: #81baf1;
    font-size: 12px;
    font-weight: 600;
    padding: 8px 0;
    text-align: center;
}
.jumbo-container  #score-overlay #game-data-container .arrow-content-container .win.active .win-icon {
    display: block;
}
.jumbo-container  #score-overlay #game-data-container .arrow-content-container .win .win-icon span {
    font-size: 12px;
    position: relative;
}


</style>

