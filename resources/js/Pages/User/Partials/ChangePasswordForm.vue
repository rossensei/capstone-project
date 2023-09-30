<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    password: '',
    password_confirmation: '',
});

const props = defineProps({
    user: Number
})

const updatePassword = () => {
    form.patch('/users/update-password/' + props.user , {
        preserveScroll: true,
        onSuccess: () => form.reset()
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 flex items-center">Set New Password &nbsp;
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                      </svg>                      
                </span>
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Set only a new password when it is forgotten.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">  
            <div>
                <!-- <InputLabel for="password" value="New Password" /> -->

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                    placeholder="New Password"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <!-- <InputLabel for="password_confirmation" value="Confirm Password" /> -->

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                    placeholder="Confirm New Password"
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div v-show="form.password || form.password_confirmation" class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

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