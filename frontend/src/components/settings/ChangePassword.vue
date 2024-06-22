<script setup>
import { reactive } from 'vue';

const passwordData = reactive({})
const { errors } = defineProps(['errors'])
const emits = defineEmits(["changePassword"]);

const changePassword = () => {
  emits("changePassword", passwordData);
};
</script>

<template>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent>
        <div>
          <label for="password" class="block text-sm text-gray-800"
            >Current Password</label
          >
          <input
            type="password"
            name="password"
            id="password"
            placeholder="Password"
            v-model="passwordData.current_password"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
          <small class="text-red-500" v-if="errors.password">{{
            errors.current_password[0]
          }}</small>
        </div>
        <div>
          <label for="password" class="block text-sm text-gray-800"
            >Password</label
          >
          <input
            type="password"
            name="password"
            id="password"
            placeholder="Password"
            v-model="passwordData.password"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
          <small class="text-red-500" v-if="errors.password">{{
            errors.password[0]
          }}</small>
        </div>
        <div>
          <label for="password_confirmed" class="block text-sm text-gray-800"
            >Password Confirmed</label
          >
          <input
            type="password"
            name="password"
            id="password_confirmed"
            placeholder="Password Confirmed"
            v-model="passwordData.password_confirmation"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
        </div>

        <div class="flex justify-center">
          <button
            @click="changePassword"
            type="button"
            class="rounded-lg text-white bg-blue-700 px-4 py-2"
          >
            Change Password
          </button>
        </div>
      </form>
    </div>
</template>