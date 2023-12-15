<script setup>
import { ref } from 'vue';

const props = defineProps({

})

const count = ref(0);

const increment = () => {
  count.value++;
};

const decrement = () => {
  if (count.value > 0) {
    count.value--;
  }
};

const updateCount = (event) => {
  count.value = parseInt(event.target.value);
};
</script>

<template>
    <div class="flex items-center">
      <button class="px-4 py-2 rounded-l border border-gray-300 bg-white text-gray-500 hover:text-gray-700 focus:outline-none" @click="decrement">-</button>
      <input class="px-4 py-2 border-t border-b border-gray-300 bg-white text-center" type="number" :value="count" @input="updateCount">
      <button class="px-4 py-2 rounded-r border border-gray-300 bg-white text-gray-500 hover:text-gray-700 focus:outline-none" @click="increment">+</button>
    </div>
</template>