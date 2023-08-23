<template>
    <div>
        <h1>reset successful</h1>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';

onMounted(() => {
    localStorage.removeItem('token');
    localStorage.removeItem('audience');
    localStorage.removeItem('user_level');
})
</script>

<style>
</style>