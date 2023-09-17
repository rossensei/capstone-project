<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateUserInformation from './Partials/UpdateUserInformation.vue';
import ChangePasswordForm from './Partials/ChangePasswordForm.vue';
import ChangeUserRole from './Partials/ChangeUserRole.vue';
import UserAccountControl from './Partials/UserAccountControl.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    user: Object,
    roles: Array
})
</script>

<template>
    <Head title="Edit User"/>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl text-gray-600 font-semibold">Edit User</h1>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="w-1/3">
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <h1 class="text-xl font-semibold text-gray-600 text-center">{{ user.fname }} {{ user.lname }}</h1>
        
                            <img :src="user.profile_photo_url" alt="" class="w-[180px] mx-auto rounded-full mt-3">
                        </div>
                    </div>
                    
                    <div class="flex-1 space-y-4">
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <UpdateUserInformation :user="user" class="max-w-xl" />
                        </div>
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <ChangeUserRole :user="user" :roles="roles" class="max-w-xl" />
                        </div>
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <UserAccountControl :user="user" class="max-w-xl" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>