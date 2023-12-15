<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import Alert from '@/Components/Alert.vue';
import Paginator from '@/Components/Paginator.vue';
import CreateVenue from './Actions/CreateVenue.vue';
import EditVenue from './Actions/EditVenue.vue';
import DeleteVenue from './Actions/DeleteVenue.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { PencilIcon, TrashIcon, PlusCircleIcon, MagnifyingGlassIcon, EyeIcon } from '@heroicons/vue/24/outline';
import debounce from 'lodash/debounce';
import { watch, ref } from 'vue';

const props = defineProps({
    venues: Object,
    filters: Object,
});


const search = ref(props.filters.search);

watch(search, debounce(function(newValue) {

    let params = {
        search: newValue,
    }

    if(params.search == '') {
        delete params.search;
    }

    router.get('/venues', params, { preserveState: true, replace: true });
}, 300))

const isModalOpen = ref(false);

const actionType = ref('');

const createVenue = () => {
    isModalOpen.value = true;
    actionType.value = 'create';
}

const selectedVenueForEdit = ref(null)

const editVenue = (venueId) => {
    selectedVenueForEdit.value = venueId;
    isModalOpen.value = true;
    actionType.value = 'edit';
}

const selectedVenueForDelete = ref({})

const deleteVenue = (venue) => {
    selectedVenueForDelete.value = venue;
    isModalOpen.value = true;
    actionType.value = 'delete';
}
</script>

<template>
    <Head title="Venues" />

    <AuthenticatedLayout>
        <div class="sm:p-4 xl:p-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight">Venues</h1>
                <button type="button" @click="createVenue" class="flex items-center px-3 py-2 rounded-lg bg-[#4e73df] hover:bg-[#4e72dfc0] text-white font-medium">
                    <PlusCircleIcon class="w-4 h-4" />
                    <span class="text-sm ml-1">New Venue</span>
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
                            placeholder="Search for venues">
                    </label>
                </div>

                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Venue
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Building
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Asset Manager
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b border-t" v-for="(venue, index) in venues.data" :key="index">
                            <td class="px-6 py-3 text-gray-900 whitespace-nowrap">
                                {{ venue.venue_name }}
                            </td>
                            <td class="px-6 py-3    ">
                                {{ venue.building }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ venue.user.name }}
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-center space-x-2">
                                    <Link
                                    :href="'/venues/show-properties/' + venue.id"
                                    class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600"
                                    >
                                    <EyeIcon class="w-4 h-4" />
                                    </Link>

                                    <button @click="editVenue(venue.id)" type="button"
                                        class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                        <PencilIcon class="w-4 h-4" />
                                    </button>
                                    <button @click="deleteVenue(venue)" type="button" class="w-8 h-8 flex justify-center items-center rounded-full bg-white hover:bg-gray-100 text-gray-600">
                                            <TrashIcon class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-show="props.venues.total < 1" class="bg-white border-b border-t">
                            <td colspan="6" class="px-6 py-3 text-center">No records found.</td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-center items-center mt-5 relative">
                    <Paginator
                    :links="props.venues.links"
                    :first_page_url="props.venues.first_page_url"
                    :last_page_url="props.venues.last_page_url"
                    :prev_page_url="props.venues.prev_page_url"
                    :next_page_url="props.venues.next_page_url"
                    />

                    <!-- <button @click="clearAllFilters" class="absolute right-8 w-10 h-10 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-600 flex justify-center items-center">
                        <ArrowPathIcon class="w-5 h-5" />
                    </button> -->
                </div>
            </div>
        </div>

        <Modal :show="isModalOpen" @close="isModalOpen = false" maxWidth="xl">
            <CreateVenue v-if="actionType === 'create'" @close-modal="isModalOpen = false" />
            <EditVenue v-else-if="actionType === 'edit'" :venueId="selectedVenueForEdit" @close-modal="isModalOpen = false" />
            <DeleteVenue v-else-if="actionType === 'delete'" :venue="selectedVenueForDelete" @close-modal="isModalOpen = false" />
        </Modal>
    </AuthenticatedLayout>
</template>