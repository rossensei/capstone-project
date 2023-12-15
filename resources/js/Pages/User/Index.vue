<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ArrowPathIcon, ChevronDownIcon, MagnifyingGlassIcon,
    EyeIcon, UserPlusIcon, AdjustmentsHorizontalIcon, CheckCircleIcon, MinusCircleIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import { PencilIcon, ExclamationTriangleIcon, TrashIcon} from '@heroicons/vue/24/outline';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import PaginationWithPerPage from '@/Components/PaginationWithPerPage.vue';
import Table from '@/Components/Table.vue';
import UsersTable from '@/Pages/User/Partials/UsersTable.vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';
import throttle from 'lodash/throttle';
import debounce from 'lodash/debounce';
import { watch, ref } from 'vue';
import Alert from '@/Components/Alert.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    users: Object,
    filters: Object,
    roles: Array
})

const params = ref({
    search: props.filters.search,
    role: props.filters.role,
    status: props.filters.status,
    perPage: props.filters.perPage,
})

watch(() => params, debounce(() => {
    let newParams = params.value;

    Object.keys(newParams).forEach(key => {
        if (newParams[key] === undefined || newParams[key] === '' || newParams[key] === null || newParams[key] === 'undefined') {
            delete newParams[key];
        }
    });

    router.get('/admin/users', newParams, { preserveState: true, replace: true});

}, 300), {
    deep: true
})

const selectedUser = ref({})
const confirmingUserDeletion = ref(false);

const deleteUser = (user) => {
    confirmingUserDeletion.value = true;

    selectedUser.value = user;
}

const closeModal = () => {
    confirmingUserDeletion.value = false;
};

const confirmDeleteUser = () => {
    router.delete('/users/delete/' + selectedUser.value.id, {
        onSuccess: () => closeModal()
    });
}


const toggleActive = (user) => {
    router.post('/admin/users/toggle-active/' + user.id, {
        preserveState: true,
    })
}

// Data Table Filters functions
const updatePerPage = (newPerPage) => {
    // console.log(newPerPage);
    params.value.perPage = newPerPage;
}

const updateRoleFilter = (ev) => {
    params.value.role = ev.target.value;
}

const updateActiveStatusFilter = (ev) => {
    params.value.status = ev.target.value;
}

const clearAllFilters = () => {
    params.value = {};
}
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="sm:p-4 xl:p-6">
            <div>
                
                <div class="flex items-center justify-between mb-4">
                    <h1 class="font-semibold text-3xl text-gray-700 leading-tight">Manage Users</h1>
                    <Link href="/admin/users/create" class="flex items-center px-3 py-2 rounded-lg bg-[#4e73df] hover:bg-[#4e72dfc0] text-white font-medium">
                        <UserPlusIcon class="w-4 h-4" />
                        <span class="text-sm ml-1">Add User</span>
                    </Link>
                </div>

                <Alert class="mb-4" />


                    <div class="flex items-center justify-between p-4 bg-white mb-4 shadow rounded-lg">
                        
                        <label for="table-search-users" class="relative">
                            <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                            <input 
                                v-model="params.search"
                                type="search" 
                                id="table-search-users" 
                                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-md w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Search for users">
                        </label>

                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <label for="role-filter" class="text-sm text-gray-600 font-medium mr-3">Role</label>
                                <select @change="updateRoleFilter($event)" id="role-filter"
                                class="block p-2 text-sm text-gray-900 border border-gray-300 w-[11rem] rounded-md bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="" :selected="params.role == undefined">All</option>
                                    <option v-for="role in props.roles" :key="role.id" :value="role.name" :selected="params.role == role.name">{{ role.name }}</option>
                                </select>
                            </div>
    
                            <div class="flex items-center">
                                <label for="status-filter" class="text-sm text-gray-600 font-medium mr-3">Status</label>
                                <select @change="updateActiveStatusFilter($event)" id="status-filter"
                                class="block p-2 text-sm text-gray-900 border border-gray-300 w-[8rem] rounded-md bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="" :selected="params.status == undefined">All</option>
                                    <option value="active" :selected="params.status == 'active'">Active</option>
                                    <option value="deactivated" :selected="params.status == 'deactivated'">Deactivated</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        
                    <div class="overflow-x-auto rounded-lg bg-white shadow sm:py-4 2xl:py-6">

                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Address
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Active
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Created At
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-t" v-for="(user, index) in users.data" :key="index">
                                    <th scope="row" class="flex items-center px-6 py-3 text-gray-900 whitespace-nowrap dark:text-white">
                                        <img v-if="user.profile_photo" :src="user.profile_photo_url" alt="user_photo" class="w-10 h-10 rounded-full">
                                        <img v-else src="../../Components/images/user-icon.png" class="w-10 h-10 rounded-full" alt="">
                                        <div class="ps-3">
                                            <div class="text-base font-semibold">{{ user.name }}</div>
                                            <div class="font-normal text-gray-500">{{ user.email }}</div>
                                        </div>  
                                    </th>
                                    <td class="px-6 py-3">
                                        {{ user.address }}
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <div class="flex items-center justify-center">
                                            <label class="relative inline-flex items-center cursor-pointer" :for="'status-checkbox-' + user.id">
                                                <input type="checkbox" :checked="user.active" @change="toggleActive(user)" :id="'status-checkbox-' + user.id" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        {{ new Date(user.created_at).toDateString() }}
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        {{ user.role }}
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center justify-center space-x-2">
                                            <Link :href="'/admin/users/edit-details/' + user.id"
                                                class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                                <PencilIcon class="w-4 h-4" />
                                            </Link>
                                            <button @click="deleteUser(user)" type="button" class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                                  <TrashIcon class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-show="props.users.total < 1" class="bg-white border-b border-t">
                                    <td colspan="6" class="px-6 py-3 text-center">No records found.</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="flex justify-center items-center mt-5 relative">
                            <PaginationWithPerPage
                            :data="props.users"
                            :perPage="params.perPage"
                            @update-per-page="updatePerPage"
                            />

                            <button @click="clearAllFilters" class="absolute right-8 w-10 h-10 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 flex justify-center items-center">
                                <ArrowPathIcon class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <Modal :show="confirmingUserDeletion" @close="closeModal" maxWidth="xl">
            <div class="p-6">
                <div class="flex items-start space-x-3">
                    <div class="shrink-0">
                        <ExclamationTriangleIcon class="w-6 h-6 text-red-500" />
                    </div>
            
                    <div class="flex-1">
                        <h1 class="text-lg font-semibold text-red-600">Delete Confirmation</h1>
                        <div class="text-sm text-gray-800">
                            Are you sure you want to delete "{{ selectedUser.name }}"?
                            You cannot undo this action.
                        </div>
                    </div>
            
                    <div class="shrink-0">
                        <button @click="closeModal">
                            <XMarkIcon class="w-6 h-6 text-gray-600" />
                        </button>
                    </div>
                </div>
        
                <div class="mt-4 flex justify-end items-center space-x-2">
                    <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium" @click="closeModal">Cancel</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium" @click="confirmDeleteUser">Confirm</button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>