<script>
import BreezeAuthenticatedLayout from '@/Layouts/Ambiguous.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SpeedrunVue from './Speedrun/Speedrun.vue';
import SpeedrunTable from '@/Components/Speedruns/SpeedrunTable.vue';

export default
{
    components: {
    BreezeAuthenticatedLayout,
    Head,
    SpeedrunVue,
    SpeedrunTable,
},
    props: {
        speedruns:Array,
    },
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg border border-gray-600">
                    <SpeedrunTable :speedruns="speedruns"></SpeedrunTable>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
