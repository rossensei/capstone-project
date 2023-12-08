<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { InformationCircleIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    roles: Array
})

const form = useForm({
    username: props.user.username,
    name: props.user.name,
    email: props.user.email,
    address: props.user.address,
    role: props.user.role,
})

const submit = () => {
    form.patch('/admin/users/' + props.user.id)
}
</script>

<template>
    <section class="w-full">

        <h2 class="text-lg font-semibold text-gray-600 flex items-center">User Information</h2>

        <form @submit.prevent="submit">
            <div class="max-w-4xl">
                <!-- <h2 class="text-xl text-gray-600 font-semibold mb-2">User Information</h2> -->

                <div class="mb-4">
                    <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            class="block w-full text-sm"
                            v-model="form.name"
                            autocomplete="name"
                            placeholder="Full Name"
                        />
                        <span class="text-sm text-red-600" :class="[ !form.errors.name ? 'invisible' : 'visible']">{{ form.errors.name }}</span>
                        <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>

                <div class="mb-4">
                    <InputLabel for="address" value="Address" />
                        <TextInput
                            id="address"
                            type="text"
                            class="block w-full text-sm"
                            v-model="form.address"
                            autocomplete="address"
                            placeholder="Address"
                        />
                        <span class="text-sm text-red-600" :class="[ !form.errors.address ? 'invisible' : 'visible']">{{ form.errors.address }}</span>
                        <!-- <InputError class="mt-2" :message="form.errors.address" /> -->
                </div>

                <div class="mb-4">
                    <InputLabel for="email" value="Email address" />
                        <TextInput
                            id="email"
                            type="email"
                            class="block w-full text-sm"
                            v-model="form.email"
                            autocomplete="username"
                            placeholder="Email address"
                        />
                        <span class="text-sm text-red-600" :class="[ !form.errors.email ? 'invisible' : 'visible']">{{ form.errors.email }}</span>
                        <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                </div>

                <div class="mb-4">
                    <span class="text-sm font-medium text-gray-600">Change Role</span>
                    <div class="flex items-center space-x-3">
                        <div>
                            <input v-model="form.role" value="Administrator" type="radio" name="role" id="role-1" class="hidden peer">
                            <label for="role-1" class="flex items-center px-4 py-2.5 border hover:bg-gray-50 text-sm font-medium select-none cursor-pointer text-gray-600 peer-checked:border-blue-600 peer-checked:text-blue-600 rounded peer-checked:bg-blue-100">
                                Administrator
                            </label>
                        </div>
                        <div>
                            <input v-model="form.role" value="Property Custodian" type="radio" name="role" id="role-2" class="hidden peer">
                            <label for="role-2" class="flex items-center px-4 py-2.5 border hover:bg-gray-50 text-sm font-medium select-none cursor-pointer text-gray-600 peer-checked:border-red-600 peer-checked:text-red-600 rounded peer-checked:bg-red-100">
                                Property Custodian
                            </label>
                        </div>
                        <div>
                            <input v-model="form.role" value="Office Head" type="radio" name="role" id="role-3" class="hidden peer">
                            <label for="role-3" class="flex items-center px-4 py-2.5 border hover:bg-gray-50 text-sm font-medium select-none cursor-pointer text-gray-600 peer-checked:border-orange-600 peer-checked:text-orange-600 rounded peer-checked:bg-orange-100">
                                Office Head
                            </label>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.role" />
                </div>

                <div class="max-w-3xl flex items-center mt-5">
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" :disabled="form.processing">
                        <span v-if="form.processing" class="inline-flex items-center">
                            <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-blue-600 me-2" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            Saving..
                        </span>
        
                        <span v-if="!form.processing">Save</span>
                    </button>
                </div>
            </div>
        </form>
        <!-- <form @submit.prevent="submit">
            <div class="max-w-4xl space-y-2">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full text-sm"
                    />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="username" value="Username" />

                    <TextInput
                        id="username"
                        v-model="form.username"
                        type="text"
                        class="mt-1 block w-full text-sm"
                    />

                    <InputError :message="form.errors.username" class="mt-2" />
                </div>
                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="text"
                        class="mt-1 block w-full text-sm"
                    />

                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <div>
                    <button 
                    type="submit" 
                    class="px-4 py-1.5 rounded-md text-sm text-white font-medium bg-blue-600 hover:bg-blue-500 shadow-md mt-3"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save</button>
                </div>
            </div>
        </form> -->
    </section>
</template>