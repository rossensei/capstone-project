<script setup>
import { TrashIcon } from '@heroicons/vue/24/outline';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import ProgressBar from '@/Components/ProgressBar.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Alert from '@/Components/Alert.vue';
import CreateItem from './CreateItem.vue';
import CreateExisting from './CreateExisting.vue';
import EditItem from './EditItem.vue';
import DeleteItem from './DeleteItem.vue';
import axios from 'axios'
import { PencilIcon, PlusIcon, MagnifyingGlassIcon, ChevronUpIcon } from '@heroicons/vue/24/solid';
import { EyeIcon  } from '@heroicons/vue/24/outline';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed, onBeforeUpdate } from 'vue';

const props = defineProps({
    items: Array,
});

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

const selectedComponent = ref('')

const changeComponent = (type) => {
    selectedComponent.value = type;
    showModal.value = true;
}

const toEditItem = ref(null);

const editItem = (item) => {
    toEditItem.value = item.id;
    changeComponent('edit-item')
}

const toDeleteItem = ref({});

const deleteItem = (item) => {
    toDeleteItem.value = item;
    changeComponent('delete-item');
}
</script>

<template>
    <Head title="Items" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">


                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-3xl text-gray-700 leading-tight">Inventory Items</h2>
                    <!-- flex items-center justify-start px-3 py-2 rounded-lg bg-[#4e73df] hover:bg-[#7e99eb] text-white text-sm font-semibold duration-300 ease-in -->
                    <div class="relative">
                        <button type="button" @click="toggleActionDropdown" class="text-white bg-[#4e73df] hover:bg-[#7e99eb] font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center leading-none">
                            <span class="flex-1 inline-flex items-center">
                                Add New Item
                                <PlusIcon class="w-4 h-4 stroke-white ml-1 transition-transform" :class="{ 'rotate-45' : showDropdown }" />
                            </span>
                        </button>

                        <!-- Full Screen Dropdown Overlay -->
                        <div v-show="showDropdown" class="fixed inset-0" @click="showDropdown = false"></div>

                        <transition
                        enter-active-class="transition ease-out duration-200"
                        enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-95"
                        >
                            <div v-show="showDropdown" class="z-10 absolute -bottom-24 w-[146px] divide-y divide-gray-100 bg-white rounded-lg shadow">
                                <ul class="py-2 text-sm text-gray-700"> 
                                    <li>
                                        <!-- <Link href="/items/add-item" class="block px-4 py-2 hover:bg-gray-100">Add New</Link> -->
                                        <button type="button" @click="changeComponent('create')" class="w-full px-4 py-2 hover:bg-gray-100 text-left">Add New</button>
                                    </li>
                                    <li>
                                        <button type="button" @click="changeComponent('add-to-existing')" class="w-full px-4 py-2 hover:bg-gray-100 text-left">Add to existing</button>
                                        <!-- <Link href="/items/add-to-existing" class="block px-4 py-2 hover:bg-gray-100">Add to existing</Link> -->
                                    </li>
                                </ul>
                            </div>
                        </transition>
                    </div>
                    
                </div>

                <Alert class="mb-4" />

                <hr class="mt-3 mb-3">

                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span v-if="selectedItems.length != 0" class="text-sm font-medium text-blue-700 ml-1">{{selectedItems.length}} item(s) selected</span>

                        <button type="button" @click="deleteItems" class="px-4 py-2 text-sm font-medium text-white rounded-md" :class="[ !selectedItems.length ? 'text-gray-400 bg-gray-300' : 'bg-red-600 hover:bg-red-500' ]" :disabled="!selectedItems.length">Delete</button>
                    </div>
                    
                    <!-- <div class="relative">
                        <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                        <input 
                            v-model="search"
                            type="text" 
                            id="search" 
                            class="block p-2 pl-10 text-sm text-gray-900 bg-white shadow-sm border border-gray-300 rounded-lg w-80 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Search for items">
                    </div> -->
                </div>

                <div class="relative overflow-x-auto bg-white shadow rounded-lg">
                    <div>
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
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
                                        Used
                                    </th>
                                    <th scope="col" class="w-56 px-6 py-3 text-center">
                                        Available
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date Added
                                    </th>
                                    <th scope="col" class="w-44 px-6 py-3  text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b bg-white hover:bg-gray-50" v-for="item in items" :key="item.id" :class="{'border-l-4 border-l-blue-600' : selectedItems.includes(item.id)}">
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
                                        {{ item.used }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <!-- {{ item.curr_stocks }}/{{ item.init_stocks }} {{ item.unit }}  -->
                                        <ProgressBar :value="item.curr_stocks" :maxVal="item.init_stocks" />
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.category }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.created_at }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <Link href="#" 
                                                class="inline-flex items-center px-2 py-1.5 rounded-lg bg-white hover:bg-gray-50 text-gray-600 border border-gray-300 text-sm font-medium transition-colors ease-in-out duration-300">
                                                <EyeIcon class="w-4 h-4 mr-1" />
                                                Usage
                                            </Link>
                                            <button type="button" @click="editItem(item)" 
                                                class="inline-flex items-center px-2 py-1.5 rounded-lg bg-[#4e73df] hover:bg-[#688dff] text-white text-sm font-medium transition-colors ease-in-out duration-300">
                                                <PencilIcon class="w-3 h-3 mr-1" />
                                                Edit
                                            </button>
                                            <button type="button" @click="deleteItem(item)" 
                                                class="inline-flex items-center px-2 py-1.5 rounded-lg bg-[#EA3C53] hover:bg-[#ff5168] text-white text-sm font-medium transition-colors ease-in-out duration-300">
                                                <TrashIcon class="w-3 h-3 mr-1" />
                                                Delete
                                            </button>
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

        <Modal :show="showModal" @close="closeModal">
            <CreateItem v-if="selectedComponent === 'create'" @close-modal="closeModal" />
            <CreateExisting v-else-if="selectedComponent === 'add-to-existing'" @close-modal="closeModal" />
            <EditItem v-else-if="selectedComponent === 'edit-item'" :item="toEditItem" @close-modal="closeModal" />
            <DeleteItem v-else :item="toDeleteItem" @close-modal="closeModal" />
        </Modal>
    </AuthenticatedLayout>
</template>
