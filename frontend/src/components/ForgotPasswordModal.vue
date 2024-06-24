<script setup>
import { reactive, ref } from "vue";

// ["open", "close", "loader"]
const props = defineProps({
  open: Boolean,
  close: Function,
  loader: Boolean,
  step: {
    default: 'step-1'
  },
  errors:Object
});
const emits = defineEmits(['sendOTP', 'changePassword']);

const data = reactive({
  email:'',
  code:'',
  password:'',
  password_confirmation:''
})
const handleClose = () => {
  props.close();
  data.email = ''
  data.code = ''
  data.password = ''
  data.password_confirmation = ''
};

const handleSendOTP = () => {
  emits('sendOTP', data)
};

const handleChangePassword = () => {
  emits('changePassword', data)
}
</script>
<template>
  <div
    v-if="open"
    class="fixed inset-0 z-10 bg-black bg-opacity-50 flex justify-center items-center"
  >
    <div
      class="bg-gray-200 min-w-[36rem] w auto min-h-[300px] rounded-lg px-6 py-4 flex flex-col justify-between"
    >
      <div id="step-1" v-if="step == 'step-1'">
        <h1 class="text-2xl text-gray-600 font-semibold text-center">
          Forgot Password
        </h1>
        <div class="py-8">
          <label for="" class="block text-sm text-gray-800 py-3">Email</label>
          <input
            type="email"
            v-model="data.email"
            placeholder="Enter your email"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
          <small v-if="errors?.email" class="text-red-500 text-sm">{{ errors.email[0] }}</small>
        </div>
      </div>

      <div id="step-2" v-else>
        <h1 class="text-2xl text-gray-600 font-semibold text-center">
          Forgot Password
        </h1>
        <div>
          <label for="" class="block text-sm text-gray-800 py-3">OTP</label>
          <input
            type="number"
            v-model="data.code"
            placeholder="Enter OPT"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
          <small v-if="errors?.code" class="text-red-500 text-sm">{{ errors.code[0] }}</small>
        </div>
        <div>
          <label for="" class="block text-sm text-gray-800">New Password</label>
          <input
            type="password"
            v-model="data.password"
            placeholder="Enter Password"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
          <small v-if="errors?.password" class="text-red-500 text-sm">{{ errors.password[0] }}</small>
        </div>
        <div>
          <label for="" class="block text-sm text-gray-800">Confirm Password</label>
          <input
            type="password"
            v-model="data.password_confirmation"
            placeholder="Enter Confirm Password"
            class="rounded-lg px-4 py-2 border border-gray-600 shadow leading-6 w-full"
          />
        </div>
      </div>

      <div class="py-5">
        <div class="flex gap-1 justify-end">
          <button
            :disabled="loader"
            @click="handleClose"
            class="rounded-lg text-gray-600 hover:text-gray-900 px-4 py-2"
          >
            Cancel
          </button>
          <button v-if="step=='step-1'"
          :disabled="loader"
           @click="handleSendOTP"
            class="rounded-lg text-white bg-gray-500 hover:text-gray-700 px-4 py-2"
          >
            {{ loader ? 'Sending...':'Send' }}
          </button>

          <button v-else
          :disabled="loader"
           @click="handleChangePassword"
            class="rounded-lg text-white bg-gray-500 hover:text-gray-700 px-4 py-2"
          >
            {{ loader ? 'Submitting...':'Submit' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
