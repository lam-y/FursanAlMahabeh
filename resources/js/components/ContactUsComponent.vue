<template>
  <form @submit.prevent="submitForm" id="contactForm" dir="rtl">
        <div class="row align-items-stretch mb-5">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" id="name" type="text" v-model="formData.name" placeholder="الاسم *"/>
                    <div v-if="errors.name" class="invalid-feedback" >{{ errors.name[0] }}</div>
                </div>
                <div class="form-group">
                    <input class="form-control" id="email" type="email" v-model="formData.email" placeholder="البريد الالكتروني *" />
                    <div v-if="errors.email" class="invalid-feedback" >{{ errors.email[0] }}</div>
                </div>
                <div class="form-group mb-md-0">
                    <input class="form-control" id="phone" type="tel" v-model="formData.phone" placeholder="موبايل *" />
                    <div v-if="errors.phone" class="invalid-feedback" >{{ errors.phone[0] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group position-relative">
                    <input class="form-control date-input" id="birthdate" type="date" v-model="formData.birthdate"
                        :style="{ color: formData.birthdate ? '#000' : '#ced4da' }" />
                    <span class="date-placeholder" v-if="!formData.birthdate">تاريخ الميلاد *</span>
                    <div v-if="errors.birthdate" class="invalid-feedback">{{ errors.birthdate[0] }}</div>
                </div>

                <div class="form-group">
                    <input class="form-control" id="school" type="text" v-model="formData.school" placeholder="المدرسة" />
                </div>
                <div class="form-group mb-md-0">
                    <select class="form-control cus-select" id="grade" v-model="formData.grade"
                    :style="{ color: formData.grade === '' ? '#ced4da' : '#000' }">
                        <option value="" disabled :style="{ color: '#ced4da' }">الصف *</option>
                        <option v-for="grade in grades" :key="grade.id" :value="grade.id" :style="{ color: '#000' }">{{ grade.name }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-textarea mb-md-0">
                    <textarea class="form-control" id="message" v-model="formData.message" placeholder="اكتب هنا.. *"></textarea>
                    <div v-if="errors.message" class="invalid-feedback" >{{ errors.message[0] }}</div>
                </div>
            </div>
        </div>
        <!-- Submit success message-->
        <div class="text-center text-white mb-3">
            <div v-if="successMsg" class="fw-bolder">{{ successMsg }}</div>
        </div>
        <!-- Submit error message-->
        <div v-if="errorMsg" class="text-center text-danger mb-3">{{ errorMsg }}</div>
        <!-- Submit Button-->
        <div class="text-center">
            <button class="btn btn-primary btn-xl text-uppercase" id="submitButton" type="submit" :disabled="isDisabled">
                أرسل الرسالة
            </button>
        </div>
    </form>
</template>

<script>
import axios from "axios";

export default {
    props: ['grades'],

    data(){
        return{
            formData:{
                name: '',
                phone: '',
                email: '',
                birthdate: '',
                school: '',
                grade: '',
                message: '',
            },
            errors: [],
            successMsg: '',
            errorMsg: '',
        }
    },

    computed: {
        isDisabled() {
            return !this.formData.name || !this.formData.phone || !this.formData.email;
        }
    },

    methods:{
        submitForm() {
            this.errorMsg = this.successMsg = '';
            axios
                .post("/api/send-message", this.formData)
                .then((response) => {
                    if (response.data.success) {
                        this.errors = [];
                        this.successMsg = response.data.message;
                        this.formData = { name: "", phone: "", email: "",
                                          birthdate: "", school: "", grade: "",  message: "" };
                    } else {
                        this.errors = response.data.errors;
                    }
                })
                .catch((error) => {
                    this.errorMsg = response.data.message;
                });
        },
    },
}
</script>

<style>
.invalid-feedback {
    display: block !important;
}

.cus-select{
    padding: 20px !important;
}

.date-placeholder {
  position: absolute;
  right: 40px;
  top: 50%;
  transform: translateY(-50%);
  color: #ced4da;
  font-size: 1rem;
  font-weight: 400;
  pointer-events: none;
}

.date-input::-webkit-calendar-picker-indicator {
  opacity: 0.6;
}

.date-input {
  appearance: none;
}
</style>
