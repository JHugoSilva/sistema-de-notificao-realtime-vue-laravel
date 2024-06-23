import { defineStore } from "pinia";

export const usePostStore = defineStore('postStore', {
    state: () => {
        return {
            posts:[]
        }
    },
    actions: {
        async getPosts() {
            // if (this.posts.length > 0) return
            const { getPosts } = await import('@/services/post_service')
            try {
                const response = await getPosts()
                this.posts = response.data.data
            } catch (error) {
                throw error
            }
        }, 
        async likeUnLikePost(id) {
            // if (this.posts.length > 0) return
            const { likeUnLikePost } = await import('@/services/post_service')
            try {
                const response = await likeUnLikePost(id)
                if (response.status == 201) {
                    const index = this.posts.findIndex(p => p.id === id)
                    this.posts[index].likes.push(response.data)
                    this.posts[index].likes_count += 1
                } else if (response.status == 200) {
                    const index = this.posts.findIndex(p => p.id === id)
                    this.posts[index].likes = this.posts[index].likes.filter(l => l.id !== response.data.likeId)
                    this.posts[index].likes_count -= 1
                }
                // this.posts = response.data.data
            } catch (error) {
                throw error
            }
        }, 
        async postComment(data) {
            // if (this.posts.length > 0) return
            const { postComment } = await import('@/services/post_service')
            try {
                const response = await postComment(data)
                if (response.data) {
                    const index = this.posts.findIndex(p => p.id === response.data.post_id)
                    this.posts[index].comments.push(response.data)
                    this.posts[index].comments_count += 1
                } 
                // this.posts = response.data.data
            } catch (error) {
                throw error
            }
        }, 
        async createPost(data) {
            // if (this.posts.length > 0) return
            const { createPost } = await import('@/services/post_service')
            try {
                const response = await createPost(data)
                if (response.data) {
                    this.posts.unshift(response.data.data)
                } 
                // this.posts = response.data.data
            } catch (error) {
                throw error
            }
        }
    }
})