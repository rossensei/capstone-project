<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import ItemsTable from '@/Pages/Item/Partials/ItemsTable.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { InformationCircleIcon, XMarkIcon } from '@heroicons/vue/24/solid'
import { XCircleIcon } from '@heroicons/vue/24/outline'
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';

const props = defineProps({
    categories: Array,
    units: Array,
    item: Object,
});

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false
    },
    {
        name: 'Items',
        url: '/items',
        active: false
    },
    {
        name: 'Edit ' + props.item.name,
        url: null,
        active: true
    },
]

const form = useForm({
    name: props.item.name,
    category_id: props.item.category_id,
    curr_stocks: props.item.curr_stocks,
    unit_id: props.item.unit_id,
});

const errors = ref([])

const submit = () => {
    form.put('/items/' + props.item.id, {
        onError: (err) => {
            errors.value = Object.values(err)
        }
    });
}
</script>

<template>
    <Head title="Add Item" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                <Breadcrumb :crumbs="crumbs" class="mb-4"/>

                <h2 class="font-semibold text-3xl text-gray-700 leading-tight mb-3">Edit "{{ item.name }}" details</h2>

                <hr class="mb-3">

                <div class="bg-white shadow rounded-md p-4 lg:flex lg:items-start">
                    <div class="w-1/2">
                        <div class="max-w-xl lg:max-w-2xl">
                            <h4 class="text-lg text-gray-700 font-semibold mb-2">Item Details</h4>
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
    
                                <button type="submit" class="px-3 py-1.5 text-sm rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" :class="{ 'bg-[#4e72dfc0]' : form.processing }" :disabled="form.processing">
                                    <span v-if="form.processing" class="inilne-flex items-center">
                                        <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                        Submitting...
                                    </span>

                                    <span v-if="!form.processing">Submit</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="ml-3 w-1/2">

                        <div v-if="form.hasErrors" class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <InformationCircleIcon class="w-5 h-5 mr-2" />
                            <span class="sr-only">Danger</span>
                            <div>
                              <span class="font-medium mb-3">{{ errors.length }} Error(s) has occurred:</span>
                                <ul class="mt-1.5 list-inside space-y-1">
                                  <li v-for="(error, index) in errors" :key="index" class="flex items-center">
                                    <XMarkIcon class="w-4 h-4 me-2 stroke-red-600" />
                                    {{ error }}
                                </li>
                              </ul>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
