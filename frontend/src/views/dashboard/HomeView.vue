<script setup>
import Header from '../../components/Header.vue'
</script>

<template>
    <!-- <div class="bg-gray-200 w-full md:w-[50%] flex justify-center flex-col min-h-full px-6 py-12">
        <Header/>
    </div> -->
    <div class="flex justify-center">
        <div class="w-full flex justify-center md:w-[50%] bg-gray-200 flex-col">
            <Header />
        </div>
    </div>
    <div class="flex justify-center h-screen">
        <div class="w-full flex md:w-[50%] bg-gray-200 flex-col px-6 py-12">
            <router-view></router-view>
        </div>
    </div>
</template>