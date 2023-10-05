<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import Table from '@/Components/Table.vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';
import throttle from 'lodash/throttle';
import { watch, ref } from 'vue';

const props = defineProps({
    users: Object,
    filters: Object,
    roles: Array
})

const search = ref(props.filters.search)
const role = ref(!props.filters.role ? '' : props.filters.role);
const status = ref(!props.filters.status ? '' : props.filters.status);

watch([search, role, status], throttle( function ([value1, value2, value3]) {
    router.get('/users', { 
        search: value1,
        role: value2,
        status: value3,
        },{
        preserveState: true,
        replace: true,
    });
}, 300));

const clearSearch = () => {
    search.value = ''
}

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Users',
        url: '/users',
        active: true,
    },
]
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">List of Users</h1>

                <Breadcrumb :crumbs="crumbs" class="mb-4" />

                <div class="relative overflow-x-auto bg-white shadow">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <Link href="/users/create" class="flex items-center space-x-2 px-2 py-2 rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                    <span class="text-sm">Add User</span>
                                </Link>
                            </div>
                            <div class="flex space-x-2">
                                <!-- Status Filter -->
                                <select 
                                v-model="status"
                                class="w-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                                name=""
                                id="facility-head">
                                    <option value="">Filter by status</option>
                                    <option value="true">Active</option>
                                    <option value="false">Deactivated</option>
                                </select>

                                <!-- Role Filter -->
                                <select 
                                v-model="role"
                                class="w-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                                name=""
                                id="facility-head">
                                    <option value="">Filter by role</option>
                                    <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
                                </select>

                                <label for="search" class="relative">
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
                                        placeholder="Search for users">
                                        <span v-show="search" class="absolute right-2 top-3" @click="clearSearch">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                              </svg>                                      
                                        </span>
                                </label>
                                
                            </div>
                        </div>

                        <hr>
                        
                        <Table :users="users.data" />

                        <hr>
                        <!-- Paginator -->
                        <Pagination 
                        v-show="users.data" 
                        :links="users.links"
                        :current_page="users.current_page"
                        :prev_page_url="users.prev_page_url"
                        :next_page_url="users.next_page_url"
                        :last_page="users.last_page"
                        class="mt-4"/>
                    </div>
                </div>


                <div v-show="users.data.length < 1" class="flex flex-col w-full mt-9">
                    <h1 class="text-center text-xl text-gray-400 mb-6">No user found</h1>
                    <img src="../../Components/images/no-result.png" alt="no result" class="w-[250px] opacity-25 mx-auto">
                </div>


            </div>
        </div>
    </AuthenticatedLayout>
</template>