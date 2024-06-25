import { changePassword, logoOut, updateProfile, forgotPassword, forgotPasswordRequest, markNotificationComplete, markAllNotificationComplete } from "@/services/auth_service"
import { defineStore }  from "pinia"

export const useAuthStore = defineStore('authStore', {
    state: () => {
        return {
            user: {},
            isLoggedIn: false
        }
    },
    actions: {
        setUser(user) {
            this.user = user
            this.isLoggedIn = true
        },
        setToken(token){
            localStorage.setItem('access_token', token)
        },
        getToken() {
            const token = localStorage.getItem('access_token')

            if (token) {
                return token
            }

            return null
        },
        async handleUpdateProfile(data) {
            try {
                const response = await updateProfile(data)
                this.user = response.data.data
            } catch (error) {
                throw error
            } 
        },
        async handleChangePassword(data) {
            try {
                const response = await changePassword(data)
                console.log(response);
            } catch (error) {
                throw error
            } 
        },
        async logOut() {
            try {
                await logoOut()
                this.user = {}
                this.isLoggedIn = false
                localStorage.removeItem('access_token')
            } catch (error) {
                throw error
            }
        },
        async handleForgotPasswordRequest(data) {
            try {
                await forgotPasswordRequest(data)
            } catch (error) {
                throw error
            }
        },
        async handleForgotPassword(data) {
            try {
                await forgotPassword(data)
            } catch (error) {
                throw error
            }
        },
        async handleNotificationMarkComplete(id) {
            try {
                await markNotificationComplete(id)
                this.user.notifications = this.user.notifications.filter(n => n.id != id)
            } catch (error) {
                throw error
            }
        },
        async handleAllNotificationMarkComplete() {
            try {
                await markAllNotificationComplete()
                this.user.notifications = []
            } catch (error) {
                throw error
            }
        }
    },
    persist: {
        enabled: true
    }
})