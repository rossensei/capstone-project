<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { ArrowLeftIcon, MagnifyingGlassIcon, PencilSquareIcon } from '@heroicons/vue/24/solid';
import { Head, Link } from '@inertiajs/vue3';

const prop = defineProps({
    office: Object,
    officeTransactions: Array
})

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Offices',
        url: '/offices',
        active: false,
    },
    {
        name: prop.office.office_name + ' Transactions',
        url: null,
        active: true,
    },
]
</script>

<template>
    <Head :title="office.office_name" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">

                <Breadcrumb :crumbs="crumbs" class="mb-4" />

                <div class="block md:flex md:items-start md:justify-between mb-4">
                    <h1 class="text-2xl text-gray-700 font-semibold leading-none">{{ office.office_name }} Transactions</h1>
                </div>

                
                <!-- <div class="flex items-center justify-between mb-4">
                    <div class="relative">
                        <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                        <input 
                            v-model="search"
                            type="text" 
                            id="table-search-users" 
                            class="block p-2 pl-10 text-sm text-gray-900 bg-white shadow-sm border border-gray-300 rounded-lg w-80 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Search for properties">
                    </div>
                </div> -->
                
                <div class="overflow-x-auto bg-white shadow rounded-lg py-6">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <th scope="col" class="px-6 py-3">
                                Personnel
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date & Time
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Remarks
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                No. of Items
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                ...
                            </th>
                        </thead>
                        <tbody class="divide-y">
                            <tr class="bg-white" v-for="(transaction, index) in officeTransactions" :key="index">
                                <td class="px-6 py-4 text-gray-900">
                                    {{ transaction.personnel.name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ transaction.date_time }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ transaction.remarks }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ transaction.transaction_items_count }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <Link :href="'/offices/transactions/' + prop.office.id + '/' + transaction.id" class="text-sm underline text-blue-600">View Items</Link>
                                </td>
                            </tr>
                            <!-- <tr v-if="!transactions.length">
                                <td colspan="6"  class="px-6 py-3 text-center">No Records Found</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>

                <!-- <Pagination 
                    class="mt-4"
                    :data="properties"
                /> -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>