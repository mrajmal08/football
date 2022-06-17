
<spark-update-league-waivers :user="user" inline-template >
    <div class="card card-default" v-if="user">
        <div class="card-header">{{__('League Waivers')}}</div>
        <div class="row">
            <div class="col">
                <league-waivers resource="{{ route('league.waivers') }}"/>
            </div>


        </div>

    </div>
</spark-update-league-waivers>
