<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Listbox, ListboxButton, ListboxOptions, ListboxOption, } from '@headlessui/vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';

const props = defineProps({
    categories: Array,
    departments: Array,
});

const form = useForm({
    name: '',
    department_id: '',
    category_id: '',
    description: '',
    date_acquired: null,
});

const submit = () => {
    form.post('/store-property', {
        onSuccess: () => {
            form.reset();
        }
    });
}

const selectedDept = ref()

</script>

<template>
    <Head title="Add Item" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                <h2 class="font-semibold text-2xl text-gray-700 leading-tight mb-4">Add new purchased property</h2>


                <div class="bg-white shadow rounded-md">
                    <div class="p-4">
                        <h4 class="text-lg text-gray-700 font-semibold mb-2">Property Details</h4>
                        <div class="py-2 max-w-2xl">
                            <form @submit.prevent="submit">
                                <div class="mb-4">
                                    <label for="item_name" class="block font-medium text-sm text-gray-700">Property name</label>
                                    <input v-model="form.name" type="text" id="item_name" 
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                                    :class="{'border-red-600' : form.errors.name}">
                                    <InputError :message="form.errors.name" />
                                </div>
    
                                <div class="mb-4">
                                    <label for="category" class="block font-medium text-sm text-gray-700">Assign to</label>
                                    <select v-model="form.department_id" id="category" 
                                    :class="{'border-red-600' : form.errors.department_id}"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                        <option value="">Select Department</option>
                                        <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
                                    </select>
                                    <InputError :message="form.errors.department_id" />
                                </div>
                                <div class="mb-4">
                                    <label for="category" class="block font-medium text-sm text-gray-700">Category</label>
                                    <select v-model="form.category_id" id="category" 
                                    :class="{'border-red-600' : form.errors.category_id}"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                        <option value="">Select Category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.cat_name }}</option>
                                    </select>
                                    <InputError :message="form.errors.category_id" />
                                </div>
                                <div class="mb-4">
                                    <label for="category" class="block font-medium text-sm text-gray-700">Description</label>
                                    <textarea v-model="form.description" name="description" id="description" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"></textarea>
                                    <InputError :message="form.errors.description" />
                                </div>
                                <div class="mb-4">
                                    <label for="category" class="block font-medium text-sm text-gray-700">Acquisition Date</label>
                                    <input v-model="form.date_acquired" type="date" id="date_acquired" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                    <InputError :message="form.errors.date_acquired" />
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
