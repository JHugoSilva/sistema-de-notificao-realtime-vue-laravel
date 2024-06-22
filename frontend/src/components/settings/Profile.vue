<script setup>
const { user } = defineProps({
  user: Object,
});

const emits = defineEmits(["updateProfile"]);

const updateProfile = () => {
  emits("updateProfile", user);
};
</script>

<template>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent>
        <div>
          <label for="first_name" class="block text-sm text-gray-800"
            >First Name</label
          >
          <input
            type="text"
            name="first_name"
            id="first_name"
            v-model="user.first_name"
            placeholder="First Name"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
          <small class="text-red-500"></small>
        </div>
        <div>
          <label for="last_name" class="block text-sm text-gray-800"
            >Last Name</label
          >
          <input
            type="text"
            name="last_name"
            id="last_name"
            v-model="user.last_name"
            placeholder="Last Name"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
        </div>
        <div>
          <label for="email" class="block text-sm text-gray-800">Email</label>
          <input
            type="email"
            name="email"
            id="email"
            v-model="user.email"
            placeholder="Email"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
        </div>
        <div class="flex justify-center">
          <button
            @click="updateProfile"
            type="button"
            class="rounded-lg text-white bg-blue-700 px-4 py-2"
          >
            Save
          </button>
        </div>
      </form>
    </div>
</template>