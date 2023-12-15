<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';

const props = defineProps({
    categories: Array,
    units: Array,
});

const form = useForm({
    item_name: '',
    brand: '',
    color: '',
    size: '',
    category_id: '',
    qty_stock: null,
    unit_id: '',
});

const submit = () => {
    form.post('/purchases/store-item', {
        onSuccess: () => {
            form.reset();
        }
    });
}

</script>

<template>
    <div class="bg-white shadow rounded-md p-6">
        <h4 class="text-lg text-gray-700 font-semibold">Item Details</h4>
        <div class="py-2">
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="item_name" class="block font-medium text-sm text-gray-700">Item name</label>
                    <input v-model="form.item_name" type="text" id="item_name" 
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                    :class="{'border-red-600' : form.errors.item_name}">
                    <InputError :message="form.errors.item_name" />
                </div>
                <div class="mb-4">
                    <label for="brand" class="block font-medium text-sm text-gray-700">Brand</label>
                    <input v-model="form.brand" type="text" id="brand" 
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                    :class="{'border-red-600' : form.errors.brand}">
                    <InputError :message="form.errors.brand" />
                </div>
                <div class="mb-4">
                    <label for="color" class="block font-medium text-sm text-gray-700">Color</label>
                    <input v-model="form.color" type="text" id="color" 
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                    :class="{'border-red-600' : form.errors.color}">
                    <InputError :message="form.errors.color" />
                </div>
                <div class="mb-4">
                    <label for="size" class="block font-medium text-sm text-gray-700">Size</label>
                    <input v-model="form.size" type="text" id="size" 
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                    :class="{'border-red-600' : form.errors.size}">
                    <InputError :message="form.errors.size" />
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
                    <div class="flex items-center justify-between w-full">

                        <div class="w-1/2">
                            <label for="qty_stock" class="block font-medium text-sm text-gray-700">Quantity Stock</label>
                            <input v-model="form.qty_stock" type="number" id="qty_stock" placeholder="0"
                            :class="{'border-red-600' : form.errors.qty_stock}"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            <InputError :message="form.errors.qty_stock" />
                        </div>

                        <div class="w-1/2 ml-2">
                            <label for="unit" class="block font-medium text-sm text-gray-700">Unit</label>
                            <select v-model="form.unit_id" id="unit" 
                            :class="{'border-red-600' : form.errors.unit_id}"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="">Select Unit</option>
                                <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.unit_name }}</option>
                            </select>
                            <InputError :message="form.errors.unit_id" />
                        </div>
                    </div>
                </div>

                <button type="submit" class="px-3 py-1.5 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" :disabled="form.processing">
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
</template>
