<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const prop = defineProps({
    user: Object,
    roles: Array
})
// console.log(prop.user.roles[0].name)
const form = useForm({
    role: prop.user.roles[0].name,
});

const updateRole = () => {
    form.patch('/users/update-role/' + prop.user.id);
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 flex items-center">Change User Role &nbsp;
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                      </svg>                      
                </span>
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update user role.
            </p>
        </header>

        <form @submit.prevent="updateRole" class="mt-6 space-y-6">
            <div class="flex items-center space-x-3">
                <!-- <label for="admin">
                    <input type="radio" v-model="form.role" name="role" id="admin" value="admin"> Administrator
                </label>
                <label for="faculty" class="ml-3">
                    <input type="radio" v-model="form.role" name="role" id="faculty" value="faculty"> Faculty
                </label> -->
                <label v-for="role in roles" :key="role.id" :for="role.name">
                    <input type="radio" v-model="form.role" name="role" :id="role.name" :value="role.name"> {{ role.name }}
                </label> 
            </div>
            <div class="flex items-center gap-4">
                <!-- <PrimaryButton :disabled="form.processing">Save</PrimaryButton> -->
                <button 
                    type="submit" 
                    class="px-4 py-1.5 rounded-md text-sm flex items-center text-white bg-blue-600 hover:bg-blue-500 shadow-md"
                    :disabled="form.processing"
                >
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