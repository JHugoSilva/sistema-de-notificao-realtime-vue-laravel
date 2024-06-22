<script setup>
import Card from '@/components/Card.vue'
import { usePostStore } from '@/stores/postStore';
import { ref } from 'vue';

const postStore = usePostStore()
postStore.getPosts()
const posts = ref(postStore.posts)

</script>

<template>
    <div class="flex items-center flex-col gap-4">
        <Card v-for="post in postStore.posts" :key="post.id" :post="post"/>
    </div>
</template>