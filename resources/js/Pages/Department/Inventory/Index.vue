<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import TableRow from './components/TableRow.vue';
import Modal from '@/Components/Modal.vue';
import Alert from '@/Components/Alert.vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { ArrowUturnLeftIcon, MagnifyingGlassIcon, PlusIcon } from '@heroicons/vue/24/solid';
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline';
import { ref, computed } from 'vue';

const props = defineProps({
    properties: Array,
    department: Object,
    departments: Array,
})

// Create property section
const addForm = useForm({
    name: null,
    description: null,
    date_acquired: null,
})

const submit = () => {
    addForm.post('/departments/' + props.department.id + '/inventory', {
        onSuccess: () => closeCreateModal()
    })
}

const showCreateModal = ref(false);

const addNewProperty = () => {
    showCreateModal.value = true;
}

const closeCreateModal = () => {
    showCreateModal.value = false;

    addForm.reset();
}

// Editing property section
const editForm = useForm({
    name: null,
    description: null,
    date_acquired: null,
})

const showEditModal = ref(false);
const selectedPropertyId = ref(null);

const formatDate = (date) => {
    const dateObject = new Date(date);

    // Extract the month, day, and year
    const month = dateObject.getMonth() + 1; // Months are zero-based
    const day = dateObject.getDate();
    const year = dateObject.getFullYear();

    // Format the components as two-digit numbers
    const formattedMonth = month < 10 ? '0' + month : month;
    const formattedDay = day < 10 ? '0' + day : day;

    return `${year}-${formattedMonth}-${formattedDay}`;
}

const editProperty = (property) => {
    showEditModal.value = true;

    selectedPropertyId.value = property.id;
    editForm.name = property.name;
    editForm.date_acquired = formatDate(property.date_acquired);
    editForm.description = property.description;
}

const closeEditModal = () => {
    showEditModal.value = false;

    editForm.reset();
}

const updatePropertyDetails = () => {
    editForm.patch('/departments/' + props.department.id + '/inventory/' + selectedPropertyId.value, {
        onSuccess: () => {
            closeEditModal();
            selectedPropertyId.value = null;
        }
    })
}

// Delete Property Section
const showDeleteModal = ref(false)
const selectedPropToDelete = ref(null)

const deleteProperty = (property) => {
    showDeleteModal.value = true;

    selectedPropToDelete.value = property;
}

const confirmDeleteProperty = () => {
    router.delete('/departments/' + props.department.id + '/inventory/' + selectedPropToDelete.value.id, {
        onSuccess: () => closeDeleteModal()
    })
}

const closeDeleteModal = () => {
    showDeleteModal.value = false;
}
</script>

