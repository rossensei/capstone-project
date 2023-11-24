<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';

const props = defineProps({
    categories: Array,
    units: Array,
});

const form = useForm({
    name: '',
    category_id: '',
    qty: null,
    unit_id: '',
});

const submit = () => {
    form.post('/store-item', {
        onSuccess: () => {
            form.reset();
        }
    });
}

</script>

<template>
    <Head title="Add Item" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                <h2 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">Add new purchased item</h2>


                <div class="bg-white shadow rounded-md">
                    <div class="p-4">
                        <h4 class="text-lg text-gray-700 font-semibold mb-2">Item Details</h4>
                        <div class="py-2 max-w-2xl">
                            <form @submit.prevent="submit">
                                <div class="mb-4">
                                    <label for="item_name" class="block font-medium text-sm text-gray-700">Item name</label>
                                    <input v-model="form.name" type="text" id="item_name" 
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                                    :class="{'border-red-600' : form.errors.name}">
                                    <InputError :message="form.errors.name" />
                                </div>
    
                                <div class="mb-4 w-1/2">
                                    <label for="category" class="block font-medium text-sm text-gray-700">Category</label>
                                    <select v-model="form.category_id" id="category" 
                                    :class="{'border-red-600' : form.errors.category_id}"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                        <option value="">Select Category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.cat_name }}</option>
                                    </select>
                                    <InputError :message="form.errors.category_id" />
                                </div>
    
                                <div class="mb-4 w-1/2">
                                    <div class="flex items-center justify-between w-full">
    
                                        <div class="w-40">
                                            <label for="qty" class="block font-medium text-sm text-gray-700">Quantity Stock</label>
                                            <input v-model="form.qty" type="number" id="qty" 
                                            :class="{'border-red-600' : form.errors.qty}"
                                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                            <InputError :message="form.errors.qty" />
                                        </div>
    
                                        <div class="w-40">
                                            <label for="unit" class="block font-medium text-sm text-gray-700">Unit</label>
                                            <select v-model="form.unit_id" id="unit" 
                                            :class="{'border-red-600' : form.errors.unit_id}"
                                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                <option value="">Select Unit</option>
                                                <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                                            </select>
                                            <InputError :message="form.errors.unit_id" />
                                        </div>
                                    </div>
                                </div>
    
                                <button type="submit" class="px-3 py-1.5 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" :disabled="form.processing">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
