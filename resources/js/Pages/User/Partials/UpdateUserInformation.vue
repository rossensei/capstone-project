<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { InformationCircleIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    user: Object
})

const form = useForm({
    fname: props.user.fname,
    lname: props.user.lname,
    email: props.user.email,
    user: props.user.user,
});

const submit = () => {
    form.patch('/users/' + props.user.id, {
        preserveScroll: true,
        // onSuccess: () => form.reset()
    });
};
</script>

<template>
    <section class="w-full">
        <h2 class="text-xl font-semibold text-gray-600 flex items-center">User Details
            <InformationCircleIcon class="w-5 h-5 ml-2" />
        </h2>
        
        <form @submit.prevent="submit">
            <div  class="mt-2 space-y-2">
                <div>
                    <InputLabel for="fname" value="First Name" />

                    <TextInput
                        id="fname"
                        v-model="form.fname"
                        type="text"
                        class="mt-1 block w-full text-sm"
                    />

                    <InputError :message="form.errors.fname" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="lname" value="Last Name" />

                    <TextInput
                        id="lname"
                        v-model="form.lname"
                        type="text"
                        class="mt-1 block w-full text-sm"
                    />

                    <InputError :message="form.errors.lname" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="user" value="Username" />

                    <TextInput
                        id="user"
                        v-model="form.user"
                        type="text"
                        class="mt-1 block w-full text-sm"
                    />

                    <InputError :message="form.errors.user" class="mt-2" />
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
        </form>
    </section>
</template>