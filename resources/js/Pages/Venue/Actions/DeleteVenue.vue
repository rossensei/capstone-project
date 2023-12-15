<script setup>
import { ExclamationTriangleIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    venue: Object
})

const emit = defineEmits(['close-modal'])

const confirm = () => {
    router.delete('/venues/remove-venue/' + props.venue.id, {
        onFinish: () => emit('close-modal')
    })
}
</script>

<template>
    <div class="p-6">
        <div class="flex items-start space-x-3">
            <div class="shrink-0">
                <ExclamationTriangleIcon class="w-6 h-6 text-red-500" />
            </div>
    
            <div class="flex-1">
                <h1 class="text-lg font-semibold text-red-600">Delete Confirmation</h1>
                <div class="text-sm text-gray-800">
                    Are you sure you want to delete "{{ venue.venue_name }}"?
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
            <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium" @click="emit('close-modal')">Cancel</button>
            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium" @click="confirm">Confirm</button>
        </div>
    </div>
</template>