import { defineStore } from 'pinia'
import type { ProjectSummary } from '@/types/ProjectSummary'

export const useProjectsStore = defineStore('projects', {
    state: () => ({
        projects: [] as ProjectSummary[],
    }),
    actions: {
        setProjects(data: ProjectSummary[]) {
            this.projects = data ?? []
        },
    },
});
