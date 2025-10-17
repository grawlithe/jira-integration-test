<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue';

const loading = ref(false);
const syncNow = async () => {
    loading.value = true
    await axios.post('/sync');
    loading.value = false
    window.location.reload();
}
</script>

<template>
    <button
        @click="syncNow"
        :disabled="loading"
        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50"
    >
        {{ loading ? 'Syncing...' : 'Sync Now' }}
    </button>
</template>
