<template>
	<div>
		<div class="alert alert-success" v-if="form.success > 0">
			Your team settings has been updated!
		</div>
		<div class="alert alert-danger" v-if="form.error > 0">
			The photo must be an image.
		</div>
		<form role="form">
			<div class="form-group row">
				<label class="col-md-4 col-form-label text-md-right">Team Name</label>

				<div class="col-md-8">
					<input type="text" class="form-control" name="name" v-model="form.name" :class="{'is-invalid': form.errors.length > 0}">

					<span class="invalid-feedback" v-show="form.errors.length > 0" v-for="error in form.errors">
						{{ error }}
					</span>
					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label text-md-right">Logo</label>
				<div class="col-md-6 d-flex align-items-center">
					<div class="image-placeholder mr-4">
						<span role="img" class="profile-photo-preview" :style="previewStyle"></span>
					</div>
					<div class="spark-uploader mr-4">
						<input ref="photo" type="file" class="spark-uploader-control" name="photo" @change="update" :disabled="form.busy">
						<div class="btn btn-outline-dark">Select Image...</div>
					</div>
				</div>
			</div>
			<!-- Update Button -->
			<div class="form-group row mb-0">
				<div class="col-md-6 offset-md-4">
					<button type="submit" class="btn btn-primary"
									@click.prevent="updateForm"
									:disabled="form.busy">

								Update
				   </button>
				</div>
			</div>
		</form>
	</div>
</template>
<style>
	
.d-flex > *, .d-inline-flex > * {
    flex: none !important;
}
	</style>
<script>

export default {

	created() {
        this.getFantasyTeam();
    },
	computed: {
        /**
         * Calculate the style attribute for the photo preview.
         */
        previewStyle() {
            return `background-image: url(${this.items.logo_url})`;
        }
    },
    data () {
		return {
			form: {
				name: '',
				errors:[],
				success:'',
				error:''
			  },
			items: [],
		}
	},
	methods: {
		getFantasyTeam() {
            axios.get('/team/details')
				.then((response)=>{
					this.items 		= response.data;
					this.form.name 	= response.data.name;
					this.form.photo	= response.data.logo_url;
				})
				.catch(error => {});
        },
		
		update(e) {
            e.preventDefault();

            if ( ! this.$refs.photo.files.length) {
                return;
            }

            var self = this;

            this.startProcessing();

            // We need to gather a fresh FormData instance with the profile photo appended to
            // the data so we can POST it up to the server. This will allow us to do async
            // uploads of the profile photos. We will update the user after this action.
            axios.post('/team/settings/logo', this.gatherFormData())
                .then(
                    () => {
						this.getFantasyTeam();
                        this.finishProcessing();
						this.form.success = 1;
						this.form.error = 0;
                    },
                    (error) => {
						this.finishProcessing();
						this.form.error 	= 1;
						this.form.success 	= 0;
                    }
                );
        },
		/**
         * Gather the form data for the logo upload.
         */
        gatherFormData() {
            const data = new FormData();

            data.append('photo', this.$refs.photo.files[0]);

            return data;
        },
		/**
         * Update the user's team information.
         */
        updateForm() {
            axios.put('/team/settings', this.form)
                .then((response)=>{
					this.form.errors 	= [];
					this.form.success 	= 1;
					this.form.error 	= 0;
                })
				.catch(error => {
					this.form.success = 0;
					this.form.errors = [];
					this.form.errors.push("The name field is required.");
					//console.log(this.form.errors)
				});
        },
		startProcessing(){
			this.form.errors = [];
			this.form.busy = true;
			this.form.successful = false;
		},
		finishProcessing(){
			this.form.busy = false;
			this.form.successful = true;
		}
	}
}


</script>
