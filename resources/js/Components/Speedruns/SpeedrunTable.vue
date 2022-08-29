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
        
<template>
    <table>
        <tr>
            <th>Name</th>
            <th>Time</th>
            <th>Damage</th>
            <th>Date</th>
            <th>Verified</th>
        </tr>

        <SingleSpeedrun
            v-for="item in speedruns"
            :speedrun="item"
        />
    </table>
</template>