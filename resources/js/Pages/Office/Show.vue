<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { ArrowLeftIcon, MagnifyingGlassIcon, PencilSquareIcon } from '@heroicons/vue/24/solid';
import { Head, Link } from '@inertiajs/vue3';

const prop = defineProps({
    department: Object,
    properties: Object
})

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Department',
        url: '/departments',
        active: false,
    },
    {
        name: prop.department.name,
        url: null,
        active: true,
    },
]
</script>

<template>
    <Head :title="department.name" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">

                <Breadcrumb :crumbs="crumbs" class="mb-4" />

                <div class="block md:flex md:items-start md:justify-between mb-4">
                    <div>
                        <h1 class="text-2xl text-gray-700 font-semibold leading-none">{{ department.name }} Inventory</h1>
                        <p class="text-normal font-medium text-gray-600">Department Head - {{ department.head }}</p>
                    </div>

                    <Link :href="'/departments/' + department.id + '/inventory/edit'" class="hidden md:inline-flex md:items-center px-4 py-2 mb-3 bg-[#4e73df] hover:bg-[#688dff] text-white text-sm font-medium rounded-md shadow">
                        <PencilSquareIcon class="w-4 h-4 mr-1 stroke-white" />
                        Edit Inventory</Link>
                </div>
                <p class="text-sm text-gray-600">Last updated on {{ department.updated_at }}</p>

                <hr class="mt-3 mb-3">
                
                <div class="flex items-center justify-between mb-4">
                    <div class="relative">
                        <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                        <input 
                            v-model="search"
                            type="text" 
                            id="table-search-users" 
                            class="block p-2 pl-10 text-sm text-gray-900 bg-white shadow-sm border border-gray-300 rounded-lg w-80 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Search for properties">
                    </div>
                </div>
                
                <div class="overflow-x-auto bg-white shadow rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <th scope="col" class="w-32 px-6 py-3">
                                Tag No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Item
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Acquisition Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Status
                            </th>
                            <!-- <th scope="col" class="px-6 py-3 text-center">
                                Action
                            </th> -->
                        </thead>
                        <tbody class="divide-y">
                            <tr class="bg-white" v-for="(item, index) in properties" :key="index">
                                <td class="px-6 py-4">
                                    {{ item.tag_no }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-700 font-medium">
                                        {{ item.name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                        {{ item.description }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                        {{ item.date_acquired }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                        {{ item.status }}
                                </td>
                            </tr>
                            <tr v-if="properties.length == 0">
                                <td colspan="6"  class="px-6 py-3 text-center">No Records Found</td>
                            </tr>
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