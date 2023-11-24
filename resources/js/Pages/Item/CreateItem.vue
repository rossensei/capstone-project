<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import axios from 'axios'
import { onMounted, ref } from 'vue'
import { useForm } from '@inertiajs/vue3';
import { InformationCircleIcon, XMarkIcon } from '@heroicons/vue/24/solid'
// import { XMarkIcon } from '@heroicons/vue/24/outline'

const units = ref([]);
const categories = ref([]);
const isLoaded = ref(false);

onMounted(() => {
    axios.get('http://127.0.0.1:8000/api/units')
        .then((response) => {
            units.value = response.data;
        });

    axios.get('http://127.0.0.1:8000/api/categories')
        .then((response) => {
            categories.value = response.data;
        }).finally(() => {
            // Set isLoaded to true once both requests are completed
            isLoaded.value = true;
        });
})

const form = useForm({
    name: '',
    category_id: '',
    curr_stocks: null,
    unit_id: '',
});

const emit = defineEmits(['close-modal']);

const errors = ref([]);

const submit = () => {
    form.post('/items', {
        onSuccess: () => {
           emit('close-modal');
        },
        onError: (err) => {
            errors.value = Object.values(err)
        }
    })
}
</script>

<template>

    <div v-if="!isLoaded" class="w-full p-6 animate-pulse">
        <div class="h-4 w-[120px] bg-gray-300 rounded-full mb-4"></div>

        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="flex items-center space-x-2 mb-4">
            <div class="bg-gray-200 rounded-full h-7 min-w-[150px] flex-1"></div>
            <div class="bg-gray-200 rounded-full h-7 min-w-[150px] flex-1"></div>
            <div class="bg-gray-200 rounded-full h-7 min-w-[150px] flex-1"></div>
        </div>

        <div class="flex justify-end items-center">
            <div class="h-7 w-[120px] bg-gray-200 rounded-full"></div>
            <div class="h-7 w-[120px] bg-gray-300 rounded-full ml-3"></div>
        </div>
    </div>


    <div v-else class="w-full p-6">

        <h4 class="text-lg text-gray-700 font-semibold mb-2">Item Details</h4>

        <div v-if="form.hasErrors" class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 shadow" role="alert">
            <InformationCircleIcon class="w-5 h-5 mr-2" />
            <span class="sr-only">Danger</span>
            <div>
                <span v-if="errors.length > 1" class="font-medium mb-3">{{ errors.length }} errors has occurred:</span>
                <span v-else class="font-medium mb-3">{{ errors.length }} error has occurred:</span>
                <ul class="mt-1.5 list-inside">
                    <li v-for="(error, index) in errors" :key="index" class="flex items-center">
                    <XMarkIcon class="w-4 h-4 me-2 stroke-red-600" />
                    {{ error }}
                </li>
                </ul>
            </div>
        </div>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <label for="item_name" class="block font-medium text-sm text-gray-700">Item name</label>
                <input v-model="form.name" type="text" id="item_name" 
                class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                :class="{'border-red-600' : form.errors.name}">
            </div>

            <div class="flex items-center space-x-2 mb-4">
                <div class="flex items-center space-x-2 flex-1">

                    <div class="w-full">
                        <label for="qty" class="block font-medium text-sm text-gray-700">Quantity Stock</label>
                        <input v-model="form.curr_stocks" type="number" id="qty" 
                        :class="{'border-red-600' : form.errors.curr_stocks}"
                        class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    </div>

                    <div class="w-full">
                        <label for="unit" class="block font-medium text-sm text-gray-700">Unit</label>
                        <select v-model="form.unit_id" id="unit" 
                        :class="{'border-red-600' : form.errors.unit_id}"
                        class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Select Unit</option>
                            <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="">
                    <label for="category" class="block font-medium text-sm text-gray-700">Category</label>
                    <select v-model="form.category_id" id="category" 
                    :class="{'border-red-600' : form.errors.category_id}"
                    class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select Category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.cat_name }}</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <!-- <SecondaryButton @click="$emit('close-modal')">Cancel</SecondaryButton> -->
                <button type="button" @click="$emit('close-modal')" class="inline-flex items-center px-3 py-1.5 border border-[#4e73df] bg-white hover:bg-gray-50 text-[#4e73df] text-sm rounded-md shadow">Cancel</button>
                <button type="submit" class="px-3 py-1.5 text-sm rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white ml-2" :class="{ 'bg-[#4e72dfc0]' : form.processing }" :disabled="form.processing">
                    <span v-if="form.processing" class="inilne-flex items-center">
                        <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        Submitting...
                    </span>
    
                    <span v-if="!form.processing">Submit</span>
                </button>
            </div>
        </form>
    </div>
</template>