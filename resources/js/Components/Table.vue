<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    users: Array
})
</script>

<template>
    <table class="bordered-table">
        <thead class="bg-gray-200">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>
                      {{ user.id }}
                </td>
                <td>
                      {{ user.fname }} {{ user.lname }}
                </td>
                <td>
                      {{ user.email }}
                </td>
                <td class="text-center">
                    <span v-for="role in user.roles" :key="role.id" v-html="role.name"></span>
                </td>
                <td>
                    <div v-if="user.active" class="flex items-center">
                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Active
                    </div>
                    <div v-else class="flex items-center">
                        <div class="h-2.5 w-2.5 rounded-full bg-gray-500 mr-2"></div> Deactivated
                    </div>
                </td>
                <td>
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
    @apply px-4 py-3 text-xs uppercase;
}

.bordered-table tbody tr {
    @apply  border-b border-gray-300 bg-white hover:bg-gray-100;
}
.bordered-table td {
    @apply px-6 py-4 text-gray-600 text-sm;
}
</style>