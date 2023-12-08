<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    office: Object
})

// Create property section
const form = useForm({
    name: null,
    description: null,
    date_acquired: null,
    qty: null
})

const emits = defineEmits(['close-modal'])

const submit = () => {
    form.post('/admin/offices/' + props.office.id + '/inventory', {
        onSuccess: () => {
            form.reset();
            emits('close-modal');
        }
    })
}
</script>


<template>
    <div class="p-6">
        <h4 class="text-lg text-gray-700 font-semibold">Add New Property</h4>
        <hr class="mb-2">
        <div class="py-2">
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="item_name" class="block font-medium text-sm text-gray-700">Property name</label>
                    <input v-model="form.name" type="text" id="item_name" 
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                    :class="{'border-red-600' : form.errors.name}">
                    <InputError :message="form.errors.name" />
                </div>
                <div class="mb-4">
                    <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                    <textarea v-model="form.description" name="description" id="description" :class="{'border-red-600' : form.errors.description}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" placeholder="(Optional)"></textarea>
                    <InputError :message="form.errors.description" />
                </div>
                <div class="mb-4">
                    <label for="date_acquired" class="block font-medium text-sm text-gray-700">Acquisition Date</label>
                    <input v-model="form.date_acquired" type="date" id="date_acquired" :class="{'border-red-600' : form.errors.date_acquired}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                    <InputError :message="form.errors.date_acquired" />
                </div>
                <div class="mb-4">
                    <label for="qty" class="block font-medium text-sm text-gray-700">Quantity</label>
                    <input v-model="form.qty" type="number" id="qty" :class="{'border-red-600' : form.errors.qty}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                    <InputError :message="form.errors.qty" />
                </div>
                <div class="flex justify-end items-center space-x-2">
                    <button type="button" class="inline-flex items-center px-3 py-1.5 border border-[#4e73df] bg-white hover:bg-gray-50 text-[#4e73df] text-sm rounded-md shadow" @click="emits('close-modal')">Cancel</button>
                    <button type="submit" class="px-3 py-1.5 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" :disabled="form.processing">
                        <span v-if="form.processing" class="inilne-flex items-center">
                            <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            Saving...
                        </span>
        
                        <span v-if="!form.processing">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>