<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import axios from 'axios';

const isLoaded = ref(false);
const items = ref([]);

const props = defineProps({
    sale: Object,
})

const form = useForm({
    item_id: props.sale.item_id,
    date_sold: props.sale.date_sold,
    qty: props.sale.qty,
});

const emits = defineEmits(['close-modal']);

const submit = () => {
    form.patch('/sales/update-details/' + props.sale.id, {
        onSuccess: () => emits('close-modal')
    })
}

onMounted(() => {
    axios.get('http://127.0.0.1:8000/api/items')
        .then((response) => {
            items.value = response.data;
            isLoaded.value = true;
        }).catch((err) => {
            console.log(err);
        })
})


</script>

<template>
    <div v-if="!isLoaded" class="w-full p-6 animate-pulse">
        <div class="h-6 w-[120px] bg-gray-300 rounded-full mb-4"></div>

        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="bg-gray-200 rounded-full h-7 w-full mb-4"></div>
        <div class="bg-gray-200 rounded-full h-7 w-full mb-4"></div>

        <div class="flex justify-end items-center">
            <div class="h-7 w-[120px] bg-gray-200 rounded-full"></div>
            <div class="h-7 w-[120px] bg-gray-300 rounded-full ml-3"></div>
        </div>
    </div>

    <div v-else class="bg-white w-full shadow p-6 rounded-lg">
        <h1 class="text-xl text-gray-700 font-semibold mb-2">Edit Sale Details</h1>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <InputLabel for="item_id" value="Item" />
                <select v-model="form.item_id" id="item_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-sm">
                    <option v-for="item in items" :key="item.id" :value="item.id">{{ item.item_name }}</option>
                </select>
                <InputError :message="form.errors.item_id" />
            </div>

            <div class="mb-4">
                <InputLabel for="date_sold" value="Date Sold" />
                <TextInput
                v-model="form.date_sold" 
                type="date"
                class="w-full text-sm"
                id="date_sold" />
                <InputError :message="form.errors.date_sold" />
            </div>
            
            <div class="mb-4">
                <InputLabel for="qty" value="Quantity Sold" />
                <TextInput
                v-model="form.qty" 
                type="number"
                class="w-full text-sm"
                id="qty" />
                <InputError :message="form.errors.qty" />
            </div>

            <div class="flex items-center justify-end space-x-2">
                <button type="button" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium" @click="emits('close-modal')">Cancel</button>
                <button type="submit" class="px-4 py-2 text-sm rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white ml-2" :class="{ 'bg-[#4e72dfc0]' : form.processing }" :disabled="form.processing">
                    <span v-if="form.processing" class="inilne-flex items-center">
                        <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        Saving..
                    </span>
    
                    <span v-if="!form.processing">Save</span>
                </button>
            </div>
        </form>
    </div>
</template>