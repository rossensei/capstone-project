<script setup>
import { TrashIcon } from '@heroicons/vue/24/outline';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import ProgressBar from '@/Components/ProgressBar.vue';
import PaginationWithPerPage from '@/Components/PaginationWithPerPage.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Alert from '@/Components/Alert.vue';
import CreateItem from './CreateItem.vue';
import CreateExisting from './CreateExisting.vue';
import EditItem from './EditItem.vue';
import DeleteItem from './DeleteItem.vue';
import axios from 'axios'
import { PencilIcon, PlusIcon, MagnifyingGlassIcon, ChevronUpIcon, ArrowPathIcon } from '@heroicons/vue/24/outline';
import { EyeIcon  } from '@heroicons/vue/24/outline';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed, onBeforeUpdate } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
    categories: Array,
    items: Object,
    filters: Object
});

// filters
const params = ref({
    search: props.filters.search,
    perPage: props.filters.perPage,
    category: props.filters.category,
    status: null,
    field: props.filters.field,
    direction: props.filters.direction,
})

watch(() => params, debounce(() => {
    let newParams = params.value;

    Object.keys(newParams).forEach(key => {
        if (newParams[key] === undefined || newParams[key] === '' || newParams[key] === null || newParams[key] === 'undefined') {
            delete newParams[key];
        }
    });

    router.get('/admin/items', newParams, { preserveState: true, replace: true });
}, 300), {
    deep: true
})

const updatePerPage = (newPerPage) => {
    params.value.perPage = newPerPage;
}

const addCategoryFilter = (ev) => {
    params.value.category = ev.target.value;
}

const sort = (field) => {
    params.value.field = field;
    params.value.direction = params.value.direction === 'asc' ? 'desc' : 'asc';
}

const clearAllFilters = () => {
    params.value = {};
}

//handling bulk delete section
const selectedItems = ref([]);

const selectAll = ref(false);

const toggleSelectAll = () => {
    if(selectAll.value){
        selectedItems.value = props.items.map(item => item.id)
    } else {
        selectedItems.value = [];
    }
}

const deleteItems = () => {
    if(selectedItems.value.length) {
        router.delete('/items/delete-items', {
            data: {
                ids: selectedItems.value
            },
            onSuccess: () => {
                selectedItems.value = [];
            }
        });
    }
}

const showDropdown = ref(false);

const toggleActionDropdown = () => {
    showDropdown.value = !showDropdown.value
}

const showModal = ref(false);

const closeModal = () => {
    showModal.value = !showModal.value;
}

const actionType = ref('')

const changeComponent = (type) => {
    actionType.value = type;
    showModal.value = true;
}

const selectedItemForEdit = ref(null);

const editItem = (itemId) => {
    selectedItemForEdit.value = itemId;
    changeComponent('edit')
}

const selectedItemForDelete = ref({});

const deleteItem = (item) => {
    selectedItemForDelete.value = item;
    changeComponent('delete');
}

</script>

<template>
    <Head title="Items" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">


                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-3xl text-gray-700 leading-tight">Inventory Items</h2>
                </div>

                <Alert class="mb-4" />


                <div class="flex items-center justify-between mb-4 bg-white p-4 shadow rounded-lg">
                    <!-- <div class="flex items-center space-x-2">
                        <span v-if="selectedItems.length != 0" class="text-sm font-medium text-blue-700 ml-1">{{selectedItems.length}} item(s) selected</span>

                        <button type="button" @click="deleteItems" class="px-4 py-2 text-sm font-medium text-white rounded-md" :class="[ !selectedItems.length ? 'text-gray-400 bg-gray-300' : 'bg-red-600 hover:bg-red-500' ]" :disabled="!selectedItems.length">Delete</button>
                    </div> -->
                    <label for="table-search-users" class="relative">
                        <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                        <input 
                            v-model="params.search"
                            type="search" 
                            id="table-search-users" 
                            class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-md w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Search for items">
                    </label>
                    
                    <div class="flex items-center">
                        <div class="flex items-center space-x-2">
                            <label for="category" class="text-sm text-gray-600 font-medium">Category</label>
                            <select @change="addCategoryFilter($event)" id="category" class="w-[12rem] p-2 text-sm text-gray-900 border border-gray-300 rounded-md bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                                <option value="" :selected="params.category == undefined">All</option>
                                <option v-for="category in props.categories" 
                                :key="category.id" 
                                :value="category.id"
                                :selected="params.category == category.id"
                                >
                                {{ category.cat_name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-x-auto bg-white shadow rounded-lg sm:p-4 lg:p-6">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr class="border-l-4 border-gray-100">
                                <th scope="col" class="px-4 py-3">
                                    <div class="flex items-center">
                                        <input v-model="selectAll" @change="toggleSelectAll" id="select-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:transition-colors duration-300">
                                        <label for="select-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 flex items-center" @click="sort('item_name')">
                                    Item
                                    <div class="ml-2">
                                        <span v-show="params.direction === 'desc' || (!params.field && !params.direction)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                              </svg>
                                        </span>
                                        <span v-show="params.direction === 'asc' || (!params.field && !params.direction)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                              </svg>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Qty Stocks
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Used
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-t bg-white" v-for="item in items.data" :key="item.id" :class="{'border-l-4 border-l-blue-600' : selectedItems.includes(item.id)}">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input v-model="selectedItems" :id="'checkbox-' + item.id" :value="item.id" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:transition-colors duration-300">
                                        <label :for="'checkbox-' + item.id" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                    {{ item.name }}
                                </th>
                                <td class="px-6 py-3 text-center">
                                    {{ item.curr_stocks }} {{ item.unit_abbreviation }} 
                                </td>
                                <td class="px-6 py-3 text-center">
                                    {{ (item.init_stocks - item.curr_stocks) }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    {{ item.category }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <!-- {{ item.curr_stocks }}/{{ item.init_stocks }} {{ item.unit }}  -->
                                    <!-- <ProgressBar :value="item.curr_stocks" :maxVal="item.init_stocks" /> -->
                                    <span class="text-xs font-medium uppercase tracking-wide px-4 py-2 rounded-full"
                                    :class="{ 'bg-green-100 text-green-600' : item.status === 'High Stock'}"
                                    >{{ item.status }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="button" @click="editItem(item.id)" 
                                            class="w-8 h-8 bg-white text-gray-600 hover:bg-gray-100 rounded-full flex justify-center items-center">
                                            <PencilIcon class="w-4 h-4" />
                                        </button>
                                        <button type="button" @click="deleteItem(item)" 
                                            class="w-8 h-8 bg-white text-gray-600 hover:bg-gray-100 rounded-full flex justify-center items-center">
                                            <TrashIcon class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-show="items.total < 1" class="bg-white">
                                <td colspan="7" class="px-6 py-3 text-center">No records found.</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Paginator -->
                    <div v-show="items.total > 0" class="flex justify-center items-center mt-5 relative">
                        <PaginationWithPerPage  
                        :data="items"
                        :perPage="params.perPage"
                        @update-per-page="updatePerPage"
                        class="mt-4"/>

                        <button @click="clearAllFilters" class="absolute right-8 w-10 h-10 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 flex justify-center items-center">
                            <ArrowPathIcon class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="showModal" maxWidth="xl" @close="closeModal">

            <EditItem v-if="actionType === 'edit'" :itemId="selectedItemForEdit" @close-modal="closeModal" />
            <DeleteItem v-else-if="actionType === 'delete'" :item="selectedItemForDelete" @close-modal="closeModal" />
        </Modal>
    </AuthenticatedLayout>
</template>
