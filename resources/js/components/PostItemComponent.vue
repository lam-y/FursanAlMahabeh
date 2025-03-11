<template>
  <div class="row">
    <div class="portfolio-item">
      <a
        class="portfolio-link"
        data-bs-toggle="modal"
        href="#"
        @click="openModal(post)"
      >
        <div class="portfolio-hover">
          <div class="portfolio-hover-content">
            <i class="fas fa-plus fa-3x"></i>
          </div>
        </div>
        <img class="img-fluid2" :src="getImageUrl(post.img)" alt="..." />
      </a>
      <div class="portfolio-caption">
        <div class="portfolio-caption-heading text-center fs-4 mt-2">{{ post.title }}</div>
      </div>
    </div>
    <post-modal :modal-data="modalData" :modal-id="post.id"></post-modal>
  </div>
</template>

<script>
export default {
  props: ["post"],

  data() {
    return {
      modalData: null,
    };
  },

  methods: {
    openModal(post) {
      this.modalData = {
        title: post.title,
        images: [
          this.getImageUrl(post.img),
          ...post.images.map((image) => this.getImageUrl(image.img)),
        ],
        content: post.content,
      };
      this.$bvModal.show('modal-'+post.id);
    },

    getImageUrl(imageName) {
      return `${window.location.origin}/storage/posts/${imageName}`;
    },
  },
};
</script>

<style>
.portfolio-item {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.img-fluid2 {
  width: 100%;
  height: 400px !important;
  object-fit: cover;
}

.portfolio-caption {
  flex-grow: 0;
}
</style>
