<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted} from 'vue';

const props = defineProps({
    property: Object,
})

const venues = ref([]);
const isLoaded = ref(false);

onMounted(() => {
    axios.get('http://127.0.0.1:8000/api/venues')
        .then((response) => {
            venues.value = response.data;
            isLoaded.value = true;
        }).catch((error) => {
            console.log(error)
        })
})

const form = useForm({
    venue_id: props.property.venue_id,
    name: props.property.name,
    brand: props.property.brand,
    description: props.property.description,
    tag_no: props.property.tag_no,
    date_acquired: props.property.date_acquired,
    status: props.property.status,
});

const emits = defineEmits('close-modal')

const submit = () => {
    form.patch('/properties/update-details/' + props.property.id, {
        onSuccess: () => {
            form.reset();
            emits('close-modal');
        }
    });
}
</script>

<template>
    <div v-if="!isLoaded" class="w-full p-6 animate-pulse">
        <div class="h-6 w-[120px] bg-gray-300 rounded-full mb-4"></div>

        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>

        <div class="flex justify-end items-center">
            <div class="h-7 w-[120px] bg-gray-200 rounded-full"></div>
            <div class="h-7 w-[120px] bg-gray-300 rounded-full ml-3"></div>
        </div>
    </div>

    <div v-else class="w-full p-6 bg-white rounded-lg">
        <h4 class="text-xl font-semibold text-gray-700">Edit Propert Details</h4>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <InputLabel for="name" value="Name" />
                <TextInput type="text" v-model="form.name" id="name" class="w-full text-sm" />
                <InputError :message="form.errors.name" />
            </div>
            <div class="mb-4">
                <InputLabel for="brand" value="Brand" />
                <TextInput type="text" v-model="form.brand" id="brand" class="w-full text-sm" />
                <InputError :message="form.errors.brand" />
            </div>
            <div class="mb-4">
                <InputLabel for="description" value="Description (More Details)" />
                <textarea v-model="form.description" id="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-sm" placeholder="Optional"></textarea>
                <!-- <TextInput type="text" v-model="form.description" id="description" class="w-full text-sm" /> -->
                <InputError :message="form.errors.description" />
            </div>
            <div class="mb-4">
                <InputLabel for="date_acquired" value="Acquisition Date" />
                <TextInput type="date" v-model="form.date_acquired" id="date_acquired" class="w-full text-sm" />
                <InputError :message="form.errors.date_acquired" />
            </div>
            <div class="mb-4">
                <InputLabel for="tag_no" value="Tag Number" />
                <TextInput type="number" v-model="form.tag_no" id="tag_no" class="w-full text-sm" />
                <InputError :message="form.errors.tag_no" />
            </div>
            <div class="mb-4">
                <InputLabel for="status" value="Status" />
                <!-- <TextInput v-model="form.status" id="status" class="w-full text-sm" /> -->
                <select v-model="form.status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-sm">
                    <option value="Good">Good</option>
                    <option value="Damaged">Damaged</option>
                    <option value="Lost">Lost</option>
                    <option value="Repaired">Repaired</option>
                </select>
                <InputError :message="form.errors.status" />
            </div>
            <div class="mb-4">
                <InputLabel for="venue" value="Placement" />
                <select v-model="form.venue_id" id="venue" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-sm">
                    <option value="null">Select venue</option>
                    <option v-for="venue in venues" :key="venue.id" :value="venue.id">{{ venue.venue_name }} - {{ venue.building }}</option>
                </select>
                <InputError :message="form.errors.venue_id" />
            </div>

            <div class="flex items-center justify-end space-x-2">
                <button type="button" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium" @click="emits('close-modal')">Cancel</button>
                <button type="submit" class="px-4 py-2 text-sm rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white ml-2" :class="{ 'bg-[#4e72dfc0]' : form.processing }" :disabled="form.processing">
                    <span v-if="form.processing" class="inilne-flex items-center">
                        <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        Saving...
                    </span>
    
                    <span v-if="!form.processing">Submit</span>
                </button>
            </div>
        </form>
    </div>
</template>