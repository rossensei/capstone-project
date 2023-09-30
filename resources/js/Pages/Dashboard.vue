<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    users: Number,
    facilities: Number,
    items: Number,
})

// const cards = ref([
//     {
//         name: 'Users',
//         count: props.users,
//         href: '/users'
//     },
//     {
//         name: 'Facilities',
//         count: props.facilities,
//         href: '/facilities'
//     },
//     {
//         name: 'Items',
//         count: props.items,
//         href: '/items'
//     },
// ])
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="w-full sm:px-6 lg:px-8">
                <h2 class="font-semibold text-2xl text-gray-600 leading-tight mb-4">Dashboard</h2>
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- <div class="p-6 text-gray-900">Users: {{ users }} {{ facilities }} {{ items }}</div> -->
                    <div class="flex flex-wrap w-full">
                        <div class="min-w-[350px] mb-4 mx-2 flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                            <h5 class="text-2xl font-bold tracking-tight">{{ users }}</h5>
                            <p class="font-normal text-gray-700 mb-2 ">Total Users </p>
                        </div>

                        <div class="min-w-[350px] mb-4 mx-2 flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                            <h5 class="text-2xl font-bold tracking-tight">{{ facilities }}</h5>
                            <p class="font-normal text-gray-700 mb-2 ">Total Facilities </p>
                        </div>

                        <div class="min-w-[350px] mb-4 mx-2 flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                            <h5 class="text-2xl font-bold tracking-tight">{{ items }}</h5>
                            <p class="font-normal text-gray-700 mb-2 ">Total Items </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
