<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import TableRow from './components/TableRow.vue';
import Modal from '@/Components/Modal.vue';
import Paginator from '@/Components/Paginator.vue';
import Alert from '@/Components/Alert.vue';
import PaginationWithPerPage from '@/Components/PaginationWithPerPage.vue';
// import TabWrapper from '@/Components/TabWrapper.vue';
// import Tab from '@/Components/Tab.vue';
import CreateProperty from './CreateProperty.vue';
import EditProperty from './EditProp.vue';
import DeleteProperty from './DeleteProp.vue';
import UpdatePropertyStatus from './PropertyStatusUpdate.vue';
import debounce from 'lodash/debounce';
import { ArrowUturnLeftIcon, MagnifyingGlassIcon, PlusIcon, Square3Stack3DIcon, ClipboardDocumentListIcon, ArrowPathIcon } from '@heroicons/vue/24/solid';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';


const props = defineProps({
    transactions: Array,
    properties: Object,
    office: Object,
    filters: Object,
})

// const field = computed(() => {
//     return (props.filters?.field || '')
// })

const query = ref({
    search: props.filters.search,
    perPage: props.filters.perPage,
    field: props.filters.field,
    direction: props.filters.direction,
    status: props.filters.status
})

watch(() => query, debounce(() => {

    let newQuery = query.value;

    Object.keys(newQuery).forEach(key => {
        if(newQuery[key] === undefined || newQuery[key] === null || newQuery[key] === '' || newQuery[key] === 'undefined' ) {
            delete newQuery[key];
        }
    });

    router.get('/admin/offices/' + props.office.id + '/inventory', newQuery, {
        preserveState: true,
        replace: true,
    })
}, 300), {
    deep: true,
})

const selectedComponent = ref('');

const showModal = ref(false);

const closeModal = () => {
    showModal.value = false;
}

const addProperty = (type) => {
    showModal.value = true;
    selectedComponent.value = type;
}

const selectedPropIdToEdit = ref(null);


const editProp = (property, type) => {
    showModal.value = true;

    selectedPropIdToEdit.value = property;
    selectedComponent.value = type;
}

const selectedPropToDelete = ref({})

const deleteProp = (property, type) => {
    showModal.value = true;

    selectedPropToDelete.value = property;
    selectedComponent.value = type;
}

const crumbs = [{
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Offices',
        url: '/admin/offices',
        active: false,
    },
    {
        name: props.office.name,
        url: null,
        active: true,
    },
];

const updatePropertyStatus = (status, propertyId) => {
    router.patch('/admin/offices/' + props.office.id + '/inventory/' + propertyId + '/status-update', {
        status: status
    });
}

const selectedPropToStatusUpdate = ref(false);

const updateStatusDialog = (property, type) => {
    showModal.value = true;
    selectedPropToStatusUpdate.value = property;
    selectedComponent.value = type;
}

const resetOrder = () => {
    query.value.direction = undefined;
}

const updatePerPage = (newPerPage) => {
    query.value.perPage = newPerPage;
}

const clearAllFilters = () => {
    query.value = {};
} 
</script>

