<script setup>
import { reactive, ref } from "vue";
import { toast } from "vue3-toastify";
import { login } from "../../services/auth_service";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/authStore";
import ForgotPasswordModal from "@/components/ForgotPasswordModal.vue";

const authStore = useAuthStore();
const router = useRouter();
const errors = ref({});
const loader = ref(false)
const step = ref('step-1')
const forgotPasswordModalIsOpen = ref(false);

const form = reactive({
  email: "j@email.com",
  password: "123456789",
});

const handleLogin = async () => {
  try {
    const response = await login(form);
    toast.success("Login");
    form.value = {};
    errors.value = "";
    authStore.setUser(response.data.user);
    authStore.setToken(response.data.access_token);
    setTimeout(() => {
      router.push("/timeline");
    }, 1000);
  } catch (error) {
    errors.value = error.response?.data.message;
    console.log(error.response.data.message);
  }
};

const handleForgotPasswordRequest = async (data) => {
  try {
    loader.value = true
    authStore.handleForgotPasswordRequest(data)
    // setTimeout(()=>{
    //   loader.value = false
    // },1000)
    loader.value = false
    step.value = 'step-2'
  } catch (error) {
    loader.value = false
    errors.value = error.response.data.errors
  }
}

const handleForgotPassword = async (data) => {
  try {
    loader.value = true
    authStore.handleForgotPassword(data)
    setTimeout(()=>{
      loader.value = false
    },1000)
    step.value = 'step-2'
    forgotPasswordModalIsOpen.value = false
    toast.success('Password successfully updated')
  } catch (error) {
    loader.value = false
    errors.value = error.response.data.errors
  }
}

const openForgotPasswordModalIsOpen = () => {
  forgotPasswordModalIsOpen.value = true;
};
</script>
<template>
  <div class="flex flex-col min-h-full justify-center px-6 py-12">
    <div
      class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-light-800 dark:border-gray-700"
    >
      <div class="">
        <h2
          class="mt-10 text-center text-2xl font-bold leading-9 tracking-light text-gray-900"
        >
          Sign in to you account
        </h2>
      </div>
      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        {{ errors }}
        <small class="text-red-500" v-if="Object.values(errors) != 0">{{
          errors
        }}</small>
        <form class="space-y-6" @submit.prevent>
          <div>
            <label for="email" class="block text-sm text-gray-800">Email</label>
            <input
              type="email"
              name="email"
              id="email"
              v-model="form.email"
              placeholder="Email"
              class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
            />
            <small class="text-red-500" v-if="errors.email">{{
              errors.email[0]
            }}</small>
          </div>
          <div>
            <label for="password" class="block text-sm text-gray-800"
              >Password</label
            >
            <div class="flex justify-between">
              <label for="" class="block text-sm text-gray-800">Password</label>
              <button
                @click="openForgotPasswordModalIsOpen"
                class="block text-sm text-gray-800 hover:text-gray-950 hover:underline"
              >
                Forgot Password?
              </button>
            </div>
            <input
              type="password"
              name="password"
              id="password"
              v-model="form.password"
              placeholder="Password"
              class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
            />
            <small class="text-red-500" v-if="errors.password">{{
              errors.password[0]
            }}</small>
          </div>
          <div class="flex justify-center">
            <button
              type="button"
              @click="handleLogin"
              class="rounded-lg text-white bg-blue-700 px-4 py-2"
            >
              Login
            </button>
          </div>
          {{ step }}
        </form>
      </div>
    </div>
  </div>
  <ForgotPasswordModal
    :step="step"
    :loader="loader"
    :open="forgotPasswordModalIsOpen"
    :close="() => (forgotPasswordModalIsOpen = false)"
    @sendOTP="handleForgotPasswordRequest"
    @changePassword="handleForgotPassword"
  />
</template>
