<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const prop = defineProps({
    facility: Object
})
</script>

<template>
    <Head :title="facility.facility_name" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl text-gray-500 font-semibold">View Facility</h1>
        </template>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">

                <div class="">
                    <h1 class="text-2xl text-gray-500 font-semibold">View Facility - [{{ facility.facility_name }}]</h1>
                    <p class="text-base text-gray-600">Assigned Head: {{ prop.facility.user.fname }} {{ prop.facility.user.lname }}</p>
                </div>

                <hr class="mt-1 mb-4">

                <h4 class="text-lg font-medium text-gray-500 mb-2">List of items from {{ facility.facility_name }}</h4>
                
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="bordered-table">
                        <thead>
                            <th scope="col">
                                #
                            </th>
                            <th scope="col">
                                Tag No.
                            </th>
                            <th scope="col">
                                Serial No.
                            </th>
                            <th scope="col">
                                Item
                            </th>
                            <th scope="col">
                                Description
                            </th>
                            <th scope="col">
                                Condition
                            </th>
                            <th scope="col">
                                Acquisition Date
                            </th>
                            <th scope="col">
                                Remarks
                            </th>
                            <th scope="col">
                                Action
                            </th>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in prop.facility.items" :key="index">
                                <td>
                                    {{ index+1 }}
                                </td>
                                <td>
                                    {{ item.tag_no }}
                                </td>
                                <td>
                                    {{ item.serial_no }}
                                </td>
                                <td>
                                    {{ item.item_name }}
                                </td>
                                <td>
                                    {{ item.description }}
                                </td>
                                <td>
                                    {{ item.condition }}
                                </td>
                                <td>
                                    {{ item.date_acquired }}
                                </td>
                                <td>
                                    {{ item.remarks }}
                                </td>
                                <td>
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

<style scoped>
.bordered-table {
    width: 100%;
    border-collapse: collapse;
}

.bordered-table thead {
    @apply border border-gray-300;
}
.bordered-table th {
    @apply border border-gray-300 px-4 py-3 text-xs uppercase;
}

/**.bordered-table tbody tr {
    @apply  border border-gray-300;
}*/
.bordered-table td {
    @apply border border-gray-300 px-6 py-4 text-gray-600 text-sm;
}

tr:nth-child(odd) {
    @apply bg-white;
}

tr:nth-child(even) {
    @apply bg-none;
}
</style>