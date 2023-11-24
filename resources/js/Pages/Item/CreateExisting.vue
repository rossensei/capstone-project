<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import ItemsTable from '@/Pages/Item/Partials/ItemsTable.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import debounce from 'lodash/debounce'
import axios from 'axios';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted } from 'vue';
import { InformationCircleIcon, XMarkIcon } from '@heroicons/vue/24/solid'
import { XCircleIcon } from '@heroicons/vue/24/outline'
import {
Combobox,
ComboboxInput,
ComboboxOptions,
ComboboxOption,
} from '@headlessui/vue'

const units = ref([]);
const items = ref([]);
const isLoaded = ref(false);

onMounted(() => {
    axios.get('http://127.0.0.1:8000/api/units')
        .then((response) => {
            units.value = response.data;
        });

    axios.get('http://127.0.0.1:8000/api/items')
        .then((response) => {
            items.value = response.data;
        }).finally(() => {
            // Set isLoaded to true once both requests are completed
            isLoaded.value = true;
        });
})

const selectedItem = ref({})
const query = ref('')

const filteredItems = computed(() =>
query.value === ''
    ? items.value
    : items.value.filter((item) => {
        return item.name.toLowerCase().includes(query.value.toLowerCase())
    })
)

const form = useForm({
    qty: null,
});

const errors = ref([]);
const emit = defineEmits(['close-modal'])

const submit = () => {
    if(Object.keys(selectedItem.value).length === 0) {
        alert("You haven't selected an item. Please select an item first.");
        return;
    }

    form.put('/items/add-to-existing/' + selectedItem.value.id, {
        onError: (err) => {
           errors.value = Object.values(err)
        },
        onSuccess: () => emit('close-modal')
    })
}
</script>

<template>

    <div v-if="!isLoaded" class="w-full p-6 animate-pulse">
        <div class="h-4 w-[120px] bg-gray-300 rounded-full mb-4"></div>

        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>

        <div class="flex justify-end items-center">
            <div class="h-7 w-[120px] bg-gray-200 rounded-full"></div>
            <div class="h-7 w-[120px] bg-gray-300 rounded-full ml-3"></div>
        </div>
    </div>

    <div v-else class="w-full p-6">
        <h4 class="text-lg text-gray-700 font-semibold mb-2">Item Details</h4>
        <form @submit.prevent="submit">
            <div class="relative mb-4">
                <label for="qty" class="block font-medium text-sm text-gray-700">Item</label>
                <Combobox v-model="selectedItem">
                    <ComboboxInput
                      @change="query = $event.target.value"
                      :displayValue="(item) => item.name"
                      class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      placeholder="Enter item name"
                    />
                    <ComboboxOptions
                    class="absolute z-10 w-full max-h-44 overflow-y-auto bg-white shadow rounded-lg"
                    >
                      <ComboboxOption
                        v-for="item in filteredItems"
                        :key="item.id"
                        :value="item"
                        class="px-4 py-2 hover:bg-gray-50 text-sm"
                        >
                        {{ item.name }}
                      </ComboboxOption>
                    </ComboboxOptions>
                  </Combobox>
            </div>

            <div class="w-full mb-4">
                <label for="unit" class="block font-medium text-sm text-gray-700">Unit</label>
                <select v-model="selectedItem.unit" id="unit" disabled
                :class="{'border-red-600' : form.errors.unit_id}"
                class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select Unit</option>
                    <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                </select>
            </div>

            <div class="w-full mb-4">
                <label for="qty" class="block font-medium text-sm text-gray-700">Quantity to add</label>
                <input v-model="form.qty" type="number" id="qty" 
                :class="{'border-red-600' : form.errors.qty}"
                class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            </div>

            <div class="flex justify-end items-center">

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
