<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref, computed } from 'vue';
import {
  Combobox,
  ComboboxInput,
  ComboboxButton,
  ComboboxOptions,
  ComboboxOption,
  TransitionRoot,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon, XMarkIcon } from '@heroicons/vue/20/solid'

const isLoaded = ref(false);
const users = ref([]);

onMounted(() => {
    axios.get('http://127.0.0.1:8000/api/users/no-offices')
        .then((response) => {
            users.value = response.data;
        }).then(() => {
            isLoaded.value = true;
        });
})

const form = useForm({
    office_name: '',
    user_id: '',
})

const submit = () => {
    
    if(!form.user_id || form.user_id === '') {
        form.user_id = selected.value.id;
        
        form.post('/admin/offices', {
            onSuccess: () => emits('close-modal')
        })
    }

}

const emits = defineEmits(['close-modal']);

let selected = ref({})
let query = ref('')

let filteredUsers = computed(() =>
  query.value === ''
    ? users.value
    : users.value.filter((user) =>
        user.name
          .toLowerCase()
          .replace(/\s+/g, '')
          .includes(query.value.toLowerCase().replace(/\s+/g, ''))
    )
)
</script>

<template>

    <div v-if="!isLoaded" class="w-full p-6 animate-pulse">
        <div class="h-6 w-[120px] bg-gray-300 rounded-full mb-4"></div>

        <div class="mb-4 bg-gray-200 rounded-full h-7 w-full"></div>
        <div class="bg-gray-200 rounded-full h-7 min-w-[150px] flex-1 mb-4"></div>

        <div class="flex justify-end items-center">
            <div class="h-7 w-[120px] bg-gray-200 rounded-full"></div>
            <div class="h-7 w-[120px] bg-gray-300 rounded-full ml-3"></div>
        </div>
    </div>

    <div v-else class="bg-white w-full shadow p-6 rounded-lg">
        <h1 class="text-xl text-gray-700 font-semibold mb-2">Office details</h1>
        <form @submit.prevent="submit">
            <div class="max-w-2xl mb-4">
                <InputLabel class="text-sm" for="office_name" value="Office Name" />

                <TextInput 
                v-model="form.office_name" 
                class="w-full text-sm"
                id="office_name" />

                <InputError :message="form.errors.office_name" />
            </div>

            <div class="max-w-2xl mb-4">
                <InputLabel for="dept-head" class="text-sm" value="Office Head" />

                <!-- <select 
                v-model="form.user_id"
                class="w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                id="dept-head">
                    <option value="">Select a head</option>
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select> -->
                <Combobox v-model="selected">
                    <div class="relative">
                      <div
                        class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm border border-gray-300"
                      >
                        <ComboboxInput
                          class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                          :displayValue="(user) => user.name"
                          @change="query = $event.target.value"
                          placeholder="Enter office head"
                          autocomplete="off"
                        />
                        <ComboboxButton
                          class="absolute inset-y-0 right-0 flex items-center pr-2"
                        >
                          <ChevronUpDownIcon
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                          />
                        </ComboboxButton>
                      </div>
                      <TransitionRoot
                        leave="transition ease-in duration-100"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                        @after-leave="query = ''"
                      >
                        <ComboboxOptions
                          class="absolute mt-1 max-h-60 w-full rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
                        >
                          <div
                            v-if="filteredUsers.length === 0 && query !== ''"
                            class="relative cursor-default select-none px-4 py-2 text-gray-700"
                          >
                            Nothing found.
                          </div>
              
                          <ComboboxOption
                            v-for="user in filteredUsers"
                            as="template"
                            :key="user.id"
                            :value="user"
                            v-slot="{ selected, active }"
                          >
                            <li
                              class="relative cursor-default select-none py-2 pl-10 pr-4"
                              :class="{
                                'bg-[#4e73df] text-white': active,
                                'text-gray-900': !active,
                              }"
                            >
                              <span
                                class="block truncate"
                                :class="{ 'font-medium': selected, 'font-normal': !selected }"
                              >
                                {{ user.name }}
                              </span>
                              <span
                                v-if="selected"
                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                                :class="{ 'text-white': active, 'text-blue-600': !active }"
                              >
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                              </span>
                            </li>
                          </ComboboxOption>
                        </ComboboxOptions>
                      </TransitionRoot>
                    </div>
                  </Combobox>

                <InputError :message="form.errors.user_id" />
            </div>

            <div class="flex items-center justify-end space-x-2">
                <button type="button" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium" @click="$emit('close-modal')">Cancel</button>
                <button type="submit" class="px-4 py-2 text-sm rounded-md bg-[#4e73df] hover:bg-[#4e72dfc0] text-white ml-2" :class="{ 'bg-[#4e72dfc0]' : form.processing }" :disabled="form.processing">
                    <span v-if="form.processing" class="inilne-flex items-center">
                        <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        Saving...
                    </span>
    
                    <span v-if="!form.processing">Submit</span>
                </button>
            </div>
        </form>
    </div>

</template>