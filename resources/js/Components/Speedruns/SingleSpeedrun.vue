<script>
    import moment from 'moment';
    export default
    {
    /*methods: {
        moment: function () {
            return moment();
        }
    },*/
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
    <tr>
        <td>{{speedrun.name}}</td>
        <td>{{moment.utc(speedrun.timetotal).format('HH:mm:ss.SSS')}}</td>
        <td>{{speedrun.damagetaken}}</td>
        <td>{{speedrun.posted}}</td>
        <td>{{speedrun.confirmed_by!=null}}</td>
    </tr>
</template>
