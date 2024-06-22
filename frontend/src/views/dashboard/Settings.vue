<script setup>
import { useAuthStore } from '@/stores/authStore';
import { reactive, ref } from 'vue';
import { toast } from 'vue3-toastify'

import Profile from '@/components/settings/Profile.vue'
import ChangePassword from '@/components/settings/ChangePassword.vue'


const authStore = useAuthStore()
const activeTab = ref('profile')
const user = reactive(authStore.user)
const errors = ref({})

const changeTab = (tab) => {
  activeTab.value = tab
}

const updateProfile = async (data) => {
  try {
    await authStore.handleUpdateProfile(data)
    toast.success('Profile updated');
  } catch (error) {
    console.log(error);
  }
}

const updatePassword = async (passwordData) => {
  errors.value = {}
  try {
    await authStore.handleChangePassword(passwordData)
    passwordData.value = {}
    toast.success('Password updated');
  } catch (error) {
    errors.value = error.response.data.errors
  }
}
</script>
<template>
  <div class="flex justify-center gap-4 py-4 font-semibold">
    <button @click="changeTab('profile')"
      :class="activeTab == 'profile' && 'border-b-4 border-gray-600'">Profile</button>
    <button @click="changeTab('change-password')"
      :class="activeTab == 'change-password' && 'border-b-4 border-gray-600'">Change Password</button>
  </div>
  <div class="flex justify-center">
   
    <Profile v-if="activeTab=='profile'" :user="user" @updateProfile="updateProfile"/>
    <ChangePassword v-if="activeTab=='change-password'" :errors="errors" @changePassword="updatePassword"/>
  
  </div>


</template>