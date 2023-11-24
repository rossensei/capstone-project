<script setup>
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { EllipsisHorizontalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    property: Object,
    department: Object
})

const emit = defineEmits([
    'edit',
    'delete',
])

const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
}

const handleEdit = () => {
    emit('edit', props.property)
    toggleDropdown()
}

const form = useForm({
    status: props.property.status
});

const updatePropertyStatus = () => {
    form.patch('/departments/' + props.department.id + '/inventory/' + props.property.id + '/status-update');
}

const handleDelete = () => {
    emit('delete', props.property);
    toggleDropdown();
}
</script>

<template>
    <tr class="bg-white relative">
        <td class="px-6 py-4">
            {{ property.tag_no }}
        </td>
        <td class="px-6 py-4">
            <span class="text-gray-700 font-medium">
                {{ property.name }}
            </span>
        </td>
        <td class="px-6 py-4">
                {{ property.description }}
        </td>
        <td class="px-6 py-4 text-center">
                {{ property.date_acquired }}
        </td>
        <td class="px-6 py-4 text-center">
            <select v-model="form.status" id="update-status" class="block p-2 w-full text-sm text-gray-900 bg-white shadow-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" @change="updatePropertyStatus">
                <option value="Good">Good</option>
                <option value="Damaged">Damaged</option>
                <option value="Repaired">Repaired</option>
                <option value="Lost">Lost</option>
            </select>
        </td>
        <td class="px-6 py-4 text-center">

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
                    <div v-show="isDropdownOpen" id="dropdown" class="z-20 w-auto absolute -bottom-14 right-4 bg-white divide-y divide-gray-100 rounded-lg shadow-md dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 text-left">
                            <li>
                                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100" @click="handleEdit"><PencilIcon class="w-4 h-4 mr-1" /> Edit</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100" @click="handleDelete" ><TrashIcon class="w-4 h-4 mr-1" /> Delete</a>
                            </li>
                        </ul>
                    </div>
                </transition>
        </td>
    </tr>
</template>
