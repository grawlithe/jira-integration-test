<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

import ProjectTable from '@/components/ProjectTable.vue';
import { useProjectsStore } from '@/stores/useProjectsStore';
import SyncButton from '@/components/SyncButton.vue';

import { onMounted } from 'vue';


const props = defineProps<{
    projects: any[];
}>();

const store = useProjectsStore();
store.setProjects(props.projects ?? []);

onMounted(() => {
    console.log('Projects props:', props.projects);
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold">
                        Projects Dashboard
                    </h1>
                    <SyncButton />
                </div>
                <!-- <ProjectTable v-if="store.projects && store.projects.length" :projects="store.projects" /> -->
                <ProjectTable v-if="store.projects && store.projects.length" :projects="store.projects" />
                <div v-else class="text-gray-500 text-sm">
                    No projects found.
                </div>
            </div>
        </div>
    </AppLayout>
</template>
