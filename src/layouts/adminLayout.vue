<template>
  <div class="admin-layout">
    <adminHeader/>
    <router-view/>
  </div>
</template>

<script>
import adminHeader from  "../components/admHeader.vue";
export default {
  components: { adminHeader },
};
</script>

<style>
</style>