import {Bar, mixins} from 'vue-chartjs'
const { reactiveProp } = mixins
export default {
  extends: Bar,
    mixins: [reactiveProp],
  props:{
	   props: ['options'],
  },
  mounted () {
	  console.log(this.chartData);
    // Overwriting base render method with actual data.
        this.renderChart(this.chartData, {
			  maintainAspectRatio: false,

         legend: { //hides the legend
            display: false,
         },
         scales: { 
		 
            xAxes: [{
            gridLines : {
                display : false
            }
        } ]
         }
      })
  }
}

