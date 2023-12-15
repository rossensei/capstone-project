<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { ArrowLeftIcon, MagnifyingGlassIcon, PencilSquareIcon } from '@heroicons/vue/24/solid';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    office: Object,
    transaction: Object
})

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Offices',
        url: '/offices',
        active: false,
    },
    {
        name: props.office.office_name + ' Transactions',
        url: '/offices/view-transactions/' + props.office.id,
        active: false,
    },
    {
        name: props.transaction.personnel.name + "'s Transaction",
        url: null,
        active: true,
    },
]
</script>

<template>
    <Head :title="office.office_name" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">

                <Breadcrumb :crumbs="crumbs" class="mb-4" />

                <div class="block md:flex md:items-start md:justify-between mb-4">
                    <h1 class="text-2xl text-gray-700 font-semibold leading-none">View Requested Items</h1>
                </div>
                
                <div class="overflow-x-auto bg-white shadow rounded-lg py-6">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <th scope="col" class="px-6 py-3">
                                Item
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Brand
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Req. qty
                            </th>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-t border-b border-gray-300" v-for="(transaction_item, index) in props.transaction.transaction_items" :key="index">
                                <td class="px-6 py-4 text-gray-900">
                                    {{ transaction_item.item.item_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ transaction_item.item.brand }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ transaction_item.qty }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>