<script>
    import moment from 'moment';
    import {Link} from '@inertiajs/inertia-vue3';
    export default
    {
    components:
    {
        Link,
    },
    created: function () {
    this.moment = moment;
        },
    props: 
        {
            speedrun:Object,
        },
    }
</script>
    
<template>
    <tr class="divide-x divide-gray-600">
        <td class="text-center"><Link :href="route('userview',speedrun.userid)" class="text-sm text-gray-300  underline">{{speedrun.name}}</Link></td>
        <td class="text-center">{{moment.utc(speedrun.timetotal).format('HH:mm:ss.SSS')}}</td>
        <td class="text-center">{{speedrun.damagetaken}}</td>
        <td class="text-center">{{speedrun.posted}}</td>
        <td class="text-center"> <input type="checkbox" disabled :checked="(speedrun.confirmed_by!=null) ? true : null"></td>
        <td class="text-center">
            <Link :href="route('speedruns',speedrun.id)" class="text-sm text-gray-300 underline">view</Link>
        </td>
    </tr>
</template>
