<script>
    import moment from 'moment';
    import BreezeNavLink from "@/Components/NavLink.vue";
    import { Head, Link } from "@inertiajs/inertia-vue3";
    import Ambiguous from "@/Layouts/Ambiguous.vue";
    import Segment from "@/Components/Speedruns/Segment.vue";
    import { reactive } from 'vue';
    import { Inertia } from '@inertiajs/inertia';
    import { Form} from 'vform';

    export default 
    {
        components: 
        {
            Head,
            BreezeNavLink,
            Link,
            Ambiguous,
            Segment,
        },
        created: function () 
        {
            this.moment = moment;
            for (var key in this.errors){
                alert(key+": "+this.errors[key]);
            }
        },
        updated: function()
        {
            for (var key in this.errors){
                alert(key+": "+this.errors[key]);
            }
        },
        
        props: {
            segments: Object,
            speedrun: Object,
            errors:Object,
            status:String,
        },
        
        data () {
            return {
            form: new Form({
                video: this.speedrun.video,
                id: this.speedrun.id,
              }),
            }
        },
        methods: {
 
            submit() 
            {
                Inertia.post('/speedruns/change', this.form);
            },
            del()
            {
                Inertia.delete('/speedruns/delete/'+this.speedrun.id);
            },
            confirm()
            {
                Inertia.put('/speedruns/confirm/'+this.speedrun.id);
            }
        }       
    };

</script>

<template>
    <Head title="Speedrun" />

    <Ambiguous>
        <div class="max-w-7xl mx-auto py-8">
            
            <div class="flex items-stretch">
                <div class="bg-gray-900 w-full overflow-hidden shadow-sm sm:rounded-lg border border-gray-600 mx-8 my-4 text-gray-300 p-4 basis-2/3">
                    <div>User: {{speedrun.uname}}</div>
                    <div>Submitted at: {{speedrun.posted}}</div>
                    <div><form @submit.prevent="submit">
                        <label for="video">Video: </label><input id="video" v-model="form.video" /><button type="submit">Update</button>
                    </form></div>
                    
                    <div>
                        <div v-if="speedrun.confirmed_by!=null">Confirmed by: {{speedrun.confirmed}}</div>
                        <div v-else-if="$page.props.auth.user&&($page.props.auth.user.type==1)">
                            <form @submit.prevent="confirm"><button type="submit">Confirm</button>
                            </form>
                        </div>
                        <div v-else>Not confirmed</div>
                    </div>
                    <div v-if="$page.props.auth.user&&($page.props.auth.user.type==1||$page.props.auth.user.id==speedrun.user_id)">
                        <form @submit.prevent="del"><button type="submit">DELETE</button>
                        </form>
                    </div>
                </div>
                
                <div class="bg-gray-900 w-full overflow-hidden shadow-sm sm:rounded-lg border border-gray-600 mx-8 my-4 text-gray-300 p-4 basis-1/3">
                    <div>Time: {{moment.utc(speedrun.timetotal).format('HH:mm:ss.SSS')}}</div>
                    <div>Damage: {{speedrun.damagetaken}}</div>
                    <div>Strength: {{speedrun.strength}}</div>
                    <div>Speed: {{speedrun.speed}}</div>
                    <div>Endurance: {{speedrun.endurance}}</div>
                </div>
            </div>
            
            
            <Segment v-for="item in segments" :segment="item" />
        
        </div>
    </Ambiguous>
</template>
