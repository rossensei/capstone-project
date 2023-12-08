<script setup>
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { EllipsisHorizontalIcon, PencilIcon, TrashIcon, Cog6ToothIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    property: Object,
    office: Object
})

const emit = defineEmits([
    'edit',
    'delete',
    'update-status'
])

const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
}

const handleEdit = () => {
    emit('edit', props.property.id, 'edit')
}

const form = useForm({
    status: props.property.status
});

// const showStatusDropdown = ref(false);

// const openStatusDropdown = () => {
//     showStatusDropdown.value = true;
// }

const handleStatusUpdate = () => {
    emit('update-status', props.property, 'update-status')
}


const handleDelete = () => {
    emit('delete', props.property, 'delete');
    toggleDropdown();
}
</script>

<template>
    <tr class="bg-white border-t border-b">
        <td class="px-4 py-3">
            {{ property.tag_no }}
        </td>
        <td class="px-4 py-3">
            <span class="text-gray-700 font-medium">
                {{ property.name }}
            </span>
        </td>
        <td class="px-4 py-3 truncate hidden xl:block">
                {{ property.description }}
        </td>
        <td class="px-4 py-3 text-center truncate">
                {{ property.date_acquired }}
        </td>
        <td class="px-4 py-3 text-center">
            <!-- <select v-model="form.status" :id="'update-status-' + props.property.id" class="block py-1.5 px-2 w-full text-sm text-gray-900 bg-white shadow-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" @change="handleStatusUpdate">
                <option value="Good">Good</option>
                <option value="Damaged">Damaged</option>
                <option value="Repaired">Repaired</option>
                <option value="Lost">Lost</option>
            </select> -->

            <span class="px-3 py-1 text-xs font-medium uppercase tracking-wide rounded-full"
            :class="{
                'bg-green-100 text-green-600' : property.status === 'Good',
                'bg-yellow-100 text-yellow-600' : property.status === 'Repaired',
                'bg-red-100 text-red-600' : property.status === 'Damaged',
                'bg-gray-100 text-gray-600' : property.status === 'Lost',
            }"
            
            >{{ property.status }}</span>
        </td>
        <td class="px-4 py-3 text-center">

            <div class="relative">
                <button @click="toggleDropdown" type="button" class="h-6 w-6 rounded-full hover:bg-gray-100 inline-flex justify-center items-center"><EllipsisHorizontalIcon class="w-5 h-5" /></button>

                <div v-show="isDropdownOpen" class="fixed inset-0 z-10" @click="isDropdownOpen = false"></div>
                <!-- <button @click="toggleDropdown" id="dropdownDefaultButton" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Dropdown button</button> -->
                
                <transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
                >
                    <!-- Dropdown menu -->
                    <div v-show="isDropdownOpen" id="dropdown" class="z-10 w-36 absolute bg-white divide-y divide-gray-100 rounded-lg shadow-md border -translate-x-[30px]">
                        
                        <div class="relative">
                            <ul class="py-2 text-sm text-gray-700 text-left">
                                <li>
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100" @click="handleStatusUpdate" ><Cog6ToothIcon class="w-4 h-4 mr-1" /> Edit Status</a>

                                    <!-- <div v-show="showStatusDropdown" class="absolute top-0 -left-[150px] bg-white shadow border">
                                        <ul class="py-2 text-sm text-gray-700 text-left">
                                            <li>
                                                <input v-model="form.status" value="good" type="radio" name="status" id="status-1" class="hidden peer">
                                                    <label for="status-1" class="flex items-center p-2 hover:bg-gray-50 text-sm font-medium text-gray-600 peer-checked:text-blue-600 rounded peer-checked:bg-gray-50">
                                                        Active
                                                    </label>
                                            </li>
                                        </ul>
                                    </div> -->
                                </li>
                                <li>
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100" @click="handleEdit"><PencilIcon class="w-4 h-4 mr-1" /> Edit</a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100" @click="handleDelete" ><TrashIcon class="w-4 h-4 mr-1" /> Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </transition>
            </div>
        </td>
    </tr>

    
</template>