<template>
    <Head :title="office.name" />

    <AuthenticatedLayout>
        <div>
            <div class="w-full sm:px-6 lg:px-8 py-6">

                <Breadcrumb :crumbs="crumbs" class="mb-4" />

                <div>
                    <h1 class="text-2xl text-gray-700 font-semibold leading-none">{{ office.name }}</h1>
                    <p class="text-normal font-medium text-gray-600">[Office Head] {{ office.head }}</p>
                </div>

                <TabGroup>
                    <TabList class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b mb-4">
                      <!-- Use the `selected` state to conditionally style the selected tab. -->
                      <Tab class="me-2">
                        <button
                        class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg 
                        ui-selected:border-blue-600 ui-selected:text-blue-600 ui-not-selected:hover:text-gray-600 ui-not-selected:hover:border-gray-300"
                        >
                        <Square3Stack3DIcon class="w-4 h-4 mr-2" />
                          Inventory
                        </button>
                      </Tab>
                      <Tab class="me-2">
                        <button
                        class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg 
                        ui-selected:border-blue-600 ui-selected:text-blue-600 ui-not-selected:hover:text-gray-600 ui-not-selected:hover:border-gray-300"
                        >
                        <ClipboardDocumentListIcon class="w-4 h-4 mr-2" />
                          Item Transactions
                        </button>
                      </Tab>
                    </TabList>
                    <TabPanels>
                      <TabPanel>
                        <!-- <div class="block md:flex md:items-end md:justify-between mb-4">
                            <h1 class="text-xl font-semibold text-gray-600">Properties</h1>
        
                            <PrimaryButton type="button" @click="addProperty('create')">
                                <PlusIcon class="w-4 h-4 mr-1 stroke-white" />
                                Add New
                            </PrimaryButton>
                        </div> -->
        
                        <Alert class="mb-4" />
        
                        <div class="flex items-center justify-between mb-4 p-4 bg-white shadow rounded-md overflow-x-auto">
                            <div class="relative">
                                <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                                <input 
                                    v-model="query.search"
                                    type="search" 
                                    id="table-search-users" 
                                    class="block p-2 pl-10 text-sm text-gray-900 bg-white shadow-sm border border-gray-300 rounded-md w-80 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    placeholder="Search through name, or tag number">
                            </div>
        
                            <div class="flex space-x-5">
                                <div class="flex items-center space-x-2">
        
                                    <span class="text-sm text-gray-600 font-medium">Filter by</span>
        
                                    <select v-model="query.field" id="field" class="text-sm text-gray-600 bg-white border border-gray-300 rounded-md" @change="resetOrder">
                                        <option value="undefined">Select Field</option>
                                        <option value="tag_no">Tag Number</option>
                                        <option value="name">Name</option>
                                        <option value="date_acquired">Acquisition Date</option>
                                    </select>
        
                                    <select v-model="query.direction" id="direction" class="text-sm text-gray-600 bg-white border border-gray-300 rounded-md" :disabled="!query.field">
                                        <option value="undefined">Select Order</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
        
                                <div class="flex items-center">
                                    <label for="status" class="text-sm text-gray-600 font-medium mr-3">Status</label>
                                    <select v-model="query.status" id="status" class="text-sm text-gray-600 bg-white border border-gray-300 rounded-md">
                                        <option value="undefined">All</option>
                                        <option value="Good">Good</option>
                                        <option value="Repaired">Repaired</option>
                                        <option value="Damaged">Damaged</option>
                                        <option value="Lost">Lost</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white shadow rounded-lg p-6">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                    <th scope="col" class="w-32 px-6 py-3">
                                        Tag No.
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Item
                                    </th>
                                    <th scope="col" class="px-6 py-3 hidden xl:block w-56">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Acquisition Date
                                    </th>
                                    <th scope="col" class="w-44 px-6 py-3 text-center">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Action
                                    </th>
                                </thead>
                                <tbody>
                                    <TableRow 
                                        v-for="(item, index) in properties.data" 
                                        :key="index" 
                                        :property="item" 
                                        :office="office" 
                                        @edit="editProp" 
                                        @delete="deleteProp"
                                        @update-status="updateStatusDialog"
                                        />
                                    <tr v-if="properties.data.length < 1">
                                        <td colspan="6"  class="px-6 py-3 text-center">No Records Found</td>
                                    </tr>
                                </tbody>
                            </table>
        
                            <div class="flex justify-center mt-6 relative">
                                <PaginationWithPerPage 
                                :data="props.properties"
                                :perPage="query.perPage"
                                @update-per-page="updatePerPage"
                                />

                                <button @click="clearAllFilters" class="absolute right-8 w-10 h-10 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 flex justify-center items-center">
                                    <ArrowPathIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                      </TabPanel>
                      <TabPanel>
                        Content 2
                      </TabPanel>
                    </TabPanels>
                  </TabGroup>
                
            </div>
        </div>

        <Modal :show="showModal" @close="closeModal">
            <CreateProperty v-if="selectedComponent === 'create'" :office="office" @close-modal="closeModal" />
            <EditProperty v-else-if="selectedComponent === 'edit'" :office="office" :propertyId="selectedPropIdToEdit" @close-modal="closeModal" />
            <DeleteProperty v-else-if="selectedComponent === 'delete'" :officeId="props.office.id" :property="selectedPropToDelete" @close-modal="closeModal" />
            <UpdatePropertyStatus v-else :officeId="props.office.id" :property="selectedPropToStatusUpdate" @close-modal="closeModal" />
        </Modal>

    </AuthenticatedLayout>
</template>