<script setup>
import { ThumbsUp, MessageSquareDot, Share2 } from 'lucide-vue-next'
</script>

<template>
    <footer class="border flex justify-between my-4 p-2 boder-l-0 border-r-0">
        <button class="flex gap-2 font-semibold">
            <ThumbsUp/> Like
        </button>
        <button class="flex gap-2 font-semibold">
            <MessageSquareDot/> Comment
        </button>
        <button class="flex gap-2 font-semibold">
            <Share2/> Share
        </button>
    </footer>
</template>