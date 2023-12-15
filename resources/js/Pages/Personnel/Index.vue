<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Alert from '@/Components/Alert.vue';
import Modal from '@/Components/Modal.vue';
import PaginationWithPerPage from '@/Components/PaginationWithPerPage.vue';
import CreatePersonnel from './CreatePersonnel.vue';
import EditPersonnel from './EditPersonnel.vue';
import DeletePersonnel from './DeletePersonnel.vue';
import debounce from 'lodash/debounce';
import { PencilIcon, TrashIcon, MagnifyingGlassIcon, ArrowPathIcon } from '@heroicons/vue/24/outline';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import { CheckIcon, ChevronUpDownIcon, XMarkIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    personnels: Object,
    filters: Object,
    offices: Array,
})

// Filters
const params = ref({
    search: props.filters.search,
    perPage: props.filters.perPage,
    office: props.filters.office
})

watch(() => params, debounce(() => {

    let newParams = params.value;

    Object.keys(newParams).forEach(key => {
        if (newParams[key] === undefined || newParams[key] === '' || newParams[key] === null || newParams[key] === 'undefined') {
            delete newParams[key];
        }
    });

    router.get('/personnels', newParams, { preserveState: true, replace: true});

}, 300), {
    deep: true
})

const updatePerPage = (newPerPage) => {
    params.value.perPage = newPerPage;
}

const addOfficeFilter = (ev) => {
    params.value.office = ev.target.value;
}

const clearAllFilters = () => {
    params.value = {};
}
// Actions
const isModalOpen = ref(false);

const actionType = ref('')

const toggleModal = () => {
    isModalOpen.value = true;
}

const createPersonnel = () => {
    isModalOpen.value = true;
    actionType.value = 'create';
}

const selectedPersonnelForEdit = ref({});

const editPersonnel = (personnel) => {
    isModalOpen.value = true;
    selectedPersonnelForEdit.value = personnel;
    actionType.value = 'edit';
}

const selectedPersonnelForDelete = ref({});

const deletePersonnel = (personnel) => {
    isModalOpen.value = true;
    actionType.value = 'delete';
    selectedPersonnelForDelete.value = personnel;
}
</script>

<template>
    <Head title="Personnels" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="font-semibold text-3xl text-gray-700 leading-tight">Personnels</h1>
                    <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" @click="createPersonnel">New Personnel</button>
                </div>

                <Alert class="mb-4" />

                <div class="w-full bg-white rounded-lg shadow py-4 lg:py-6">

                    <div class="px-4 bg-white rounded-lg flex justify-between items-center mb-4">
                        <div class="relative">
                            <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                            <input 
                                v-model="params.search"
                                type="search" 
                                id="table-search-personnels" 
                                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-white focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="Search for personnels"
                            >
                        </div>
    
                        <div class="flex items-center space-x-2">
                            <label for="status-filter" class="text-sm text-gray-600 font-medium">Filter by Office</label>
                            <select @change="addOfficeFilter($event)" id="status-filter"
                            class="block p-2 pr-8 text-sm text-gray-900 border border-gray-300 rounded-md bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="" :selected="params.office == undefined">All</option>
                                <option v-for="office in props.offices" :key="office.id" :value="office.id" :selected="office.id == params.office">{{ office.office_name }}</option>
                            </select>
                        </div>
                    </div>

                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <!-- <th scope="col" class="px-6 py-3">
                                ID
                            </th> -->
                            <th scope="col" class="px-6 py-3">
                                Personnel Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Office
                            </th>
                            <!-- <th scope="col" class="px-6 py-3">
                                Created On
                            </th> -->
                            <th scope="col" class="px-6 py-3 text-center">
                                Action
                            </th>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b border-t" v-for="personnel in props.personnels.data" :key="personnel.id">
                                <!-- <td class="px-6 py-3">
                                    {{ personnel.id }}
                                </td> -->
                                <td class="px-6 py-3 text-gray-700 font-medium">
                                    {{ personnel.name }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ personnel.office }}
                                </td>
                                <!-- <td class="px-6 py-3">
                                    {{ new Date(personnel.created_at).toLocaleString() }}
                                </td> -->
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="button" class="w-8 h-8 hover:bg-gray-100 rounded-full flex justify-center items-center" @click="editPersonnel(personnel)">
                                            <PencilIcon class="w-4 h-4" />
                                        </button>
                                        <button type="button" class="w-8 h-8 hover:bg-gray-100 rounded-full flex justify-center items-center" @click="deletePersonnel(personnel)">
                                            <TrashIcon class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="props.personnels.total < 1" class="bg-white border-b border-t">
                                <td colspan="4" class="px-6 py-4 text-center">No records found.</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-center items-center mt-5 relative">
                        <PaginationWithPerPage
                        :data="props.personnels"
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

        <Modal :show="isModalOpen" @close="isModalOpen = false" maxWidth="xl">
            <CreatePersonnel v-if="actionType === 'create'" :offices="props.offices" @close-modal="isModalOpen = false" />
            <EditPersonnel v-else-if="actionType === 'edit'" :personnel="selectedPersonnelForEdit" :offices="props.offices" @close-modal="isModalOpen = false" />
            <DeletePersonnel v-else-if="actionType === 'delete'" :personnel="selectedPersonnelForDelete" @close-modal="isModalOpen = false" />
        </Modal>
    </AuthenticatedLayout>
</template>
