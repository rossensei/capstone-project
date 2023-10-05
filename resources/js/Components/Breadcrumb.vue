<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    crumbs: Array
})

</script>

<template>

    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
          <li class="inline-flex items-center" v-for="(item, index) in crumbs" :key="index">   
            <div class="flex items-center">
              <svg v-if="index !== crumbs.length && index !== 0" class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
              </svg>

              <svg v-else class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
              </svg>

              <Link v-if="index < (crumbs.length - 1)" :href="item.url" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">              
                {{ item.name }}            
              </Link>

              <span v-else class="ml-1 text-sm font-medium text-gray-400 md:ml-2">{{ item.name }}</span>
            </div>
          </li>
        </ol>

    </nav>
      
  
</template>