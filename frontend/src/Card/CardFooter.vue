<script setup>
import { ThumbsUp, MessageSquareDot, Share2 } from 'lucide-vue-next'
import { useAuthStore } from '@/stores/authStore'
import { computed, ref } from 'vue';

const { post } = defineProps(['post'])
const emits = defineEmits(['likeUnLikePost', 'openCommentModal'])
const authStore = useAuthStore()

const likeUnLikePost = () => {
    emits('likeUnLikePost', post.id)
}

const isLikedByUs = computed(() => {
    return post.likes.some((like) => like.user_id === authStore.user.id);
});

</script>

<template>
    {{ isLikedByUs }}
    <footer class="border flex justify-between my-4 p-2 boder-l-0 border-r-0">
        <button type="button" @click="likeUnLikePost" class="flex gap-2 font-semibold"
        :class="isLikedByUs ? 'text-blue-500' : 'text-black'">
            <ThumbsUp/> Like ({{ post.likes_count }})
        </button>
        <button class="flex gap-2 font-semibold" @click="$emit('openCommentModal')">
            <MessageSquareDot/> Comment ({{ post.comments_count }})
        </button>
        <button class="flex gap-2 font-semibold">
            <Share2/> Share
        </button>
    </footer>
</template>