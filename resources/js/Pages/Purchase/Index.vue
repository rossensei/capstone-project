<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TabWrapper from '@/Components/TabWrapper.vue'
import Tab from '@/Components/Tab.vue'
import Alert from '@/Components/Alert.vue'
import AddItemForm from './AddItemForm.vue';
import AddToExistingForm from './AddToExistingForm.vue';
import PropertyForm from './PropertyForm.vue';
import { useForm, Head } from '@inertiajs/vue3';

const props = defineProps({
    items: Array,
    categories: Array,
    units: Array,
    venues: Array,
})
</script>

<template>
    <Head title="Purchases" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="w-full sm:px-6 lg:px-8">
                <h2 class="font-semibold text-3xl text-gray-700 leading-tight">Purchases</h2>
                <p class="text-base text-gray-600">Add newly purchased items or properties</p>

                <Alert class="mt-3" />

                <div class="mt-6">
                    <TabWrapper>
                        <Tab title="Add New Item">
                            <div class="px-8">
                                <AddItemForm :units="units" :categories="categories" />
                            </div>
                        </Tab>
                        <Tab title="Replenish Item">
                            <div class="px-8">
                                <AddToExistingForm :items="props.items" />
                            </div>
                        </Tab>
                        <Tab title="Add New Property">
                            <div class="px-8">
                                <PropertyForm :venues="props.venues" />
                            </div>
                        </Tab>
                    </TabWrapper>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>