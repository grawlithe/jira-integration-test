<script setup lang="ts">
import { type ProjectSummary } from '@/types/ProjectSummary';
import { computed, onMounted } from "vue";

const props = defineProps<{
    projects: ProjectSummary[];
}>();

onMounted(() => {
  console.log('Projects loaded:', withProgress.value)
})

const withProgress = computed(() =>
    props.projects.map((p) => ({
        ...p,
        progress: p.planned_hours ? Math.min((p.spent_hours / p.planned_hours) * 100, 100) : 0,
    })) as (ProjectSummary & {progress: number})[]
);

</script>

<template>
    <div class="overflow-hidden rounded-2x1 shadow bg-white">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3">Project</th>
                    <th class="px-4 py-3">Active Sprint</th>
                    <th class="px-4 py-3 text-right">Planned (h)</th>
                    <th class="px-4 py-3 text-right">Spent (h)</th>
                    <th class="px-4 py-3 text-right">Progress</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="p in withProgress"
                    :key="p.id"
                    class="border-b hover:bg-gray-50 transition-colors"
                >
                    <td class="px-4 py-3 font-medium text-gray-900">{{ p.name }}</td>
                    <td class="px-4 py-3 text-gray-900">{{ p.active_sprint ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-900 text-right">{{ p.planned_hours }}</td>
                    <td class="px-4 py-3 text-gray-900 text-right">{{ p.spent_hours }}</td>
                    <td class="px-4 py-3 text-gray-900 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <div class="w-24 bg-gray-200 h-2 rounded">
                                <div
                                    class="bg-blue-600 h-2 rounded"
                                    :style="`width: ${p.progress}%`"
                                ></div>
                            </div>
                            <span class="text-ws text-gray-600">{{ p.progress.toFixed(0) }}%</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
