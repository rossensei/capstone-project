<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Modal from '@/Components/Modal.vue';
import Paginator from '@/Components/Paginator.vue';
import { DocumentPlusIcon } from '@heroicons/vue/24/solid'
import { Head, Link, router } from '@inertiajs/vue3';
import { PencilIcon, TrashIcon, XMarkIcon, ExclamationTriangleIcon, EyeIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

const props = defineProps({
    transactions: Array
})

const isModalOpen = ref(false);

const selectedTransactionForDelete = ref({});

const deleteTransaction = (transaction) => {
    selectedTransactionForDelete.value = transaction;
    isModalOpen.value = true;
}

const confirmDelete = () => {

    // console.log(selectedTransactionForDelete);
    router.delete('/transactions/delete-transaction/' + selectedTransactionForDelete.value.id, {
        onSuccess: () => isModalOpen.value = false
    })
}
</script>
<template>
    <Head title="Transactions" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">

                <div class="flex items-center justify-between mb-4">
                    <h1 class="font-semibold text-3xl text-gray-700 leading-tight">Transactions</h1>
                    <Link href="/transactions/create" class="flex items-center px-3 py-2 rounded-lg bg-[#4e73df] hover:bg-[#4e72dfc0] text-sm text-white font-medium">
                        <DocumentPlusIcon class="w-4 h-4" />
                        <span class="text-sm ml-1">New Transaction</span>
                    </Link>
                </div>

                <div class="overflow-x-auto rounded-lg bg-white shadow sm:py-4 2xl:py-6">

                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Personnel
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Remarks
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Items
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Date & Time
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b border-t" v-for="(transaction, index) in props.transactions" :key="index">
                                <td class="flex items-center px-6 py-3 text-gray-700 whitespace-nowrap">
                                    {{ transaction.personnel.name }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    {{ transaction.remarks }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    {{ transaction.transaction_items_count }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    {{ transaction.date_time }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        <Link :href="'/transactions/view-details/' + transaction.id" class="w-8 h-8 rounded-full flex items-center justify-center bg-white hover:bg-gray-100">
                                            <EyeIcon class="w-4 h-4" />
                                        </Link>
                                        <Link :href="'/transactions/edit-details/' + transaction.id" class="w-8 h-8 rounded-full flex items-center justify-center bg-white hover:bg-gray-100">
                                            <PencilIcon class="w-4 h-4" />
                                        </Link>
    
                                        <button type="button" @click="deleteTransaction(transaction)" class="w-8 h-8 rounded-full flex items-center justify-center bg-white hover:bg-gray-100">
                                            <TrashIcon class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- <tr v-show="props.users.total < 1" class="bg-white border-b border-t">
                                <td colspan="6" class="px-6 py-3 text-center">No records found.</td>
                            </tr> -->
                        </tbody>
                    </table>

                    <!-- <div class="flex justify-center items-center mt-5 relative">
                        <PaginationWithPerPage
                        :data="props.users"
                        :perPage="params.perPage"
                        @update-per-page="updatePerPage"
                        />

                        <button @click="clearAllFilters" class="absolute right-8 w-10 h-10 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 flex justify-center items-center">
                            <ArrowPathIcon class="w-5 h-5" />
                        </button>
                    </div> -->
                </div>
            </div>
        </div>

        <Modal :show="isModalOpen" @close="isModalOpen = false" maxWidth="xl">
            <div class="p-6">

                <div class="flex items-start space-x-3">
                    <div class="shrink-0">
                        <ExclamationTriangleIcon class="w-6 h-6 text-red-500" />
                    </div>
            
                    <div class="flex-1">
                        <h1 class="text-lg font-semibold text-red-600">Delete Confirmation</h1>
                        <div class="text-sm text-gray-800">
                            Are you sure you want to delete this transaction?
                            You cannot undo this action.
                        </div>
                    </div>
            
                    <div class="shrink-0">
                        <button @click="isModalOpen = false">
                            <XMarkIcon class="w-6 h-6 text-gray-600" />
                        </button>
                    </div>
                </div>
        
                <div class="mt-4 flex justify-end items-center space-x-2">
                    <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium" @click="isModalOpen = false">Cancel</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium" @click="confirmDelete">Confirm</button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>