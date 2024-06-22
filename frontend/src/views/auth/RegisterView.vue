<script setup>
import { reactive, ref } from 'vue';
import { register } from '../../services/auth_service'
import { toast } from 'vue3-toastify'
import { useRouter } from 'vue-router';

const router = useRouter()

const form = reactive({
    first_name:'',
    last_name:'',
    email:'',
    password:'',
    password_confirmation:'',
})

const errors = ref({})

const handleRegister = async () => {
  try {
    await register(form)
    toast.success('Account Created')
    form.value = {}
    errors.value = {}
    setTimeout(()=>{
      router.push('/login')
    },1000)
  } catch (error) {
    errors.value = error.response.data.message;
    console.log(error.response.data.message);
  }
}
</script>
<template>
    <div class="flex flex-col min-h-full justify-center px-6 py-12">
        <div
          class="w-full  p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-light-800 dark:border-gray-700"
        >
      <div class="">
        <h2
          class="mt-10 text-center text-2xl font-bold leading-9 tracking-light text-gray-900"
        >
          Create new account
        </h2>
      </div>
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
              placeholder="First Name"
              v-model="form.first_name"
              class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
            />
            <small class="text-red-500" v-if="errors.first_name">{{errors.first_name[0]}}</small>
          </div>
          <div>
            <label for="last_name" class="block text-sm text-gray-800"
              >Last Name</label
            >
            <input
              type="text"
              name="last_name"
              id="last_name"
              placeholder="Last Name"
              v-model="form.last_name"
              class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
            />
            <small class="text-red-500" v-if="errors.last_name">{{errors.last_name[0]}}</small>
          </div>
          <div>
            <label for="email" class="block text-sm text-gray-800">Email</label>
            <input
              type="email"
              name="email"
              id="email"
              placeholder="Email"
              v-model="form.email"
              class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
            />
            <small class="text-red-500" v-if="errors.email">{{errors.email[0]}}</small>
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
              v-model="form.password"
              class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
            />
            <small class="text-red-500" v-if="errors.password">{{errors.password[0]}}</small>
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
              v-model="form.password_confirmation"
              class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
            />
          </div>
          <div class="flex justify-center">
            <button @click="handleRegister" type="button" class="rounded-lg text-white bg-blue-700 px-4 py-2">
              Create Account
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>