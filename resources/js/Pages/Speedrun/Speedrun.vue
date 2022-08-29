<script>
    import BreezeNavLink from "@/Components/NavLink.vue";
    import { Head, Link } from "@inertiajs/inertia-vue3";
    import Ambiguous from "@/Layouts/Ambiguous.vue";
    export default {
        components: {
    Head,
    BreezeNavLink,
    Link,
    Ambiguous
},
        props: {
            segments: Object,
            speedrun: Object,
        },
        methods: {

        },
    };
</script>

<template>
    <Head title="Speedrun" />

    <Ambiguous>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <li v-for="item in segments">
            {{ item.order }}
        </li>
    </Ambiguous>
</template>
