<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import CreateUserVector from '@/Components/vectors/CreateUserVector.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    roles: Array
})
const form = useForm({
    fname: '',
    lname: '',
    user: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
})

const submit = () => {
    form.post('/users')
}

</script>

<template>
    <Head title="Create User"/>

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl text-gray-600 font-semibold">Create New User</h1>
            <p class="mt-1 text-sm text-gray-600">
                Add a new user.
            </p>
            <hr class="mt-2 border-gray-300">
        </template>
        <div class="py-6">
            <div class="flex items-start space-x-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-2/3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 max-w-xl">
                        <form @submit.prevent="submit">
                            <h2 class="text-xl font-medium text-gray-600 mb-4">User Details</h2>
                            <!-- <hr class="mt-1 mb-3"> -->
                            <div class="flex w-full space-x-2">
                                <div class="w-full">
                                    <InputLabel for="fname" value="First Name" />
                    
                                    <TextInput
                                        id="fname"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.fname"
                                        autocomplete="fname"
                                    />
                    
                                    <InputError class="mt-2" :message="form.errors.fname" />
                                </div>
    
                                <div class="w-full">
                                    <InputLabel for="lname" value="Last Name" />
                    
                                    <TextInput
                                        id="lname"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.lname"
                                    />
                    
                                    <InputError class="mt-2" :message="form.errors.lname" />
                                </div>
    
                            </div>

                            <div class="mt-4">
                                <InputLabel for="email" value="Email" />
                
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    autocomplete="username"
                                />
                
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="role" value="Role" />
                                <select v-model="form.role" id="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select role</option>
                                    <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.role" />
                            </div>

                            <hr class="mt-6 mb-3">
                            <h2 class="text-xl font-medium text-gray-600 mt-5 mb-4">Login Credentials</h2>

                            <div>
                                <InputLabel for="username" value="User" />
                
                                <TextInput
                                    id="username"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.user"
                                />
                
                                <InputError class="mt-2" :message="form.errors.user" />
                            </div>
                
                            <div class="mt-4">
                                <InputLabel for="password" value="Password" />
                
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    autocomplete="new-password"
                                />
                
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>
                
                            <div class="mt-4">
                                <InputLabel for="password_confirmation" value="Confirm Password" />
                
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password_confirmation"
                                    autocomplete="new-password"
                                />
                
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>
                
                            <div class="mt-4">                
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Register
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="w-1/3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <h4 class="text-xl text-gray-600 text-center font-bold mb-3">Create User</h4>
                     <CreateUserVector></CreateUserVector>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>