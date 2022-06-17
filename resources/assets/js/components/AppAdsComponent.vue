<template>
<b-container class="bv-example-row" v-if="visible==1"> 
<div><h3>RECOMMENTED</h3></div>

<b-row>

<b-col>
	<b-card
    
    img-src="https://picsum.photos/600/300/?image=25"
    img-alt="Image"
    img-top
    tag="article"
    style="max-width: 20rem;"
    class="mb-2"
  >
     <div class="add-name">
      
<a href="#">PG Diploma in Business Analytics & Intelligence</a>
<br/>
<span>Amity University Online</span>
    </div>
    
  </b-card>
 </b-col> 
 
 <b-col>
  <b-card
    
    img-src="https://picsum.photos/600/300/?image=25"
    img-alt="Image"
    img-top
    tag="article"
    style="max-width: 20rem;"
    class="mb-2"
  >
     <div class="add-name">
      
<a href="#">PG Diploma in Business Analytics & Intelligence</a>
<br/>
<span>Amity University Online</span>
    </div>
    
  </b-card>
  </b-col>
  
   <b-col>
  <b-card
    
    img-src="https://picsum.photos/600/300/?image=25"
    img-alt="Image"
    img-top
    tag="article"
    style="max-width: 20rem;"
    class="mb-2"
  >
     <div class="add-name">
      
<a href="#">PG Diploma in Business Analytics & Intelligence</a>
<br/>
<span>Amity University Online</span>
    </div>
    
  </b-card>
  </b-col>
  
  
   <b-col>
  <b-card
    
    img-src="https://picsum.photos/600/300/?image=25"
    img-alt="Image"
    img-top
    tag="article"
    style="max-width: 20rem;"
    class="mb-2"
  >
    <div class="add-name">
      
<a href="#">PG Diploma in Business Analytics & Intelligence</a>
<br/>
<span>Amity University Online</span>
    </div>
    
  </b-card>
  </b-col>
   </b-row>
 </b-container>
</template>

<style>
.no-table-margin table {
	margin-bottom: 0rem;
}

.add-name a{
	color:#6c6c6c;
	font-size: 14.0px;
    line-height: 19.0px;
}
.add-name span {
    color: #999999;
    font-size: 11.0px;
    font-weight: normal;
    text-decoration: none;
    font-family: proxima-nova, Arial, Helvetica, sans-serif\3b;
    background-image: null;
    text-align: left;
}
</style>

<script> 

export default {
	data () {
		return {			
			visible: 0
		}
	},
	created(){
        this.getSystemSetting();
      },
	  methods: {
		getSystemSetting() {
			this.loading = true;
            axios.get('/get_system_setting')
				.then((response)=>{
					
						this.visible 		= response.data.display_ads;
						this.loading 	= false;
					
				})
				.catch(error => {});
        }
	}
}
</script>