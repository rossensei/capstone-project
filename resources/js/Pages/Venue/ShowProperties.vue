<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import Alert from '@/Components/Alert.vue';
import MoveProperty from './Actions/MoveProperty.vue';
import UpdatePropertyStatus from './Actions/UpdatePropertyStatus.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { Head } from '@inertiajs/vue3';
import { ArrowRightCircleIcon, MagnifyingGlassIcon, ArrowPathIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

const props = defineProps({
    venue: Object,
    properties: Array
});

const crumbs = [{
        name: 'Dashboard',
        url: '/dashboard',
        active: false,
    },
    {
        name: 'Venues',
        url: '/venues',
        active: false,
    },
    {
        name: props.venue.venue_name,
        url: null,
        active: true,
    },
];

// move property

const isModalOpen = ref(false);

const closeModal = () => {
    selectedPropertyToMove.value = {};
    isModalOpen.value = false;
}

const actionType = ref('');

const selectedPropertyToMove = ref({})

const moveProperty = (property) => {
    actionType.value = 'move-property';
    isModalOpen.value = true;
    selectedPropertyToMove.value = property;
}

const selectedPropertyForStatusUpdate = ref({})

const updatePropertyStatus = (property) => {
    actionType.value = 'update-status';
    isModalOpen.value = true;
    selectedPropertyForStatusUpdate.value = property;
}

</script>

<template>
    <Head :title="props.venue.venue_name" />
    
    <AuthenticatedLayout>
        <div class="sm:p-4 xl:p-6">
            <Breadcrumb :crumbs="crumbs" class="mb-4" />

            <div>
                <h1 class="text-2xl text-gray-700 font-semibold leading-none">{{ venue.venue_name }}</h1>
                <p class="text-normal font-medium text-gray-600">[Asset Manager] {{ venue.user.name }}</p>
            </div>

            <Alert class="mb-4" />

            <div class="overflow-x-auto rounded-lg bg-white shadow sm:py-4 2xl:py-6">

                <div class="px-4 mb-4">
                    <label for="table-search-users" class="relative">
                        <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                        <input 
                            type="search" 
                            id="table-search-users" 
                            class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-md w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Search for users">
                    </label>
                </div>

                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Tag No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Property
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Brand
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Description
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
                        <tr class="bg-white border-b border-t" v-for="(property, index) in properties" :key="index">
                            <td class="px-6 py-3 text-gray-900 whitespace-nowrap">
                                {{ property.tag_no }}
                            </td>
                            <td class="px-6 py-3    ">
                                {{ property.name }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ property.brand }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ property.description }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ new Date(property.date_acquired).toDateString() }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ property.status }}
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-center space-x-2">
                                    <button @click="moveProperty(property)" type="button"
                                        class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                        <ArrowRightCircleIcon class="w-4 h-4" />
                                    </button>
                                    <button @click="updatePropertyStatus(property)" type="button"
                                        class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                        <ArrowPathIcon class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-show="props.properties.length < 1" class="bg-white border-b border-t">
                            <td colspan="7" class="px-6 py-3 text-center">No records found.</td>
                        </tr>
                    </tbody>
                </table>

                <!-- <div class="flex justify-center items-center mt-5 relative">
                    <Paginator
                    :links="props.venues.links"
                    :first_page_url="props.venues.first_page_url"
                    :last_page_url="props.venues.last_page_url"
                    :prev_page_url="props.venues.prev_page_url"
                    :next_page_url="props.venues.next_page_url"
                    />
                </div> -->
            </div>
        </div>

        <Modal :show="isModalOpen" @close="closeModal" maxWidth="xl">
            <MoveProperty v-if="actionType === 'move-property'" :venue="props.venue" :property="selectedPropertyToMove" @close-modal="closeModal" />
            <UpdatePropertyStatus v-else-if="actionType === 'update-status'" :venue="props.venue" :property="selectedPropertyForStatusUpdate" @close-modal="closeModal" />
        </Modal>
    </AuthenticatedLayout>
</template>