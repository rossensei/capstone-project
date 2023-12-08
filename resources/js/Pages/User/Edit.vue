<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateUserInformation from './Partials/UpdateUserInformation.vue';
import UpdateUserLogon from './Partials/UpdateUserLogon.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Alert from '@/Components/Alert.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { ChevronUpIcon } from '@heroicons/vue/20/solid';
import { ShieldCheckIcon, InformationCircleIcon, IdentificationIcon, KeyIcon, LockClosedIcon } from '@heroicons/vue/24/outline'
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    roles: Array
})

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Users',
        url: '/admin/users',
        active: false,
    },
    {
        name: 'Edit User',
        url: null,
        active: true,
    },
];


</script>

<template>
    <Head :title="user.name "/>

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">
                
                <Breadcrumb :crumbs="crumbs" class="mb-4"/>
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">Edit User Information</h1>

                <Alert class="mb-4" />
                
                <div class="bg-white rounded-lg shadow p-6 mt-5">
                    <UpdateUserInformation :user="props.user" :roles="props.roles" />
                </div>
                <div class="bg-white rounded-lg shadow p-6 mt-5">
                    <UpdateUserLogon :user="props.user" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.fade-from {
    height: 0px;
    opacity: 0;
}

.fade-to {
    height: auto;
    opacity: 100;
}
</style>