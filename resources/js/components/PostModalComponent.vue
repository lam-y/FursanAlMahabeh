<template>
<b-modal
  :id="'modal-'+modalId"
  size="xl"
  :no-close-on-backdrop="true"
  no-enforce-focus
  hide-footer
>
  <!-- تعديل الهيدر لاستبدال زر الإغلاق الافتراضي -->
  <template #modal-header>
    <div class="d-flex justify-content-end align-items-center w-100">
      <img
        src="img/close-icon.svg"
        alt="Close modal"
        @click="closeModal()"
        class="custom-close-icon"
      />
    </div>
  </template>

  <div class="container text-center">
    <h2 class="text-uppercase">{{ currentData.title }}</h2>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button
          v-for="(image, index) in currentData.images"
          :key="index"
          type="button"
          :data-bs-target="'#carouselExampleIndicators'"
          :data-bs-slide-to="index"
          :class="{ active: index === 0 }"
          aria-current="index === 0 ? 'true' : 'false'"
          aria-label="'Slide ' + (index + 1)"
        ></button>
      </div>

      <div class="carousel-inner">
        <div
          v-for="(image, index) in currentData.images"
          :key="index"
          :class="['carousel-item', index === 0 ? 'active' : '']"
        >
          <img :src="image" class="modal-image d-block w-100" alt="..." />
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">السابق</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">التالي</span>
      </button>
    </div>

    <p v-html="currentData.content" class="mt-5"></p>

    <button class="btn btn-primary btn-xl text-uppercase mt-4" type="button" @click="closeModal()">
      إغلاق
    </button>
  </div>
</b-modal>

</template>

<script>
export default {
    props: ['modalData', 'modalId'],

    data(){
        return{
            currentData: this.modalData ? { ...this.modalData } : this.getNewData(),
        }
    },

    watch: {
        modalData(newVal) {
            this.currentData = newVal ? { ...newVal } : this.getNewData();
        },
        modalId(newVal) {
            alert(newVal);
            this.modalId = newVal;
        }
    },

    methods: {
        getNewData() {
            return {
                modalId: null,
                title: null,
                images: null,
                content: null,
            };
        },

        closeModal() {
            this.$bvModal.hide('modal-'+this.modalId);
        },

    }
}
</script>

<style>

.custom-close-icon {
    width: 24px;
    height: 24px;
    cursor: pointer;
    margin-right: 10px;
}

.modal-image {
  max-height: 500px !important;
  object-fit: cover;
}

</style>
