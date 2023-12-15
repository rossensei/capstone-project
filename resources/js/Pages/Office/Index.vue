<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PlusIcon } from '@heroicons/vue/24/solid';
import { PencilIcon, TrashIcon, MagnifyingGlassIcon, ArrowPathIcon } from '@heroicons/vue/24/outline';
import Alert from '@/Components/Alert.vue';
import Paginator from '@/Components/Paginator.vue';
import PaginationWithPerPage from '@/Components/PaginationWithPerPage.vue';
import Modal from '@/Components/Modal.vue';
import CreateOffice from './Create.vue';
import EditOffice from './Edit.vue';
import DeleteOffice from './Delete.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { ref, watch, computed, onMounted } from 'vue';

const props = defineProps({
    offices: Object,
    filters: Object,
});

const params = ref({
    search: props.filters.search,
    perPage: props.filters.perPage,
    field: props.filters.field,
    direction: props.filters.direction,
})

const from = ref(props.filters.from);
const to = ref(props.filters.to);

watch(() => params, debounce(() => {

    let newParams = params.value;

    Object.keys(newParams).forEach(key => {
        if (newParams[key] === undefined || newParams[key] === '' || newParams[key] === null || newParams[key] === 'undefined') {
            delete newParams[key];
        }
    });

    router.get('/offices', newParams, { preserveState: true, replace: true});

}, 300), {
    deep: true
})

// Data Table Filter Functions
const updatePerPage = (newPerPage) => {
    params.value.perPage = newPerPage;
}

const resetOrder = () => {
    params.value.direction = undefined;
}

const updateFieldFilter = (ev) => {
    params.value.field = ev.target.value;
    resetOrder();
}

const clearAllFilters = () => {
    params.value = {};
}


const showModal = ref(false);

const closeModal = () => {
    showModal.value = !showModal.value;
}

const actionType = ref('');

const selectedOfficeForEdit = ref(null)

const editOffice = (officeId) => {
    showModal.value = true;
    actionType.value = 'edit';
    selectedOfficeForEdit.value = officeId;
}

const selectedOfficeForDelete = ref(null);

const deleteOffice = (office) => {
    showModal.value = true;
    actionType.value = 'delete';
    selectedOfficeForDelete.value = office;
}


const createOffice = () => {
    showModal.value = true;
    actionType.value = 'create';
}
</script>

<template>
    <Head title="List of Offices" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">
                
                <div class="flex items-center justify-between space-x-2 mb-4">
                    <h1 class="font-semibold text-3xl text-gray-700 leading-none">List of Offices</h1>
                    <button @click="createOffice" class="flex items-center justify-start px-3 py-2 rounded-lg bg-[#4e73df] hover:bg-[#6588f1] text-white font-medium text-sm transition-colors">
                        <PlusIcon class="w-4 h-4 mr-1" />                                  
                        <span class="text-sm">New Office</span>
                    </button>
                </div>

                <Alert class="mb-4" />

                <div class="relative overflow-x-auto bg-white rounded-lg shadow py-6">

                    <div class="px-4 flex justify-between items-center mb-4">
                        <div class="relative">
                            <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                            <input 
                                v-model="params.search"
                                type="search" 
                                id="table-search-users" 
                                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-white focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="Search for offices"
                            >
                        </div>
    
                        <!-- <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 font-medium">Sort by</span>
    
                            <select @change="updateFieldFilter($event)" id="field" class="text-sm text-gray-600 bg-white border border-gray-300 rounded-md">
                                <option value="" :selected="params.field == undefined">Select Field</option>
                                <option value="office_name" :selected="params.field ==='office_name'">Office Name</option>
                                <option value="head" :selected="params.field ==='head'">Office Head</option>
                                <option value="date_added" :selected="params.field ==='date_added'">Date Added</option>
                            </select>
    
                            <select v-model="params.direction" id="direction" class="text-sm text-gray-600 bg-white border border-gray-300 rounded-md" :disabled="!params.field">
                                <option value="undefined">Select Order</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div> -->
                    </div>


                        <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 bg-gray-100 uppercase">
                                <th scope="col" class="px-6 py-3">
                                    Office Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date Added
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Actions
                                </th>
                        </thead>
                        <TransitionGroup name="rows" tag="tbody">
                            <tr v-for="(office, index) in offices.data" :key="index" class="border-b border-t">
                                <td class="px-6 py-3">
                                    <Link :href="'/offices/view-transactions/' + office.id" class="text-blue-600 underline">{{ office.office_name }}</Link>
                                </td>

                                <td class="px-6 py-3">
                                    {{ new Date(office.date_added).toDateString() }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex items-center justify-center space-x-1">
                                        <button type="button" @click="editOffice(office.id)"
                                            class="text-gray-500 w-8 h-8 flex justify-center items-center rounded-full hover:bg-gray-100">
                                            <PencilIcon class="w-4 h-4" />
                                            <!-- Edit -->
                                        </button>
                                        <button type="button" @click="deleteOffice(office)"
                                            class="text-gray-500 w-8 h-8 flex justify-center items-center rounded-full hover:bg-gray-100">
                                            <TrashIcon class="w-4 h-4" />
                                            <!-- Delete -->
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </TransitionGroup>
                        <tbody v-if="offices.data.length < 1" class="bg-white">
                            <tr>
                                <td colspan="6" class="px-6 py-3 text-center">No result found</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-6 flex justify-center items-center relative">
                          <PaginationWithPerPage 
                          :data="props.offices"
                          :perPage="params.perPage"
                          @update-per-page="updatePerPage"
                          />

                          <button @click="clearAllFilters" class="absolute right-8 w-10 h-10 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 flex justify-center items-center">
                            <ArrowPathIcon class="w-5 h-5" />
                        </button>
                    </div>               
                </div>      
                
            </div>
        </div>

        <Modal :show="showModal" @close="closeModal" maxWidth="xl">
            <CreateOffice v-if="actionType === 'create'" @close-modal="closeModal" />
            <EditOffice v-else-if="actionType === 'edit'" @close-modal="closeModal" :office="selectedOfficeForEdit" />
            <DeleteOffice v-else @close-modal="closeModal" :office="selectedOfficeForDelete" />
        </Modal>
    </AuthenticatedLayout>
</template>

<style scoped>
.rows-enter-active {
    @apply transition duration-200 ease-in;
}

.rows-enter-from {
    @apply transform scale-95 opacity-0;
}

.rows-enter-to {
    @apply transform scale-100 opacity-100;
}

.rows-leave-active {
    @apply transition duration-300 ease-out;
}

.rows-leave-from {
    @apply transform scale-100 opacity-100;
}

.rows-leave-to {
    @apply transform scale-95 opacity-0;
}
</style>