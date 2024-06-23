<script setup>
import CardHeader from './../Card/CardHeader.vue'
import CardBody from './../Card/CardBody.vue'
import CardFooter from './../Card/CardFooter.vue'
const { post } = defineProps(['post'])

</script>

<template>
    <div class="bg-white w-[90%] min-h-64 rounded-lg flex flex-col px-4 py-2">
       <CardHeader :post="post"/>
        <CardBody :post="post"/>
       <CardFooter :post="post" @openCommentModal="$emit('openCommentModal', post)" @likeUnLikePost="$emit('likeUnLikePost', $event)"/>
    </div>
</template>