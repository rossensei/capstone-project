<script setup>
import { inject } from 'vue';

defineProps({
    title: String,
})

const selectedTitle = inject('title')
</script>
<template>
    <div v-show="title == selectedTitle">
        <slot />
    </div>
</template>