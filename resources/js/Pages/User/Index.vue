<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import SearchIcon from '@/Components/icons/SearchIcon.vue';
import { Head, router } from '@inertiajs/vue3';
import throttle from 'lodash/throttle';
import { watch, ref } from 'vue';

const props = defineProps({
    users: Array,
    filters: Object
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
            <h2 class="font-semibold text-4xl text-gray-500 leading-tight">Users</h2>
            <hr>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- <h1 class="text-4xl text-gray-500 font-semibold mb-3">Users</h1> -->

                <label class="relative" for="search">
                    <TextInput
                    id="search"
                    type="text"
                    v-model="search"
                    class="mb-3 w-[300px] pl-8"
                    placeholder="Search by name or email"
                    />

                    <SearchIcon class="absolute left-2.5 top-0.5 text-gray-500" />

                    <button v-if="search" @click="clearSearch" type="button" class="ml-2 p-2 bg-gray-400 rounded-lg text-base">CLEAR</button>
                </label>
                
                
                <table class="w-full h-auto">
                    <thead>
                        <tr>
                            <th class="p-2 text-gray-500 border border-gray-300">Profile</th>
                            <th class="p-2 text-gray-500 border border-gray-300">Name</th>
                            <th class="p-2 text-gray-500 border border-gray-300">Email</th>
                            <th class="p-2 text-gray-500 border border-gray-300">Role</th>
                            <th class="p-2 text-gray-500 border border-gray-300">Created At</th>
                            <th class="p-2 text-gray-500 border border-gray-300 text-center">Active</th>
                            <th class="p-2 text-gray-500 border border-gray-300 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in props.users" :key="user.id" class="border border-gray-300">
                            <td class="p-2 border border-gray-300"><img :src="user.profile_photo_url" alt="" class="w-[35px] rounded-full mx-auto"></td>
                            <td class="p-2 border border-gray-300 font-medium text-gray-900 whitespace-nowrap">{{ user.fname }} {{ user.lname}}</td>
                            <td class="p-2 border border-gray-300 text-gray-500">{{ user.email }}</td>
                            <td class="p-2 border border-gray-300 text-center text-gray-500">
                                <span v-for="role in user.roles" :key="role.id" v-html="role.name"></span>
                            </td>
                            <td class="p-2 border border-gray-300 text-center text-gray-500">{{ formatTimestampToDate(user.created_at) }}</td>
                            <td class="p-2 border border-gray-300 text-center text-gray-500">
                                <span v-if="user.active" v-html="'Yes'"></span>
                                <span v-else v-html="'No'"></span>
                            </td>
                            <td class="p-2 border border-gray-300 text-center text-gray-500 space-x-2"><span class="text-gray-700">Edit</span>
                                <span class="text-red-600">Delete</span></td>
                        </tr>
                    </tbody>
                </table>

                <div v-show="users.length < 1" class="flex flex-col w-full mt-14">
                    <h1 class="text-center text-xl text-gray-400 mb-6">No user found</h1>
                    <img src="../../Components/images/no-result.png" alt="no result" class="w-[300px] opacity-25 mx-auto">
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>