<template>
  <div class="row" dir="rtl">
        <div v-for="(member, index) in members.data" :key="index" class="col-lg-2">
            <div class="team-member">
                <img class="mx-auto rounded-circle" :src="getImageUrl(member.photo)" alt="..." />
                <h4 class="small-title text-center name-font">{{ member.name }}</h4>
                <p class="text-muted small-text text-center type-font">{{ member.member_type_name }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["members"],

    data() {
        return {};
    },

    methods:{
        getImageUrl(imageName) {
            let url = imageName ? `${window.location.origin}/storage/members/${imageName}` : '/img/default-user.png';
            return url;
        },
    }

}
</script>

<style>
.name-font{
    font-size: 18px !important;
    color: #25405a;
}

.type-font{
    font-size: 14px !important;
}
</style>
