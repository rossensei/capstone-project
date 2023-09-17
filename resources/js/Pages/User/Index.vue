<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Pagination from '@/Components/Pagination.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';
import throttle from 'lodash/throttle';
import { watch, ref } from 'vue';

const props = defineProps({
    users: Object,
    filters: Object,
    roles: Array
})

const formatTimestampToDate = (timestamp) => {
    const date = new Date(timestamp);

    const options = {
        year: 'numeric',
        month: 'long', // or 'short' or 'numeric' depending on your preference
        day: 'numeric',
    };

    return date.toLocaleDateString(undefined, options);
}

const search = ref(props.filters.search)

watch(search, throttle( function (value) {
    // console.log(newVal)
    router.get('/users',{ search: value}, {
        preserveState: true,
        replace: true,
    });
}, 300));

const clearSearch = () => {
    search.value = ''
}

</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl text-gray-500 font-semibold">List of Users</h1>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800">
                        <div class="flex items-center space-x-2">
                            <Link href="/users/create" class="flex items-center space-x-2 px-2 py-2 rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                <span class="text-sm">Add User</span>
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
                                placeholder="Search for users">
                                <span v-show="search" class="absolute right-2 top-3" @click="clearSearch">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                      </svg>                                      
                                </span>
                        </div>
                    </div>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Role
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <img class="w-10 h-10 rounded-full" :src="user.profile_photo_url" alt="Jese image">
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">{{ user.fname }} {{ user.lname }}</div>
                                        <div class="font-normal text-gray-500">{{ user.email }}</div>
                                    </div>  
                                </th>
                                <td class="px-6 py-4">
                                    <span v-for="role in user.roles" :key="role.id" v-html="role.name"></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div v-if="user.active" class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Active
                                    </div>
                                    <div v-else class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-gray-500 mr-2"></div> Deactivated
                                    </div>
                                </td>
                                <td scope="row" class="px-6 py-4">
                                    <!-- Modal toggle -->
                                    <div class="flex items-center justify-center space-x-2">

                                        <Link :href="'/users/edit/' + user.id" class="hover:text-blue-600 text-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                              </svg>
                                        </Link>

                                        <Link :href="'/users/delete/' + user.id" as="button" method="delete" class="hover:text-red-600 text-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                              </svg>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div v-show="users.data.length < 1" class="flex flex-col w-full mt-9">
                    <h1 class="text-center text-xl text-gray-400 mb-6">No user found</h1>
                    <img src="../../Components/images/no-result.png" alt="no result" class="w-[250px] opacity-25 mx-auto">
                </div>

                <!-- Paginator -->
                <Pagination v-show="users" :links="users.links" class="mt-6"/>

            </div>
        </div>
    </AuthenticatedLayout>
</template>