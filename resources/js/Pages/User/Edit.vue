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
        <!-- <template #header>
            <h1 class="text-2xl text-gray-600 font-semibold">Edit User</h1>
        </template> -->

        <div class="py-12">
            <div class="w-full sm:px-6 lg:px-8 space-y-6">
                
                <h1 class="text-2xl text-gray-600 font-semibold mb-4">Edit User</h1>
                    
                <div class="space-y-4">
                    <div class="p-4 sm:p-8">
                    <h4 class="text-2xl text-blue-600 font-semibold mb-4 uppercase">[ {{ user.fname }} {{ user.lname }} ]</h4>
                    <UpdateUserInformation :user="user" class="mb-8 max-w-xl" />


                    <h1 class="text-xl font-semibold text-gray-600">Administrative Actions</h1>
                    <hr class="mt-1 mb-4 max-w-xl">
                    <ChangePasswordForm :user="user.id" class="mb-8 max-w-xl" />

                    <hr class="mt-1 mb-4 max-w-xl">
                    
                    <ChangeUserRole :user="user" :roles="roles" class="mb-4 max-w-xl" />

                    <UserAccountControl :user="user" class="max-w-xl" />
                    </div>
                    <!-- <div class="p-4 sm:p-8">
                        <ChangeUserRole :user="user" :roles="roles" class="max-w-xl" />
                    </div>
                    <div class="p-4 sm:p-8">
                        <UserAccountControl :user="user" class="max-w-xl" />
                    </div> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>