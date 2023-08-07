<template>

    <div class="flex justify-center items-center h-[100vh]">
        <div class="bg-[#1D1D1D] p-8 rounded-[10px]">
            <h1 class="text-white/80 font-semibold text-center mb-4">{{ route.query.message }}</h1>
        </div>
    </div>
</template>

<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();
</script>

<style>
</style>