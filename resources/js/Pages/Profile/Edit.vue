<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
// import UserPhotoForm from './Partials/UserPhotoForm.vue';
import UserPhotoForm from '@/Pages/Profile/Partials/UserPhotoForm.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { ChevronUpIcon } from '@heroicons/vue/20/solid';
import { InformationCircleIcon, LockClosedIcon, KeyIcon } from '@heroicons/vue/24/outline';

import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="w-full sm:px-6 lg:px-8">
                <h1 class="font-semibold text-3xl text-gray-700 leading-tight">My Account</h1>
                <p class="text-md font-normal text-gray-600">Manage your account's profile information.</p>

                

                <div class="p-4 bg-white shadow divide-y divide-gray-200 rounded-lg mt-6">

                    
                    <Disclosure as="div" v-slot="{ open }" :defaultOpen="true">
                        <DisclosureButton
                            class="flex w-full justify-between p-4 focus:border-transparent focus:outline-none focus:ring-4 focus:ring-gray-200 bg-white hover:bg-gray-100"
                        >
                            <span class="text-lg font-semibold text-gray-600">
                                Avatar
                            </span>
                            <ChevronUpIcon
                            :class="open ? 'rotate-180 transform' : ''"
                            class="h-5 w-5 text-gray-500"
                            />
                        </DisclosureButton>
                        <transition
                        enter-active-class="transition-transform duration-100"
                        enter-from-class="-translate-y-4 opacity-0"
                        enter-to-class="-translate-y-0 opacity-100"
                        leave-active-class="transition transform duration-100 ease-out"
                        leave-from-class="-translate-y-0 opacity-100"
                        leave-to-class="-translate-y-4 opacity-0"
                        >
                            <DisclosurePanel class="px-4 py-2 text-sm text-gray-500">
                                <UserPhotoForm />
                            </DisclosurePanel>
                        </transition>
                    </Disclosure>

                    <Disclosure as="div" v-slot="{ open }" :defaultOpen="true">
                        <DisclosureButton
                            class="flex w-full justify-between p-4 focus:border-transparent focus:outline-none focus:ring-4 focus:ring-gray-200 bg-white hover:bg-gray-100"
                        >
                            <span class="text-lg font-semibold text-gray-600">
                                Personal Information
                            </span>
                            <ChevronUpIcon
                            :class="open ? 'rotate-180 transform' : ''"
                            class="h-5 w-5 text-gray-500"
                            />
                        </DisclosureButton>
                        <transition
                        enter-active-class="transition-transform duration-100"
                        enter-from-class="-translate-y-4 opacity-0"
                        enter-to-class="-translate-y-0 opacity-100"
                        leave-active-class="transition transform duration-100 ease-out"
                        leave-from-class="-translate-y-0 opacity-100"
                        leave-to-class="-translate-y-4 opacity-0"
                        >
                            <DisclosurePanel class="px-4 py-2 text-sm text-gray-500">
                                <UpdateProfileInformationForm
                                :must-verify-email="mustVerifyEmail"
                                :status="status"
                                class="max-w-4xl"
                                />
                            </DisclosurePanel>
                        </transition>
                    </Disclosure>
                    <Disclosure as="div" class="mt-2" v-slot="{ open }">
                        <DisclosureButton
                        class="flex w-full justify-between p-4 focus:border-transparent focus:outline-none focus:ring-4 focus:ring-gray-200 bg-white hover:bg-gray-100"
                        >
                        <span class="text-lg font-semibold text-gray-600">
                            Update Password
                        </span>
                          <ChevronUpIcon
                            :class="open ? 'rotate-180 transform' : ''"
                            class="h-5 w-5 text-gray-500 transition-transform"
                          />
                        </DisclosureButton>
                        <transition
                        enter-active-class="transition-transform duration-100"
                        enter-from-class="-translate-y-4 opacity-0"
                        enter-to-class="-translate-y-0 opacity-100"
                        leave-active-class="transition transform duration-100 ease-out"
                        leave-from-class="-translate-y-0 opacity-100"
                        leave-to-class="-translate-y-4 opacity-0"
                        >
                            <DisclosurePanel class="px-4 py-2 text-sm text-gray-500">
                                <UpdatePasswordForm class="max-w-4xl" />
                            </DisclosurePanel>
                        </transition>
                    </Disclosure>
                    <!-- <Disclosure as="div" class="mt-2" v-slot="{ open }">
                        <DisclosureButton
                        class="flex w-full justify-between p-4 focus:border-transparent focus:outline-none focus:ring-4 focus:ring-gray-200 bg-white hover:bg-gray-100"
                        >
                        <span class="text-lg font-semibold text-gray-600">
                            Account Control
                        </span>

                          <ChevronUpIcon
                            :class="open ? 'rotate-180 transform' : ''"
                            class="h-4 w-4 text-gray-500"
                          />
                        </DisclosureButton>
                        <transition
                        enter-active-class="transition-transform duration-100"
                        enter-from-class="-translate-y-4 opacity-0"
                        enter-to-class="-translate-y-0 opacity-100"
                        leave-active-class="transition transform duration-100 ease-out"
                        leave-from-class="-translate-y-0 opacity-100"
                        leave-to-class="-translate-y-4 opacity-0"
                        >
                            <DisclosurePanel class="px-4 pb-2 pt-4 text-sm text-gray-500">
                                <DeleteUserForm class="max-w-4xl" />
                            </DisclosurePanel>
                        </transition>

                    </Disclosure> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
