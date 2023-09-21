<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const prop = defineProps({
    facility: Object
})
</script>

<template>
    <Head title="View Facility" />
    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl text-gray-500 font-semibold">View Facility</h1>
        </template>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">

                <div class="mb-4 flex justify-between items-center">
                    <h1 class="text-2xl text-gray-500 font-semibold">List of Items - [{{ prop.facility.facility_name }}]</h1>
                    <p class="text-xl text-gray-600">Assigned Head: {{ prop.facility.user.fname }} {{ prop.facility.user.lname }}</p>
                </div>
                
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tag #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Serial #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Item
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Condition
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Acquisition Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Remarks
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in prop.facility.items" :key="index" class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ index+1 }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ item.tag_no }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.serial_no }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.item_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.description }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.condition }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.date_acquired }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.remarks }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-blue-600  hover:underline">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>