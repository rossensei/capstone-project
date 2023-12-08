<script setup>
import { ExclamationTriangleIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    unit: Object
})

const emits = defineEmits(['close-modal']);

const confirm = () => {
    router.delete('/admin/units/delete-unit/' + props.unit.id, {
        onSuccess: () => emits('close-modal')
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
                    Are you sure you want to delete "{{ props.unit.unit_name }}"?
                    You cannot undo this action.
                </div>
            </div>
    
            <div class="shrink-0">
                <button @click="emits('close-modal')">
                    <XMarkIcon class="w-6 h-6 text-gray-600" />
                </button>
            </div>
        </div>

        <div class="mt-4 flex justify-end items-center space-x-2">
            <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium" @click="emits('close-modal')">Cancel</button>
            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium" @click="confirm">Confirm</button>
        </div>
    </div>
</template>