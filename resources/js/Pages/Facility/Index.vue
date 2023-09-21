<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    facilities: Array
})
</script>

<template>
    <Head title="Facilities" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl text-gray-500 font-semibold">Facilities</h1>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="flex flex-wrap w-full">
                    <Link 
                        v-for="facility in facilities" 
                        :key="facility.id" 
                        :href="'/facilities/view/' + facility.id" 
                        class="min-w-[350px] mb-4 mx-2 flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">

                        <h5 class="text-2xl font-bold tracking-tight">{{ facility.facility_name }}</h5>
                        <p class="font-normal text-gray-700 mb-2 ">[{{ facility.building}} ]</p>
                        <p class="font-normal text-gray-700">Head: {{ facility.user.fname }} {{ facility.user.lname }}</p>
                    </Link>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>