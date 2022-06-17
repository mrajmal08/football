<template>
	<b-row>
		<loading :active.sync="visible" :can-cancel="true"></loading>
		<div class="footer-carousel">
			<div class="toggle-view">
				<a href="javascript:void(0)" v-if="show" v-on:click="show = !show" class="toggle-close">Hide <span class="caret-down"></span></a>
				<a href="javascript:void(0)" v-if="!show" v-on:click="show = !show" class="toggle-close">View <span class="caret-up"></span></a>
			</div>
			<transition name="fade" mode="out-in">
				<div class="card-carousel-wrapper" v-if="show">
					<div class="score-label">
						<a href="javascript:void(0)">
							<div>
								<span class="league-title">NFL</span>
								<span class="scores-title">Scores</span>
							</div>
						</a>
					</div>
					<div class="card-carousel">
						<div class="card-carousel--overflow-container">
							<div class="card-carousel-cards" :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')'}">
								<div class="card-carousel--card" v-for="team_data in fantacy_teams">
									<scores-ticker-game-component :team="team_data" :week="week" :season="season" />
								</div>
							</div>
						</div>
					</div>
					<div class="carousel-nav">
						<div class="card-carousel--nav__left" @click="moveCarousel(-1)" :disabled="atHeadOfList"></div>
						<div class="card-carousel--nav__right" @click="moveCarousel(1)" :disabled="atEndOfList"></div>
					</div>
				</div>
			</transition>
		</div>
	</b-row>
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
			week: { type: Number, required: true},
			game_key: { type: Number, required: true},
			season: { type: Number, required: true},
		},
		data() {
			return {
				currentOffset: 0,
				windowSize: 9,
				paginationFactor: 220,
				visible: false,
				fantacy_teams:[],
				show: true
			}
		},  
		created() {
			this.getPlayerTeam();
		},
		methods: {
			getPlayerTeam(){
				this.visible = true;
				axios.get('/nfl-game-score',{params: {week:this.week,season:this.season}})
				.then((response)=>{
					this.fantacy_teams = response.data;
					var self = this;						
					self.visible = false;
					
				})
				.catch(error => {});
			},
			moveCarousel(direction) {
			  // Find a more elegant way to express the :style. consider using props to make it truly generic
			  if (direction === 1 && !this.atEndOfList) {
				this.currentOffset -= this.paginationFactor;
			  } else if (direction === -1 && !this.atHeadOfList) {
				this.currentOffset += this.paginationFactor;
			  }
			},
		},
		mounted() {
			console.log('Component mounted.')
		},
		computed: {
			atEndOfList() {
			  return this.currentOffset <= (this.paginationFactor * -1) * (this.fantacy_teams.length - this.windowSize);
			},
			atHeadOfList() {
			  return this.currentOffset === 0;
			},
		 },
	}
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s
}

.fade-enter,
.fade-leave-to
{
  opacity: 0
}

.card-carousel-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 40px 0 175px;
  color: #666a73;
}
.footer-carousel{
  left: 0;
  position: fixed;
  bottom: 0;
  transition: bottom .5s;
  width: 100%;
  z-index: 10000;
  background-color: #fff;
  -webkit-box-shadow: -2px 0px 5px 3px rgba(0,0,0,0.31);
  -moz-box-shadow: -2px 0px 5px 3px rgba(0,0,0,0.31);
  box-shadow: -2px 0px 5px 3px rgba(0,0,0,0.10);
}
.footer-carousel .toggle-view {
    background: #393939;
    border-radius: 5px 5px 0 0;
    color: #77B1E9;
    font-weight: 600;
    font-size: 12px;
    height: 25px;
    left: 0;
    letter-spacing: 1px;
    line-height: 1;
    margin: 0;
    padding: 0;
    position: absolute;
    text-align: center;
    text-transform: uppercase;
    top: -25px;
    width: 130px;
}
.footer-carousel .toggle-view a {
    color: #cccccc;
    font-weight: 400;
    line-height: 2.2;
    text-decoration: none;
}
.footer-carousel .caret-down {
  width: 0; 
  height: 0; 
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid #cccccc;
  text-transform: none;
  vertical-align: middle;
  color: #cccccc;
  font-size: 6px;
  margin: 0 0 0 5px;
  position: absolute;
  top: 10px;
}

.footer-carousel .caret-up {
  width: 0; 
  height: 0; 
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-bottom: 5px solid #cccccc;
  text-transform: none;
  vertical-align: middle;
  color: #cccccc;
  font-size: 6px;
  margin: 0 0 0 5px;
  position: absolute;
  top: 10px;
}

