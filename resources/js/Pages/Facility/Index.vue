<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FacilitiesTable from '@/Pages/Facility/Partials/FacilitiesTable.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { ref, watch } from 'vue';

defineProps({
    facilities: Object,
    filters: Object,
});

const search = ref('');


const clearSearch = () => {
    search.value = '';
}

watch(search, debounce( function (value) {
    router.get('/facilities', { search: value }, {
        preserveState: true,
        replace: true
    });
}, 300))

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Facilities',
        url: null,
        active: true,
    },
]
</script>

<template>
    <Head title="Facilities" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">List of Facilities</h1>

                <Breadcrumb :crumbs="crumbs" class="mb-4" />

                <div class="relative overflow-x-auto bg-white shadow rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center justify-between bg-white mb-4">
                            <div class="flex items-center space-x-2">
                                <Link href="/facilities/create" class="flex items-center space-x-1 px-2 py-2 rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                      </svg>                                  
                                    <span class="text-sm">Add Facility</span>
                                </Link>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input 
                                    v-model="search"
                                    type="text" 
                                    id="table-search-users" 
                                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    placeholder="Search for facilities">
                                    <span v-show="search" class="absolute right-2 top-3" @click="clearSearch">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                          </svg>                                      
                                    </span>
                            </div>
                        </div>

                        <FacilitiesTable :facilities="facilities.data" />
                        <!-- <table class="bordered-table">
                            <thead>
                                <th>
                                    #
                                </th>
                                <th>
                                    Facility
                                </th>
                                <th class="text-start">
                                    Building
                                </th>
                                <th class="text-start">
                                    Head
                                </th>
                                <th>
                                    Total Properties
                                </th>
                                <th>
                                    Action
                                </th>
                            </thead>
                            <tbody>
                                <tr v-for="(facility, index) in facilities.data" :key="index">
                                    <td>
                                        {{ index+1 }}
                                    </td>
                                    <td>
                                        {{ facility.facility_name }}
                                    </td>
                                    <td>
                                        {{ facility.building }}
                                    </td>
                                    <td class="text-gray-700 font-medium">
                                        {{ facility.user.fname }} {{ facility.user.lname }}
                                    </td>
                                    <td class="text-center">
                                        {{ facility.items_count }}
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-center space-x-1">
                                            <Link :href="'/facilities/view/' + facility.id" class="text-sm text-white rounded-sm p-1 hover:bg-green-500 bg-green-600 outline outline-2 hover:outline-green-300 duration-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                  </svg>                                              
                                            </Link>
                                            <Link :href="'/facilities/edit/' + facility.id" class="text-sm text-white rounded-sm p-1 hover:bg-blue-500 bg-blue-600 outline outline-2 hover:outline-blue-300 duration-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                  </svg>
                                            </Link>
                                            <Link :href="'/facilities/remove-facility/' + facility.id" as="button" method="DELETE" class="text-sm text-white rounded-sm p-1 hover:bg-red-500 bg-red-600 outline outline-2 hover:outline-red-300 duration-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                  </svg>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table> -->

                        <Pagination 
                        class="mt-4"
                        :links="facilities.links"
                        :current_page="facilities.current_page"
                        :prev_page_url="facilities.prev_page_url"
                        :next_page_url="facilities.next_page_url"
                        :last_page="facilities.last_page"
                        />
                    </div>                    
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

/*.bordered-table thead {
    @apply border border-gray-300;
}**/
.bordered-table th {
    @apply px-4 py-3 text-sm uppercase;
}

/**.bordered-table tbody tr {
    @apply  border border-gray-300;
}*/
.bordered-table td {
    @apply px-4 py-3 text-gray-600;
}

tr:nth-child(odd) {
    @apply bg-gray-100;
}

tr:nth-child(even) {
    @apply bg-none;
}
</style>