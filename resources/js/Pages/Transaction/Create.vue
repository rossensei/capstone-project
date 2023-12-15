<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Modal from '@/Components/Modal.vue';
import Alert from '@/Components/Alert.vue';
import InputCounter from '@/Components/InputCounter.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ArrowLeftIcon, MinusIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

const props = defineProps({
    items: Array,
    personnels: Array,
})

const transac_items = ref([])

const form = useForm({
    personnel_id: null,
    remarks: '',
    transaction_items: [],
})

const submit = () => {
    form.post('/transactions/new-transaction', {
        onSuccess: () => form.reset()
    })
}

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Transactions',
        url: '/transactions',
        active: false,
    },
    {
        name: 'Create New Transaction',
        url: null,
        active: true,
    },
]

const isModalOpen = ref(false);

const addItem = () => {
    form.transaction_items.push({ item_id: null, qty: 1 });
}

const removeItem = (index) => {
    form.transaction_items.splice(index, 1)
}
</script>

<template>
    <Head title="Create Transaction"/>

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                
                <Breadcrumb :crumbs="crumbs" class="mb-4" />
                
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">Create new transaction</h1>

                <Alert class="mb-4" />

                <div class="bg-white rounded-lg shadow p-6 mt-5">

                    <h2 class="text-xl text-gray-600 font-semibold mb-2">Transaction Details</h2>
                    <div class="w-full max-w-4xl">

                        <h2 class="text-md text-gray-600 font-semibold mb-2">Personnel Info</h2>
                        <div class="mb-4">
                            <InputLabel for="personnel" value="Select Personnel" />
                            <select v-model="form.personnel_id" id="personnel" class="text-sm px-3 py-1.5 w-full rounded-lg border border-gray-300">
                                <option value="null">---</option>
                                <option v-for="p in props.personnels" :key="p.id" :value="p.id">{{ p.name }}</option>
                            </select>
                            <InputError :message="form.errors.personnel_id" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="remarks" value="Remarks (Optional)" />
                            <textarea v-model="form.remarks" id="remarks" class="text-sm px-3 py-1.5 w-full rounded-lg border border-gray-300"></textarea>
                            <InputError :message="form.errors.remarks" />
                        </div>

                        <hr class="mt-3 mb-3">
                    
                        <div class="flex items-end justify-between mb-4">
                            <h4 class="text-md font-semibold text-gray-600">Requested Items</h4>
                            <!-- <button type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" >Select Item</button> -->
                        </div>

                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Item name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Qty
                                        </th>
                                        <!-- <th scope="col" class="px-6 py-3">
                                            Category
                                        </th> -->
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white hover:bg-gray-100 border-b" @click="addItem">
                                        <td colspan="3" class="px-6 py-4 text-center">Click here to add items</td>
                                    </tr>

                                    <tr class="bg-white border-b" v-for="(transaction_item, index) in form.transaction_items" :key="index">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            <div>
                                                <select v-model="transaction_item.item_id" :id="transaction_item.id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                    <option value="null">Select item</option>
                                                    <option v-for="item in props.items" :value="item.id">{{ item.item_name }}</option>
                                                </select>
                                            </div>
                                        </th>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center">
                                                <!-- <InputCounter/> -->
                                                <input type="number" 
                                                v-model="transaction_item.qty" min="1" 
                                                class="w-[4rem] text-sm py-1.5 px-3 border border-gray-300 rounded-md"
                                                placeholder="0"
                                                >
                                            </div>
                                        </td>
                                        <!-- <td class="px-6 py-4">
                                            {{ transaction_item.item.category }}
                                        </td> -->

                                        <td class="px-6 py-4 text-center">
                                            <button class="w-8 h-8 hover:bg-gray-100 flex items-center justify-center rounded-full mx-auto" @click="removeItem(index)">
                                                <TrashIcon class="w-4 h-4" />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex mt-4">
                            <button type="button" @click.prevent="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" :disabled="form.processing">
                                <span v-if="form.processing" class="inline-flex items-center">
                                    <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-blue-600 me-2" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    Submitting..
                                </span>
                
                                <span v-if="!form.processing">Submit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="isModalOpen" @close="isModalOpen = false" maxWidth="xl">
            <div class="p-6 max-h-[38rem] overflow-y-auto">
                <h2 class="text-xl text-gray-600 font-semibold mb-2">Available Items From Inventory</h2>

                <ul class="text-sm divide-y divide-gray-300">
                    <li v-for="(item, index) in props.items" :key="item.id">
                        <div class="flex items-center">
                            <div class="p-4 flex-1">
                                <div>{{ item.item_name}}</div>
                            </div>
                            <div class="shrink-0">
                                <button class="px-3 py-1.5 text-xs text-white bg-blue-600 rounded-lg" @click="addItem(item, index)">Add</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>