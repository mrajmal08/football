<style>
.popover {
  max-width : 208px;
  z-index   : 1060;
  width: 100%;
}
.popover-body .col-form-label {
    font-size: 15px;
}
</style><template>
	<b-row>
		<loading :active.sync="visible" :can-cancel="true"></loading>
		<div class="col-lg-4" v-if="league_task.draft_started != 1">
			<div class="card">
				<div class="card-header">
				Send Invitations
				</div>

				<div class="card-body">

					<div v-if="league_task.user['uses_two_factor_auth'] == 1">
            <p v-if="league_task.teams_count < 12 &&league_task.user['uses_two_factor_auth'] == 1" class="card-text">
            You currently have <b> {{league_task.teams_count}} </b> <span v-if="league_task.teams_count == 1">team </span><span v-else>teams </span>in your league. Invite others with your league url: <b>{{league_task.invite_code}}</b>
            </p>
            <p v-else class="card-text">
            Congratulations! Your Fantasy League is full!
            </p>
          </div>

          <div v-if="league_task.user['uses_two_factor_auth'] == 1">
					<div v-show="league_task.teams_count < 12">
						<b-button id="popover-reactive-2" variant="primary" ref="button">
						Invite Someone
						</b-button>
					</div>
          </div>

    <!-- <span>{{league_task.user_id}}</span> -->
    <div v-if="league_task.user['uses_two_factor_auth'] == 0" >
    <button type="submit" data-toggle="modal" data-target="#StripeCardModal" class="btn btn-outline-primary-2 btn-order btn-block">
    <span class="btn-text"></span>
    <span class="btn-hover-text">Invite to Someone</span>

    </button>
    </div>

				</div>
			</div>
		</div>
		<div class="col-lg-6" v-if="league_task.draft_started != 1">
			<div class="card">
				<div class="card-header">
					Invitation List
				</div>
				<div class="card-body">
					<b-table responsive striped bordered large :items="invitation_list"></b-table>
				</div>
			</div>
		</div>
		<!-- Our popover title and content render container -->
		<!-- We use placement 'auto' so popover fits in the best spot on viewport -->
		<!-- We specify the same container as the trigger button, so that popover is close to button -->
		<b-popover
		  target="popover-reactive-2"
		  triggers="click"
		  :show.sync="popoverShow"
		  placement="auto"
		  ref="popover"
		  @show="onShow"
		  @shown="onShown"
		  @hidden="onHidden"
		>


		  <div>
			<b-form-group
			  label="Email"
			  label-for="popover-input-1"
			  label-cols="3"
			  :state="input1state"
			  class="mb-1"
			  description="Enter email address"
			  :invalid-feedback=feedbackText
			>
			  <b-form-input
				ref="input1"
				id="popover-input-1"
				type="email"
				v-model="input1"
				:state="input1state"
				size="sm"
			  ></b-form-input>
			</b-form-group>
			<b-button @click="onClose" size="sm" variant="danger">Cancel</b-button>
			<b-button @click="onOk" size="sm" variant="primary">Send</b-button>
		  </div>


		</b-popover>

    <b-popover
		  target="popover-reactive-1"
		  triggers="click"
		  :show.sync="popoverShow"
		  placement="auto"
		  ref="popover"
		  @show="onShow"
		  @shown="onShown"
		  @hidden="onHidden"
		>


		  <div>
			<b-form-group
			  label="Name"
			  label-for="popover-input-1"
			  label-cols="4"
			  :state="input1state"
			  class="mb-1"
			  description="this is name"
			  :invalid-feedback=feedbackText
			>
			  <b-form-input
				ref="input1"
				id="popover-input-1"
				type="email"
				v-model="input1"
				:state="input1state"
				size="sm"
			  ></b-form-input>
			</b-form-group>
			<b-button @click="onClose" size="sm" variant="danger">Cancel</b-button>
			<b-button @click="onOk" size="sm" variant="primary">Send</b-button>
		  </div>
		</b-popover>



		<div  class="col-lg-6" v-if="league_task.draft_completed == '1' && (league_task.week ==1 || league_task.week ==2) && league_task.season_type == 'REG'">
		<div class="container">
			<div class="alert alert-primary" role="alert">
				Your league season has started! Good luck on a great season!
			</div>
		</div>
		</div>
		<snackbar></snackbar>
	</b-row>
</template>

<style>
	.invitation-list{overflow:scroll;height:300px;}
</style>

<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
	components: {
        Loading
    },
	data () {
		return {

			league_task: [],
			invitation_list: [],
			error	: '',
			feedbackText	: '',
			loading: false,
			input1: '',
			input1state: null,
			emailError: null,
			popoverShow: false,
			visible: false
		}
	},
	created(){
        this.getLeagueTask();
        this.getInvitationList();
	},
	methods: {
		getLeagueTask() {
			this.loading = true;
            axios.get('/league/task')
				.then((response)=>{
					if(typeof(response.data.error) != "undefined" ){
						this.error 		= response.data.error;
						this.loading 	= false;
					}else{
						this.league_task 	= response.data;
						this.loading 		= false;
						this.error			= '';
					}
				})
				.catch(error => {});
        },
		getInvitationList() {
            axios.get('/league/invitation-list')
			.then((response)=>{
				this.invitation_list = response.data;
			})
			.catch(error => {});
        },
		onClose() {
			this.popoverShow = false
		},
		onOk() {
			if (!this.input1) {
			    this.input1state = false
			}else if (!this.validEmail(this.input1)) {
				this.input1state = false
			}else if(this.input1) {
				// Return our popover form results
				this.visible = true;
				axios.post('/league/invitations', {
					email: this.input1,
				})
				.then((response)=>{
					var self = this;
					self.visible = false;
					this.onClose()
					this.invitation_list.push(
						{'email':this.input1,
						'invited_date':moment(new Date()).format('MMMM DD, YYYY'),
						'registered_date': '',
						'team_name':''
						})
					this.$store.dispatch('showSnackBarSuccess',{message:'Invitation has been sent successfully'});
				})
				.catch((error) => {
					this.loading 	= false;
					this.emailError = false;
					this.input1state = false;
					this.visible 	= false;
					this.feedbackText = 'This email is already taken'
				});
			}
		},
		onShow() {
			// This is called just before the popover is shown
			// Reset our popover form variables
			this.input1 = ''
			this.input1state = null
			this.emailError = null
		},
		onShown() {
			// Called just after the popover has been shown
			// Transfer focus to the first input
			this.focusRef(this.$refs.input1)
		},
		onHidden() {
			// Called just after the popover has finished hiding
			// Bring focus back to the button
			this.focusRef(this.$refs.button)
		},
		focusRef(ref) {
			// Some references may be a component, functional component, or plain element
			// This handles that check before focusing, assuming a `focus()` method exists
			// We do this in a double `$nextTick()` to ensure components have
			// updated & popover positioned first
			this.$nextTick(() => {
				this.$nextTick(() => {
					;(ref.$el || ref).focus()
				})
			})
		},
		validEmail: function (email) {
		  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		  return re.test(email);
		},
     goToHome(){
        console.log("aaaa");

      }


	},
	watch: {
      input1(val) {
        if (!this.validEmail(val)) {
			this.input1state = false
			this.feedbackText = 'Please enter valid email'
		}else if (this.emailError != null) {
            this.input1state = false
			this.feedbackText = 'This email is already taken'
        }else if (val) {
            this.input1state = true
			this.feedbackText = ''
        }
      }
    }
}
</script>
