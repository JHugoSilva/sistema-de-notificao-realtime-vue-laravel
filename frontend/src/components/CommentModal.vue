<script setup>
import X from 'lucide-vue-next'
import CommentItem from './CommentItem.vue'
</script>

<template>
	<div class="fixed inset-0 w-full h-full flex justify-center items-center flex-col bg-black/40">
		<div class="w-[90%] md:w-[50%] bg-gray-200 pt-2 rounded-md">
			<div class="border-gray-500 border-b-2 mb-2 text-center flex justify-between">
				<div class="py-2 px-8">

					<span class="text-xl text-center font-semibold">HBilal Khan's Post</span>
				</div>
				<button @click="$emit('close')" class="text-white bg-gray-500 hover:bg-gray-700 rounded-full p-1 m-2">
					<X />
				</button>
			</div>
			<div class="overflow-y-auto max-h-[600px] min-h-96 px-2">
                <div>Post Content</div>
                <CommentItem/>
			</div>

			<div class="flex justify-center w-full mt-2 px-3">
				<textarea
					class="w-full p-2 resize-none rounded-l-lg"
					placeholder="Write a comment..."
				></textarea>
				<button
					class="bg-blue-500 text-white p-2 rounded-r-lg"
				>
					Post
				</button>
			</div>
		</div>
	</div>
</template>