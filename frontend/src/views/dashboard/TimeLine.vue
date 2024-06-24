<script setup>
import { onMounted, reactive, ref } from "vue";
import Card from "@/components/Card.vue";
import { usePostStore } from "@/stores/postStore";
import CommentModal from "@/components/CommentModal.vue";
import PostModal from "@/components/Post/PostModal.vue";

const postStore = usePostStore();
const commentModalIsOpen = ref(false);
const postModalIsOpen = ref(false);
const selectedPost = ref({});
const errors = ref({});
postStore.getPosts();

onMounted(()=>{
  // console.log(Echo.private('post').listen('PostEvent'));
  Echo.private('post').listen('PostEvent', (e) => {
    postStore.addToPostArray(e.data)
  })
  Echo.private('comment').listen('CommentEvent', (e) => {
    postStore.addToCommentArray(e.data)
  })
  Echo.private('like').listen('LikeEvent', (e) => {
    postStore.addToLikeArray(e.data)
  })
})

const handleLikeUnLikePost = async (id) => {
  try {
    await postStore.likeUnLikePost(id);
  } catch (error) {
    console.log(error);
  }
};

const handlePostComment = async (data) => {
  try {
    postStore.postComment(data);
  } catch (error) {
    console.log(error);
  }
};

const handleCreatePost = async (data) => {
  try {
    const formData = new FormData();
    if (data.image) {
      formData.append("image", data.image);
    }
    formData.append("text", data.text);
    await postStore.createPost(formData);
    postModalIsOpen.value = false
    formData.value = ""
  } catch (error) {
    errors.value = error.response?.data.errors;
  }
};

const openCommentModal = (post) => {
  selectedPost.value = post;
  commentModalIsOpen.value = true;
};

const _openPostModal = () => {
  postModalIsOpen.value = true;
};
</script>

<template>
  <div class="flex items-center flex-col gap-4 relative">
    <button
      @click="_openPostModal"
      class="sticky top-20 bg-white shadow-md px-2 py-4 rounded-full text-center font-semibold"
    >
      What's in your mind
    </button>
    <Card
      v-for="post in postStore.posts"
      :key="post.id"
      :post="post"
      @likeUnLikePost="handleLikeUnLikePost"
      @openCommentModal="openCommentModal"
    />
    <CommentModal
      :post="selectedPost"
      @postComment="handlePostComment"
      v-if="commentModalIsOpen"
      @close="() => (commentModalIsOpen = false)"
    />
    <PostModal
      @createPost="handleCreatePost"
      :isOpen="postModalIsOpen"
      :close="() => (postModalIsOpen = false)"
    />
  </div>
</template>
