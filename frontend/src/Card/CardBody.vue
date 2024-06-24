<script setup>
import { useCommonStore } from '@/stores/commonStore';
const commonStore = useCommonStore()
const { post } = defineProps(['post'])

</script>

<template>
    <div class="flex flex-col justify-center pt-4 gap-2">
        <p class="text-sm">
            {{ post.text }}
        </p>
        <img v-if="post.image" class="rounded-lg" width="150" :src="commonStore.mediaUrl + post.image" alt="">
    </div>
</template>