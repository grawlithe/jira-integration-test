export interface ProjectSummary {
    id: number
    name: string
    active_sprint: string | null
    planned_hours: number
    spent_hours: number
    //progress: number | null
}
