<template>
	<div>
		<div class="header">
			Scoring
		</div>
		<div id="scoring-summary-container" class="scoring-summary-container">
			<div v-for="(scoring,index) in score_details">
				<div class="scoring-header">
					<div class="quarter-label">
						<div class="quarter-text">{{index | ordinalSuffix }} Quarter</div>
					</div>
					<div class="home label">
						<img class="nfl_headshot_logo" :src="game_details.home_logo_url" width="24" height="24">
					</div>
					<div class="away label">
						<img class="nfl_headshot_logo" :src="game_details.away_logo_url" width="24" height="24">
					</div>
				</div>
				<div class="scoring_item" v-for="(score,index) in scoring" v-if="scoring.length">
					<div class="team_image">
						<img class="nfl_headshot_logo" :src="score.team_logo">
					</div>
					<div class="play_drive_info">
						<div class="play_result">
							<span class="result_str">{{score.play_title}}</span><span class="last_play_time ">{{score.time_remaining}}</span>
						</div>
						<div class="last_play_description">
							{{score.play_description}}
						</div>
					</div>
					<div :class="{active:score.away_score > score.home_score }" class="away score">{{score.away_score}}</div>
					<div :class="{active:score.home_score > score.away_score }" class="home score">{{score.home_score}}</div>
				</div>
				<div class="scoring_default" v-else>
					No scoring this quarter
				</div>
			</div>
		</div>
	</div>
</template>
<style>
.scoring-summary-container .scoring_item .score.active {
    color: #232323;
    font-weight: 600;
}

.scoring-summary-container .scoring_item .score {
    color: #94a1a9;
    display: table-cell;
    font-size: 16px;
    font-weight: 400;
    padding-right: 16px;
    text-align: right;
    vertical-align: top;
    width: 32px;
}
.scoring-summary-container {
    min-height: 100px;
    width: 100%;
}
.scoring-summary-container .scoring-header:first-child {
    border-top: 2px solid #E6E7E9;
}
.scoring-summary-container .scoring-header {
    background-color: #f5f5f5;
    border-top: 1px solid #E6E7E9;
    height: 35px;
    width: 100%;
}
.scoring-summary-container .scoring-header .quarter-label {
    color: #232323;
    float: left;
    font-size: 12px;
    font-weight: 600;
    line-height: 2.9;
    text-transform: uppercase;
    width: 70%;
}
.desktop-view .scoring-summary-container .scoring-header .quarter-label .quarter-text {
    margin-left: 12px;
}
.scoring-summary-container .scoring-header .quarter-label .quarter-text {
    letter-spacing: 1px;
    margin-left: 16px;
}
.desktop-view .scoring-summary-container .scoring-header .label {
    padding-right: 12px;
}
.scoring-summary-container .scoring-header .label {
    float: right;
    text-align: right;
    width: 32px;
}
.scoring-summary-container .scoring-header .label img {
    margin-top: 5px;
}
img {
    height: auto;
    max-width: 100%;
    opacity: 1;
    transition: opacity .5s ease-in .5s;
    vertical-align: top;
}

.scoring-summary-container .scoring_default {
    color: #232323;
    display: block;
    font-size: 14px;
    padding: 20px 16px 20px 25%;
    text-align: left;
}
.scoring-summary-container .scoring_item {
    border-bottom: 1px solid #E6E7E9;
    clear: both;
    display: table;
    margin-top: 20px;
    padding: 0 0 20px;
    width: 100%;
}
.scoring-summary-container .scoring_item .team_image {
    display: table-cell;
    text-align: center;
    width: 25%;
}
.scoring-summary-container .scoring_item .play_drive_info {
    display: table-cell;
    vertical-align: top;
}
.scoring-summary-container .scoring_item .play_drive_info .play_result .result_str {
    color: #232323;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.5;
    text-transform: uppercase;
}
.scoring-summary-container .scoring_item .play_drive_info .play_result .last_play_time {
    color: #94A1A9;
    font-size: 12px;
    font-weight: 400;
	padding: 5px;
}
.scoring-summary-container .scoring_item .play_drive_info .last_play_description {
    color: #232323;
    font-size: 14px;
    line-height: 1.2;
}
.scoring-summary-container .scoring_item .team_image img {
    height: 54px;
    width: 54px;
}
</style>

<script>

export default {
	props:{
		game_key: { type: Number, required: true},
	},
	data() {
		return {
			game_details:[],
			score_details:[]
		}
	},  
	created() {
		this.getScoreDetails();
	},
	methods: {
		getScoreDetails(){
			axios.get('/scores/get-score-play',{params: {game_key:this.game_key}})
			.then((response)=>{
				this.game_details = response.data.gameArray;
				this.score_details = response.data.scoreArray;
			})
			.catch(error => {});
		}
	},
	mounted() {
		console.log('Component mounted.')
	},
	filters: {
        ordinalSuffix(i) {
            var j = i % 10,
                k = i % 100;
            if (j == 1 && k != 11) {
                return i + "st";
            }
            if (j == 2 && k != 12) {
                return i + "nd";
            }
            if (j == 3 && k != 13) {
                return i + "rd";
            }
            return i + "th";
        }
    }
}
</script>