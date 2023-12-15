<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Paginator from '@/Components/Paginator.vue';
import Alert from '@/Components/Alert.vue';
import Modal from '@/Components/Modal.vue';
import EditUnit from './EditUnit.vue';
import DeleteUnit from './DeleteUnit.vue';
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    units: Object,
})

const form = useForm({
    unit_name: '',
    abbreviation: '',
});

const submitForm = () => {
    form.post('/units/add-new-unit', {
        onSuccess: () => form.reset()
    })
}

const isModalOpen = ref(false);
const actionType = ref('');

const selectedUnitForEdit = ref({})

const editUnit = (unit) => {
    isModalOpen.value = true;
    actionType.value = 'edit';
    selectedUnitForEdit.value = unit;
}

const selectedUnitForDelete = ref({});

const deleteUnit = (unit) => {
    isModalOpen.value = true;
    actionType.value = 'delete';
    selectedUnitForDelete.value = unit;
}
</script>
<template>
    <Head title="Units" />
    
    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight">Quantity Units</h1>
                <p class="text-base text-gray-600"></p>

                <Alert class="mt-4" />

                <div class="mt-6 flex items-start space-x-4">
                    <div class="w-full max-w-sm bg-white rounded-lg shadow p-4 lg:p-6">
                        <h4 class="text-md font-semibold text-gray-600">Add New Unit</h4>

                        <form @submit.prevent="submitForm">
                            <div class="mt-3 mb-4">
                                <InputLabel for="unit_name" value="Unit name" />
                                <TextInput v-model="form.unit_name" id="unit_name" class="w-full text-sm" :class="{ 'border-red-600' : form.errors.unit_name }" placeholder="Plural form ex. 'Pieces'" />
                                <InputError :message="form.errors.unit_name" />
                            </div>

                            <div class="mt-3 mb-4">
                                <InputLabel for="abbreviation" value="Abbreviation" />
                                <TextInput v-model="form.abbreviation" id="abbreviation" class="w-full text-sm" :class="{ 'border-red-600' : form.errors.abbreviation }" placeholder="ex. Pcs" />
                                <InputError :message="form.errors.abbreviation" />
                            </div>
    
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white" :disabled="form.processing">
                                    <span v-if="form.processing" class="inline-flex items-center">
                                        <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-blue-600 me-2" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                        Submitting..
                                    </span>
                    
                                    <span v-if="!form.processing">Submit</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="flex-1 min-w-[768x] bg-white rounded-lg shadow p-4 lg:p-6">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Unit
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Abbreviation
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Created On
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Action
                                </th>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-t" v-for="unit in props.units.data" :key="unit.id">
                                    <td class="px-6 py-3">
                                        {{ unit.id }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ unit.unit_name }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ unit.abbreviation }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ new Date(unit.created_at).toLocaleString() }}
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button type="button" class="w-8 h-8 hover:bg-gray-100 rounded-full flex justify-center items-center" @click="editUnit(unit)">
                                                <PencilIcon class="w-4 h-4" />
                                            </button>
                                            <button type="button" class="w-8 h-8 hover:bg-gray-100 rounded-full flex justify-center items-center" @click="deleteUnit(unit)">
                                                <TrashIcon class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="props.units.total < 1" class="bg-white border-b border-t">
                                    <td colspan="5" class="px-6 py-4 text-center">No records found.</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="flex justify-center items-center mt-5">
                            <Paginator
                            v-show="props.units.total > 0"
                            :links="props.units.links" 
                            :prev_page_url="props.units.prev_page_url"
                            :next_page_url="props.units.next_page_url"
                            :first_page_url="props.units.first_page_url"
                            :last_page_url="props.units.last_page_url"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="isModalOpen" maxWidth="xl" @close="isModalOpen = false;">
            <EditUnit v-if="actionType === 'edit'" :unit="selectedUnitForEdit" @close-modal="isModalOpen = false;" />

            <DeleteUnit v-else-if="actionType === 'delete'" :unit="selectedUnitForDelete" @close-modal="isModalOpen = false;" />
        </Modal>
    </AuthenticatedLayout>
</template>