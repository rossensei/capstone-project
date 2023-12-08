<script setup>
import { ExclamationTriangleIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    item: Object
})

const emit = defineEmits(['close-modal'])

const confirm = () => {
    router.delete('/admin/items/delete-item/' + props.item.id, {
        onFinish: () => emit('close-modal')
    })
}
</script>

<template>
    <div class="w-full p-6">
        <div class="flex items-start space-x-3">
            <div class="shrink-0">
                <ExclamationTriangleIcon class="w-6 h-6 text-red-500" />
            </div>
    
            <div class="flex-1">
                <h1 class="text-lg font-semibold text-red-600">Delete Confirmation</h1>
                <div class="text-sm text-gray-800">
                    Are you sure you want to delete "{{ props.item.name }}"?
                    You cannot undo this action.
                </div>
            </div>
    
            <div class="shrink-0">
                <button @click="emit('close-modal')">
                    <XMarkIcon class="w-6 h-6 text-gray-600" />
                </button>
            </div>
        </div>

        <div class="mt-4 flex justify-end items-center space-x-2">
            <button type="button" @click="emit('close-modal')"
            class="px-4 py-2 rounded-lg text-sm text-gray-600 font-medium bg-gray-100 hover:bg-gray-200"
            > Cancel </button>

            <button
                type="button"
                class="px-4 py-2 bg-red-600 rounded-lg font-medium text-sm text-white hover:bg-red-500 transition-color ease-in-out duration-150"
                @click="confirm"
            >
                Yes, Delete
            </button>
        </div>
    </div>
</template>