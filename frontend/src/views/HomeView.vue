<script setup>
import { useCommonStore } from '@/stores/commonStore';

    const store = useCommonStore()

</script>

<template>
    <main>
        <h1 class="text-3xl font-bold underline">
            {{ store.test }}
          </h1>
    </main>
</template>