<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
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
    <section class="">
        <h2 class="text-lg font-medium text-gray-900 flex items-center">User Details &nbsp;
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                  </svg>                  
            </span>
        </h2>

        <!-- <p class="mt-1 text-sm text-gray-600">
            Update user details.
        </p> -->
        <hr class="mt-1">

        
        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="fname" value="First Name" />

                <TextInput
                    id="fname"
                    v-model="form.fname"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError :message="form.errors.fname" class="mt-2" />
            </div>

            <div>
                <InputLabel for="lname" value="Last Name" />

                <TextInput
                    id="lname"
                    v-model="form.lname"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError :message="form.errors.lname" class="mt-2" />
            </div>

            <div>
                <InputLabel for="user" value="Username" />

                <TextInput
                    id="user"
                    v-model="form.user"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError :message="form.errors.user" class="mt-2" />
            </div>
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <!-- <PrimaryButton :disabled="form.processing">Save</PrimaryButton> -->
                <button type="submit" class="px-4 py-1.5 rounded-md text-sm flex items-center text-white bg-blue-600 hover:bg-blue-500 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2V2Z"/>
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z"/>
                      </svg>
                      &nbsp;
                      Save</button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>