.footer-carousel .toggle-view .toggle-close {
    display: block;
}

.card-carousel-wrapper .score-label {
    background: #1287d5;
    border-radius: 0;
    -webkit-box-shadow: 2px 2px 2px 0 rgba(0,0,0,0.30);
    -moz-box-shadow: 2px 2px 2px 0 rgba(0,0,0,0.30);
    box-shadow: 2px 2px 2px 0 rgba(0,0,0,0.30);
    color: #fff;
    font-weight: 600;
    height: 132px;
    left: 0;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 0;
    width: 130px;
    z-index: 1;
}

.footer-carousel .score-label a div {
    line-height: 18px;
    margin: 40px 0 0 20px;
    text-align: left;
    text-decoration: none;
}
.footer-carousel .score-label a{
    text-decoration: none;
}
.footer-carousel .score-label a span.league-title {
    color: #fff;
    display: block;
    font-size: 18px;
    font-weight: 600;
    text-decoration: none;
}
.footer-carousel .score-label a span.scores-title {
    color: #81BAF1;
    display: block;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    text-decoration: none;
}
.footer-carousel .carousel-nav{
   background-color: #1387d5;
   display: flex;
   height: 136px;
   align-items: center;
}
.card-carousel {
  display: flex;
  justify-content: center;
  width: 100%;
}
.card-carousel--overflow-container {
  overflow: hidden;
  height:140px;
}
.card-carousel--nav__left, .card-carousel--nav__right {
  display: inline-block;
  width: 15px;
  height: 15px;
  padding: 10px;
  box-sizing: border-box;
  border-top: 2px solid #ffffff;
  border-right: 2px solid #ffffff;
  cursor: pointer;
  margin: 0 10px;
  transition: transform 150ms linear;
}
.card-carousel--nav__left[disabled], .card-carousel--nav__right[disabled] {
  opacity: 0.2;
  border-color: black;
}
.card-carousel--nav__left {
  transform: rotate(-135deg);
}
.card-carousel--nav__left:active {
  transform: rotate(-135deg) scale(0.9);
}
.card-carousel--nav__right {
  transform: rotate(45deg);
}
.card-carousel--nav__right:active {
  transform: rotate(45deg) scale(0.9);
}

.card-carousel-cards {
  display: flex;
  transition: transform 150ms ease-out;
  transform: translatex(0px);
}

.card-carousel--card img{
  width: 35px;
}
.card-carousel-cards .card-carousel--card {
  padding: 5px;
  min-width: 200px;
  cursor: pointer;
  border-radius: 4px;
  z-index: 3;
  margin-bottom: 2px;
  -webkit-box-shadow: 11px 0px 19px -17px rgba(0,0,0,0.61);
  -moz-box-shadow: 11px 0px 19px -17px rgba(0,0,0,0.61);
  box-shadow: 11px 0px 19px -17px rgba(0,0,0,0.61);
}
.card-carousel-cards .card-carousel--card:first-child {
  margin-left: 0;
}
.card-carousel-cards .card-carousel--card:last-child {
  margin-right: 0;
}
.card-carousel-cards .card-carousel--card img {
  vertical-align: bottom;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
  transition: opacity 150ms linear;
  user-select: none;
}
.card-carousel-cards .card-carousel--card img:hover {
  opacity: 0.5;
}

.card-carousel-cards .card-carousel--card--footer .team-section{
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-bottom: 10px;
}
.card-carousel-cards .card-carousel--card--footer .team-section:last-child{
  padding-bottom:0;
}

.card-carousel-cards .card-carousel--card--footer .team-section.final-score p{
  margin-left: 20px
}
.card-carousel-cards .card-carousel--card--footer {
  border-top: 0;
  padding: 7px 15px;
}
.card-carousel-cards .card-carousel--card--footer p {
  padding: 3px 0;
  margin: 0;
  margin-bottom: 2px;
  font-size: 16px;
  font-weight: 500;
  color: #2c3e50;
  user-select: none;
}
.card-carousel-cards .card-carousel--card--footer p:nth-of-type(2) {
    font-size: 16px;
    font-weight: 400;
    padding: 6px;
    background-color: #cae3f3;
    display: inline-block;
    position: relative;
    margin-left: 30px;
    color: #2c3e50;
}
.card-carousel-cards .card-carousel--card--footer p:nth-of-type(2):before {
  content: "";
  float: left;
  position: absolute;
  top: 0;
  left: -12px;
  width: 0;
  height: 0;
  border-color: transparent rgba(202, 227, 243, 1) transparent transparent;
  border-style: solid;
  border-width: 15px 12px 13px 0px;
}
</style>