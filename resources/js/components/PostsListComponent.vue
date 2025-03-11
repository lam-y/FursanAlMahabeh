<template>
  <div class="row" dir="rtl">
    <div v-for="(post, index) in posts" :key="index" class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <post-item :post="post"></post-item>
    </div>
  </div>
</template>

<script>
export default {
  props: ["posts"],

  data() {
    return {};
  },
};
</script>

<style>
</style>
