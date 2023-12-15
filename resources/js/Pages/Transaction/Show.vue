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
    transaction: Object
})


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
        name: 'View Transaction Details',
        url: null,
        active: true,
    },
]
</script>

<template>
    <Head title="View Transaction"/>

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                
                <Breadcrumb :crumbs="crumbs" class="mb-4" />
                
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">View transaction details</h1>

                <Alert class="mb-4" />

                <div class="bg-white rounded-lg shadow p-6 mt-5">

                    <h2 class="text-xl text-gray-600 font-semibold mb-2">Transaction Details</h2>
                    <div class="w-full max-w-4xl">

                        <div class="mb-4">
                            <InputLabel for="personnel" value="Requested by" />
                            <TextInput type="text" :value="props.transaction.personnel.name" disabled class="w-full text-sm" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="personnel" value="Office" />
                            <TextInput type="text" :value="props.transaction.personnel.office.office_name" disabled class="w-full text-sm" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="personnel" value="Date & Time" />
                            <TextInput type="text" :value="props.transaction.date_time" disabled class="w-full text-sm" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="remarks" value="Remarks (Optional)" />
                            <textarea id="remarks" :value="props.transaction.remarks" disabled class="text-sm px-3 py-1.5 w-full rounded-lg border border-gray-300"></textarea>
                        </div>

                        <hr class="mt-3 mb-3">
                    
                        <div class="flex items-end justify-between mb-4">
                            <h4 class="text-md font-semibold text-gray-600">Requested Items</h4>
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
                                        <!-- <th scope="col" class="px-6 py-3 text-center">
                                            Action
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white border-b" v-for="(transaction_item, index) in props.transaction.transaction_items" :key="index">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ transaction_item.item.item_name }}
                                        </th>
                                        <!-- <td class="px-6 py-4">

                                        </td> -->
                                        <td class="px-6 py-4 text-center">
                                            {{ transaction_item.qty }}
                                        </td>

                                        <!-- <td class="px-6 py-4 text-center">
                                            <button class="w-8 h-8 hover:bg-gray-100 flex items-center justify-center rounded-full mx-auto">
                                                <TrashIcon class="w-4 h-4" />
                                            </button>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- <div class="flex mt-4">
                            <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white">
                                <span>Submit</span>
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>