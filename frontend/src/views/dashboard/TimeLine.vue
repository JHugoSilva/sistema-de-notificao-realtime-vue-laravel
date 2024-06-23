<script setup>
import { ref } from 'vue';
import Card from '@/components/Card.vue'
import { usePostStore } from '@/stores/postStore';
import CommentModal from '@/components/CommentModal.vue';

const postStore = usePostStore()
const commentModalIsOpen = ref(false)
const selectedPost = ref({})
postStore.getPosts()

const handleLikeUnLikePost = async (id) => {
    try {
        await postStore.likeUnLikePost(id)
    } catch (error) {
        console.log(error);
    }
}

const handlePostComment = async (data) => {
    try {
        postStore.postComment(data)
    } catch (error) {
        console.log(error);
    }
}


const openCommentModal = (post) => {
    selectedPost.value = post
    commentModalIsOpen.value = true
}

</script>

<template>
    <div class="flex items-center flex-col gap-4">
        <Card v-for="post in postStore.posts" :key="post.id" :post="post" 
        @likeUnLikePost="handleLikeUnLikePost" 
        @openCommentModal="openCommentModal"/>
        <CommentModal :post="selectedPost" @postComment="handlePostComment" v-if="commentModalIsOpen" @close="()=>(commentModalIsOpen = false)"/>
    </div>
</template>