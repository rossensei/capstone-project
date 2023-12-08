<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
    data: Object,
})


const displayedPages = computed(() => {
  const filteredLinks = props.data.links.filter(link => link.label !== 'Previous' && link.label !== 'Next');

  const pagesToShow = 5;
  let start = Math.max(1, props.data.current_page - Math.floor(pagesToShow / 2));
  const end = Math.min(filteredLinks.length, start + pagesToShow - 1);

  if(end - start + 1 < pagesToShow) {
    start = Math.max(1, end - pagesToShow + 1);
  }

  const pages = [];
  for(let i = start; i <= end; i++) {
    pages.push(i);
  }

  return pages;
})

const goToPage = (page) => {
  router.get(router.page.url, { page: page })
}

const noPreviousPage = computed(() => {
  return props.data.current_page - 1 <= 0;
})

const noNextPage = computed(() => {
  return props.data.current_page + 1 > props.data.last_page;
})

const emits = defineEmits(['update-per-page'])

const updatePageSize = (event) => {
  emits('update-per-page', event.target.value)
}
</script>

<template>
    <nav class="flex flex-wrap space-x-1">
      <!-- First Page Button -->
      <button @click="goToPage(1)" class="h-10 w-10 rounded-full text-sm flex items-center justify-center" :class="{ 'hover:bg-gray-100' : !noPreviousPage }" :disabled="noPreviousPage">
        <ChevronDoubleLeftIcon class="w-3 h-3" />
      </button>

      <button @click="goToPage(data.current_page - 1)" class="h-10 w-10 rounded-full text-sm flex items-center justify-center" :class="{ 'hover:bg-gray-100' : !noPreviousPage }" :disabled="noPreviousPage">
        <ChevronLeftIcon class="w-3 h-3" />
      </button>

      <!-- Page Numbers -->
          <button
            v-for="n in displayedPages" :key="n"
            @click="goToPage(n)"
            class="h-10 w-10 rounded-full text-sm flex items-center justify-center"
            :class="[ n === data.current_page ? 'bg-blue-50 text-blue-500 font-medium' : 'hover:bg-gray-100' ]"
            >
                {{ n }}
          </button>

      <!-- Next Page Button-->
      <button @click="goToPage(data.current_page + 1)" class="h-10 w-10 rounded-full flex items-center justify-center" :class="{ 'hover:bg-gray-100' : !noNextPage }" :disabled="noNextPage">
        <ChevronRightIcon class="w-3 h-3" />
      </button>

      <!-- Last Page Button -->
      <button @click="goToPage(data.last_page)" class="h-10 w-10 rounded-full flex items-center justify-center" :class="{ 'hover:bg-gray-100' : !noNextPage }" :disabled="noNextPage" >
        <ChevronDoubleRightIcon class="w-3 h-3" />
      </button>

      <select id="per-page" @change="updatePageSize($event)" class="ml-2 text-sm rounded-md border-gray-300">
        <option value="5" :selected="data.per_page === 5">5</option>
        <option value="10" :selected="data.per_page === 10">10</option>
        <option value="15" :selected="data.per_page === 15">15</option>
        <option value="20" :selected="data.per_page === 20">20</option>
        <option value="25" :selected="data.per_page === 25">25</option>
      </select>
    </nav>
</template>