<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    venues: Array,
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="sm:p-4 xl:p-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight">My Venue</h1>
                <button type="button" @click="createSale" class="flex items-center px-3 py-2 rounded-lg bg-[#4e73df] hover:bg-[#4e72dfc0] text-white font-medium">
                    <PlusCircleIcon class="w-4 h-4" />
                    <span class="text-sm ml-1">Add new</span>
                </button>
            </div>

            <div class="overflow-x-auto rounded-lg bg-white shadow sm:py-4 2xl:py-6">

                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Item
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date Sold
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Qty
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b border-t" v-for="(sale, index) in venues" :key="index">
                            <td class="px-6 py-3 text-gray-900 whitespace-nowrap">
                                {{ sale.item.item_name }}
                            </td>
                            <td class="px-6 py-3    ">
                                {{ sale.date_sold }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ sale.qty }}
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- <button @click="editSale(sale)" type="button"
                                        class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                        <PencilIcon class="w-4 h-4" />
                                    </button> -->
                                    <!-- <button @click="deleteSale(sale)" type="button" class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                            <TrashIcon class="w-4 h-4" />
                                    </button> -->
                                </div>
                            </td>
                        </tr>

                        <!-- <tr v-show="props.sales.total < 1" class="bg-white border-b border-t">
                            <td colspan="6" class="px-6 py-3 text-center">No records found.</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
