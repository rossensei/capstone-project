<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import ItemsTable from '@/Pages/Item/Partials/ItemsTable.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    items: Array,
})

const crumbs = [
    {
        name: 'Dashboard',
        url: '/dashboard',
        active: false
    },
    {
        name: 'Items',
        url: null,
        active: true
    }
];

const getCurrentPercentage = (qty) => {
    return (qty / qty) * 100;
}

const getDateFormat = (d) => {
    const date = new Date(d);

    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const day = date.getDate();
    const month = monthNames[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}

const isDropdownOpen = ref(false);

const openDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
}

const selectedItems = ref([]);

const selectAll = ref(false);

const toggleSelectAll = () => {
    if(selectAll){
        selectedItems.value = props.items.map(item => item.id)
    } else {
        selectedItems.value = [];
    }
}

</script>

<template>
    <Head title="Items" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                <h2 class="font-semibold text-3xl text-gray-700 leading-tight mb-4">List of Items</h2>

                <Breadcrumb :crumbs="crumbs" class="mb-4"/>

                <div class="relative overflow-x-auto bg-white shadow rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <Link href="/items/add-item" class="flex items-center space-x-2 px-2 py-2 rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                    <span class="text-sm">Add Item</span>
                                </Link>

                                <!-- <button @click="openDropdown" id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                                    Action <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                                </button>

                                <div v-if="isDropdownOpen" id="dropdown" class="z-10 block bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
                                    </li>
                                    </ul>
                                </div> -->

                            </div>
                            
                            <div class="flex space-x-2">
                                

                                <label for="search" class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="table-search-users" 
                                        class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Search for items">
                                        <span class="absolute right-2 top-3" @click="clearSearch">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                              </svg>                                      
                                        </span>
                                </label>
                                
                            </div>
                        </div>
                        
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input v-model="selectAll" @change="toggleSelectAll" id="select-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            <label for="select-all" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Item
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Qty Stock
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Used
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Available
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Expiry Date
                                    </th>
                                    <th scope="col" class="px-6 py-3  text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b hover:bg-gray-50" v-for="item in items" :key="item.id">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input v-model="selectedItems" :id="'checkbox-' + item.id" :value="item.id" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            <label :for="'checkbox-' + item.id" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ item.name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ item.category }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.qty_stock }} {{ item.unit }}
                                    </td>
                                    <td class="px-6 py-4">
                                        160
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.qty_stock }} out of {{ item.qty_stock }} {{ item.unit }}
                                        <div id="progress-bar" class="w-full bg-gray-200 rounded-full h-auto">
                                            <div id="percentage" class="bg-green-500 rounded-full h-2" :style="{ 'width': getCurrentPercentage(item.qty_stock) + '%' }"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.expiry_date ? getDateFormat(item.expiry_date) : 'N/A'}}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <Link :href="'/items/edit/' + item.id" class="text-sm text-white rounded-sm p-1 hover:bg-blue-500 bg-blue-600 outline outline-2 hover:outline-blue-300 duration-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                  </svg>
                                            </Link>
                                            <Link :href="'/items/delete-item/' + item.id" as="button" method="DELETE" class="text-sm text-white rounded-sm p-1 hover:bg-red-500 bg-red-600 outline outline-2 hover:outline-red-300 duration-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                  </svg>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Paginator -->
                        <!-- <Pagination 
                        v-show="users" 
                        :links="users.links"
                        :current_page="users.current_page"
                        :prev_page_url="users.prev_page_url"
                        :next_page_url="users.next_page_url"
                        :last_page="users.last_page"
                        class="mt-4"/> -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
