<template>
  <div class="user-layout">
    <userHeader/>
    <router-view />
  </div>
</template>

<script>
import userHeader from  "../components/userHeader.vue";
export default {
  components: { userHeader },
};
</script>

<style>
</style>