<template>
    <Head title="Edit Inventory" />

    <AuthenticatedLayout>
        <div>
            <div class="w-full sm:px-6 lg:px-8">

                <Link :href="'/departments/' + department.id + '/inventory/view'" class="inline-flex items-center px-3 py-1.5 mb-6 border border-[#4e73df] bg-white hover:bg-gray-50 text-[#4e73df] text-sm rounded-md shadow">
                    <ArrowUturnLeftIcon class="w-4 h-4 mr-1" />
                    Back</Link>


                <div class="block md:flex md:items-center md:justify-between mb-4">
                    <div>
                        <h1 class="text-2xl text-gray-700 font-semibold leading-none">Edit {{ department.name }} Inventory</h1>
                        <p class="text-normal font-medium text-gray-600">Department Head - {{ department.head }}</p>
                    </div>

                    <PrimaryButton type="button" @click="addNewProperty">
                        <PlusIcon class="w-4 h-4 mr-1 stroke-white" />
                        Add New
                    </PrimaryButton>
                </div>

                <Alert class="mb-4" />

                <hr class="mt-3 mb-3">

                <!-- <div class="flex items-center justify-between mb-4">
                    <div class="relative">
                        <MagnifyingGlassIcon class="absolute left-2 top-2 w-5 h-5 text-gray-400" />
                        <input 
                            v-model="search"
                            type="text" 
                            id="table-search-users" 
                            class="block p-2 pl-10 text-sm text-gray-900 bg-white shadow-sm border border-gray-300 rounded-lg w-80 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Search for properties">
                    </div>
                </div>
                 -->
                <div class="bg-white shadow rounded-lg overflow-x-visible">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <th scope="col" class="w-32 px-6 py-3">
                                Tag No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Item
                            </th>
                            <th scope="col" class="px-6 py-3">
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
                        <tbody class="divide-y">
                            <TableRow 
                                v-for="(item, index) in properties" 
                                :key="index" 
                                :property="item" 
                                :department="department" 
                                @edit="editProperty" 
                                @delete="deleteProperty"
                            />
                            <tr v-if="properties.length == 0">
                                <td colspan="6"  class="px-6 py-3 text-center">No Records Found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <Modal :show="showCreateModal" @close="closeCreateModal">
            <div class="p-6">
                <h4 class="text-lg text-gray-700 font-semibold">Add New Property</h4>
                <hr class="mb-2">
                <div class="py-2">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label for="item_name" class="block font-medium text-sm text-gray-700">Property name</label>
                            <input v-model="addForm.name" type="text" id="item_name" 
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                            :class="{'border-red-600' : addForm.errors.name}">
                            <InputError :message="addForm.errors.name" />
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block font-medium text-sm text-gray-700">Acquisition Date</label>
                            <input v-model="addForm.date_acquired" type="date" id="date_acquired" :class="{'border-red-600' : addForm.errors.date_acquired}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            <InputError :message="addForm.errors.date_acquired" />
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea v-model="addForm.description" name="description" id="description" :class="{'border-red-600' : addForm.errors.description}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" placeholder="(Optional)"></textarea>
                            <InputError :message="addForm.errors.description" />
                        </div>
                        <div class="flex justify-end items-center space-x-2">
                            <button type="button" class="inline-flex items-center px-3 py-1.5 border border-[#4e73df] bg-white hover:bg-gray-50 text-[#4e73df] text-sm rounded-md shadow" @click="closeCreateModal">Cancel</button>
                            <button type="submit" class="px-3 py-1.5 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" :disabled="addForm.processing">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>

        <Modal :show="showEditModal" @close="closeEditModal">
            <div class="p-6">
                <h4 class="text-lg text-gray-700 font-semibold">Edit Property</h4>
                <hr class="mb-2">
                <div class="py-2">
                    <form @submit.prevent="updatePropertyDetails">
                        <div class="mb-4">
                            <label for="item_name" class="block font-medium text-sm text-gray-700">Property name</label>
                            <input v-model="editForm.name" type="text" id="item_name" 
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                            :class="{'border-red-600' : editForm.errors.name}">
                            <InputError :message="editForm.errors.name" />
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block font-medium text-sm text-gray-700">Acquisition Date</label>
                            <input v-model="editForm.date_acquired" type="date" id="date_acquired" :class="{'border-red-600' : editForm.errors.date_acquired}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            <InputError :message="editForm.errors.date_acquired" />
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea v-model="editForm.description" name="description" id="description" :class="{'border-red-600' : editForm.errors.description}" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" placeholder="(Optional)"></textarea>
                            <InputError :message="editForm.errors.description" />
                        </div>
                        <div class="flex justify-end items-center space-x-2">
                            <button type="button" class="inline-flex items-center px-3 py-1.5 border border-[#4e73df] bg-white hover:bg-gray-50 text-[#4e73df] text-sm rounded-md shadow" @click="closeEditModal">Cancel</button>
                            <button type="submit" class="px-3 py-1.5 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" :disabled="editForm.processing">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>

        <Modal :show="showDeleteModal" @close="closeDeleteModal">
            <div class="p-6">

                <div class="flex space-x-2">
                    <div class="shrink-0">
                        <ExclamationTriangleIcon class="w-5 h-5 mt-1" />
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-medium text-gray-900">
                            Delete Confirmation
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Are you sure you want to delete "{{ selectedPropToDelete.name }}" from inventory?
                        </p>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <button type="button" @click="closeDeleteModal"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-sm text-gray-700 
                    shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    > Cancel </button>

                    <button
                        type="button"
                        class="ml-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        @click="confirmDeleteProperty"
                    >
                        Delete
                    </button>
                </div>
            </div>  
        </Modal>
    </AuthenticatedLayout>
</template>