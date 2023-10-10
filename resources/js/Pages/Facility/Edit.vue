<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, useForm } from '@inertiajs/vue3';

const prop = defineProps({
    facility: Object,
    users: Array,
});

console.log(prop.facility.user_id)

const form = useForm({
    facility_name: prop.facility.facility_name,
    building: prop.facility.building,
    user_id: prop.facility.user_id,
});

const submit = () => {
    form.patch('/facilities/' + prop.facility.id)
}

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Facilities',
        url: '/facilities',
        active: false,
    },
    {
        name: 'Edit Facility',
        url: null,
        active: true,
    },
    
]
</script>

<template>
    <Head :title="facility.facility_name" />
    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">Edit {{ facility.facility_name }} details</h1>

                <Breadcrumb :crumbs="crumbs" class="mb-4" />

                <div class="bg-white w-full shadow p-4 rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="max-w-2xl mb-4">
                            <InputLabel value="Facility Name" />
    
                            <TextInput 
                            v-model="form.facility_name" 
                            class="w-full"
                            id="facname" />
    
                            <InputError :message="form.errors.facility_name" />
                        </div>
    
                        <div class="max-w-2xl mb-4">
                            <InputLabel value="Building" />
    
                            <TextInput
                            v-model="form.building"
                            class="w-full"
                            id="building" />
    
                            <InputError :message="form.errors.building" />
                        </div>
    
                        <div class="max-w-2xl mb-4">
                            <InputLabel value="Facility Head" />
    
                            <select 
                            v-model="form.user_id"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            name=""
                            id="facility-head">
                                <option value="">Select user</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.fname }} {{ user.lname }}</option>
                            </select>
    
                            <InputError :message="form.errors.user_id" />
                        </div>

                        <div class="flex justify-start max-w-4xl mb-4">
                            <button type="submit" class="px-4 py-1.5 text-sm bg-blue-600 rounded-md text-white flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                    <path d="M11 2H9v3h2V2Z"/>
                                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z"/>
                                  </svg>
                                  &nbsp;
                                Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>