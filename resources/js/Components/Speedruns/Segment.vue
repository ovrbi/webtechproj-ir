<script>
    import moment from 'moment';
    export default
    {
    
    created: function () {
    this.moment = moment;
        },
    props: 
        {
            segment:Object,
        },
    }
</script>
    
<template>
    <div class="py-4 flex items-stretch px-8">
        <div class="w-full mx-auto px-0">
            <div class="bg-gray-900 shadow-sm sm:rounded-lg border border-gray-600 text-center text-gray-300">
                <div>
                    Place: {{segment.placename}}
                </div>
                <div>
                    {{moment.utc(segment.starttime).format('HH:mm:ss.SSS')}} - {{moment.utc(segment.endtime).format('HH:mm:ss.SSS')}}
                </div>
                <div>
                    Damage: {{segment.damagetaken}}
                </div>
            </div>
        </div>
        <div class="w-full mx-auto px-0">
            <div class="bg-gray-900 shadow-sm sm:rounded-lg border border-gray-600 text-center text-gray-300">
                <div>
                    Boss: {{segment.bossname}}
                </div>
                <div>
                    {{moment.utc(segment.boss_starttime).format('HH:mm:ss.SSS')}} - {{moment.utc(segment.boss_endtime).format('HH:mm:ss.SSS')}}
                </div>
                <div>
                    Damage: {{segment.boss_damagetaken}}
                </div>
            </div>
        </div>
        <div class="w-full mx-auto px-0">
            <div class="bg-gray-900 shadow-sm sm:rounded-lg border border-gray-600 text-center text-gray-300 h-full flex flex-col flex-auto">
                <template v-if="segment.itemname">
                    <div>
                        Item: {{segment.itemname}}
                    </div>
                    <div>
                        Time: {{moment.utc(segment.itemtime).format('HH:mm:ss.SSS')}}
                    </div>
                </template>
                <div v-else class="h-full">
                    No item
                </div>
            </div>
        </div>
    </div>
</template>
