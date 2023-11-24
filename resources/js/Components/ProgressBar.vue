<script setup>
import { computed } from 'vue'

const props = defineProps({
    value: Number,
    maxVal: Number,
})

const percent = computed(() => {
    return (props.value * 100) / props.maxVal;
})
</script>

<template>
    <!-- <div class="flex items-center space-x-2">
        <div class="w-28 text-center">
        <p>{{ Math.round(percent) }}%</p>
        </div> -->
    <div id="progress-bar" class="w-full bg-gray-200 rounded h-auto">
        <div id="percentage" 
        class="rounded transition-colors duration-200 text-center text-[10px] text-white font-medium" 
        :class="{
            'bg-green-500' : percent >= 70,
            'bg-yellow-400' : percent <= 70 && percent > 20,
            'bg-red-500' : percent <= 20,
        }"
        :style="`width:${percent}%`">
        {{ value }}/{{ maxVal }}
        </div>
    </div>
    <!-- </div> -->
</template>