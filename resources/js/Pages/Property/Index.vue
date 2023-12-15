<script setup>
import Paginator from '@/Components/Paginator.vue';
import Alert from '@/Components/Alert.vue';
import Modal from '@/Components/Modal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateProperty from './Actions/CreateProperty.vue';
import DeleteProperty from './Actions/DeleteProperty.vue';
import EditProperty from './Actions/EditProperty.vue';
import { PlusCircleIcon, MagnifyingGlassIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps ({
    properties: Object
})

const search = ref('');

watch(search, (newSearchVal) => {
    let params = {
        search: newSearchVal,
    };

    if(params.search == '') {
        delete params.search;
    }

    router.get('/properties', params, { preserveState: true, replace: true });
})

const actionType = ref('');

const isModalOpen = ref(false);

const createProperty = () => {
    actionType.value = 'create';
    isModalOpen.value = true;
}

const selectedPropertForEdit = ref({});

const editProperty = (property) => {
    selectedPropertForEdit.value = property;
    actionType.value = 'edit';
    isModalOpen.value = true;
}

const selectedPropertyForDelete = ref({});

const deleteProperty = (property) => {
    selectedPropertyForDelete.value = property;
    actionType.value = 'delete';
    isModalOpen.value = true;
}

const closeModal = () => {
    isModalOpen.value = false;
    actionType.value = '';
}

</script>

<template>
    <Head title="Properties" />

    <AuthenticatedLayout>
        <div class="sm:p-4 xl:p-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight">Properties</h1>
                <button type="button" @click="createProperty" class="flex items-center px-3 py-2 rounded-lg bg-[#4e73df] hover:bg-[#4e72dfc0] text-white font-medium">
                    <PlusCircleIcon class="w-4 h-4" />
                    <span class="text-sm ml-1">Add Existing</span>
                </button>
            </div>

            <Alert class="mb-4" />

            <div class="overflow-x-auto rounded-lg bg-white shadow sm:py-4 2xl:py-6">

                <div class="px-4 mb-4">
                    <label for="table-search-users" class="relative">
                        <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                        <input 
                            v-model="search"
                            type="search" 
                            id="table-search-users" 
                            class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-md w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Search for properties">
                    </label>
                </div>

                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Tag No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Property
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Brand
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Location
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Acquisition Date
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
                        <tr class="bg-white border-b border-t" v-for="(property, index) in properties.data" :key="index">
                            <td class="px-6 py-3 text-gray-900 whitespace-nowrap">
                                {{ property.tag_no }}
                            </td>
                            <td class="px-6 py-3">
                                {{ property.name }}
                            </td>
                            <td class="px-6 py-3">
                                {{ property.brand }}
                            </td>
                            <td class="px-6 py-3">
                                {{ property.description }}
                            </td>
                            <td class="px-6 py-3    ">
                                {{ property.venue.venue_name }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ new Date(property.date_acquired).toDateString() }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ property.status }}
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-center space-x-2">
                                    <button @click="editProperty(property)" type="button"
                                        class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                        <PencilIcon class="w-4 h-4" />
                                    </button>
                                    <button @click="deleteProperty(property)" type="button" class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                            <TrashIcon class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-show="props.properties.total < 1" class="bg-white border-b border-t">
                            <td colspan="8" class="px-6 py-3 text-center">No records found.</td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-center items-center mt-5 relative">
                    <Paginator
                    :links="props.properties.links"
                    :first_page_url="props.properties.first_page_url"
                    :last_page_url="props.properties.last_page_url"
                    :prev_page_url="props.properties.prev_page_url"
                    :next_page_url="props.properties.next_page_url"
                    />

                    <!-- <button @click="clearAllFilters" class="absolute right-8 w-10 h-10 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 flex justify-center items-center">
                        <ArrowPathIcon class="w-5 h-5" />
                    </button> -->
                </div>
            </div>
        </div>

        <Modal :show="isModalOpen" @close="closeModal" maxWidth="xl">
            <CreateProperty v-if="actionType === 'create'" @close-modal="closeModal" />
            <EditProperty v-else-if="actionType === 'edit'" :property="selectedPropertForEdit" @close-modal="closeModal" />
            <DeleteProperty v-else-if="actionType === 'delete'" :property="selectedPropertyForDelete" @close-modal="closeModal" />
        </Modal>
    </AuthenticatedLayout>
</template>