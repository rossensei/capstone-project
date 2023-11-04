<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PencilIcon, ChevronDownIcon, EyeIcon } from '@heroicons/vue/24/solid';
import { TrashIcon } from '@heroicons/vue/24/outline';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { ref, watch } from 'vue';

const props = defineProps({
    facilities: Object,
    filters: Object,
});

// const search = ref(props.filters.search);
// const perPage = ref(props.filters.perPage);

const params = ref({
    search: props.filters.search,
    perPage: props.filters.perPage,
})

const clearSearch = () => {
    search.value = '';
}

watch(params, debounce( function () {

    Object.keys(params.value).forEach(key => {
        if(params[key] == '' || params[key] == undefined) {
            delete params[key];
        }
    });

    console.log(params.value)

    router.get('/facilities', params.value, {
        preserveState: true,
        replace: true
    });

}, 300), {
    deep: true,
})

// const getFacilities = () => {
//     router.get
// } 

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
                
                <div class="flex items-center justify-between mb-4">
                    <h1 class="font-semibold text-3xl text-gray-700 leading-tight">List of Facilities</h1>
                    <Link href="/facilities/create" class="flex items-center justify-start px-3 py-2 rounded-full bg-[#4e73df] hover:bg-[#7e99eb] text-white font-semibold duration-150 ease-in">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>                                  
                        <span class="text-sm ml-1">Add Facility</span>
                    </Link>
                </div>

                <Breadcrumb :crumbs="crumbs" class="mb-4" />

                <div class="relative overflow-x-auto bg-white shadow rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center justify-between bg-white mb-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input 
                                    v-model="params.search"
                                    type="text" 
                                    id="table-search-users" 
                                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    placeholder="Search for facilities">
                                    <span v-show="params.search" class="absolute right-2 top-3" @click="clearSearch">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                          </svg>                                      
                                    </span>
                            </div>
                        </div>

                        <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Facility Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                                <th scope="col" class="w-56 px-6 py-3">
                                    Head
                                </th>
                                <th scope="col" class="w-40 px-6 py-3 text-center">
                                    Properties
                                </th>
                                <th scope="col" class="w-56 px-6 py-3 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-gray-50" v-for="(facility, index) in facilities.data" :key="index">
                                <td class="flex items-center px-6 py-4 text-gray-700 whitespace-nowrap">
                                    <div class="text-sm font-medium">{{ facility.facility_name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex">
                                        {{ facility.description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-700 font-medium">
                                        {{ facility.user.fname }} {{ facility.user.lname }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                        {{ facility.facility_properties_count }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <Link :href="'/facilities/' + facility.id + '/view-properties'" class="inline-flex items-center text-xs font-semibold tracking-wide text-gray-600 uppercase rounded-sm px-2 py-1.5 hover:bg-gray-100 duration-300 ease-in-out">
                                            <EyeIcon class="w-4 h-4 mr-1"/>
                                            View
                                        </Link>
                                        <Link :href="'/facilities/edit/' + facility.id" class="inline-flex items-center text-xs font-semibold tracking-wide text-blue-600 uppercase rounded-sm px-2 py-1.5 hover:bg-blue-100 duration-300 ease-in-out">
                                            <PencilIcon class="w-4 h-4 mr-1" />
                                            Edit
                                        </Link>
                                        <Link :href="'/facilities/remove-facility/' + facility.id" as="button" method="DELETE" class="inline-flex items-center text-xs font-semibold text-red-600 uppercase rounded-sm px-2 py-1.5 hover:bg-red-100 duration-300 ease-in-out">
                                              <TrashIcon class="w-[14px] h-[14px] mr-1" />
                                              Delete
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-between items-center mt-4">

                        <div>
                            <label class="text-sm font-normal text-gray-700 inline-flex items-center">
                                Entries per page &nbsp;
                                <select v-model="params.perPage" id="perPage" class="w-18 text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                </select>
                                &nbsp;&nbsp;
                                1-{{ params.perPage }} of {{ facilities.total }} entries
                            </label>
                        </div>

                        <Pagination 
                        class=""
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
        </div>
    </AuthenticatedLayout>
</template>