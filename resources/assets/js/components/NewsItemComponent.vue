<template>
	<b-container fluid>
		<div v-for="news in player_data.fantasy_player_news">
			<div class="newsdeskContentEntry">
				<h2>{{news.team}} | {{player_data.name}} : {{news.title}}</h2>
				<div class="newsDate" >
					<p>{{news.formated_updated}} | by  <a target="blank" :href="news.url">{{news.source}}</a></p>
				</div>
				<p>{{news.content}}</p>
        <hr/>
			</div>
		</div>
	</b-container>
</template>

<script>

export default {
	props:{
		player_data: { required: false },
	},
	data() {
		return {
		}
	}
}
</script>
