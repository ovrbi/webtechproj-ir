<script>
import SingleSpeedrun from './SingleSpeedrun.vue';


    export default
    {
        components:
        {
    SingleSpeedrun
},
        props: 
        {
            speedruns:Array,
        },
    }
</script>
        
<template class="w-full">
    <table class="text-gray-400 table-auto w-full">
        <tr class="divide-x divide-gray-600">
            <th>Name</th>
            <th>Time</th>
            <th>Damage</th>
            <th>Date</th>
            <th>Verified</th>
            <th>Link</th>
        </tr>

        <SingleSpeedrun
            v-for="item in speedruns"
            :speedrun="item"
        />
    </table>
</template>