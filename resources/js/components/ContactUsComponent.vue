<template>
  <form @submit.prevent="submitForm" id="contactForm" dir="rtl">
        <div class="row align-items-stretch mb-5">
            <div class="col-md-6">
                <div class="form-group">
                    <input class="form-control" id="name" type="text" v-model="formData.name" placeholder="الاسم *"/>
                    <div v-if="errors.name" class="invalid-feedback" >{{ errors.name[0] }}</div>
                </div>
                <div class="form-group">
                    <!-- Email address input-->
                    <input class="form-control" id="email" type="email" v-model="formData.email" placeholder="البريد الالكتروني *" />
                    <div v-if="errors.email" class="invalid-feedback" >{{ errors.email[0] }}</div>
                </div>
                <div class="form-group mb-md-0">
                    <!-- Phone number input-->
                    <input class="form-control" id="phone" type="tel" v-model="formData.phone" placeholder="موبايل *" />
                    <div v-if="errors.phone" class="invalid-feedback" >{{ errors.phone[0] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group position-relative">
                    <input class="form-control date-input" id="birthdate" type="date" v-model="formData.birthdate"/>
                    <span class="date-placeholder" v-if="!formData.birthdate">تاريخ الميلاد *</span>
                    <div v-if="errors.birthdate" class="invalid-feedback">{{ errors.birthdate[0] }}</div>
                </div>

                <div class="form-group">
                    <input class="form-control" id="school" type="text" v-model="formData.school" placeholder="المدرسة" />
                </div>
                <div class="form-group mb-md-0">
                    <select class="form-control cus-select" id="grade" v-model="formData.grade"
                            :style="{ color: formData.grade == '0' || formData.grade === '' ? '#ced4da !important' : '#000' }">
                        <option value="0" disabled selected>الصف *</option>
                        <option v-for="grade in grades" :key="grade.id" :value="grade.id">{{ grade.name }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-textarea mb-md-0">
                    <!-- Message input-->
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
.cus-select{
    padding: 20px !important;
}
option:disabled {
    color: #ced4da !important; /* لون رمادي للخيار المعطل */
}

select {
    color: #000 !important; /* اللون الأسود الافتراضي عند اختيار أي خيار */
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

/* تغيير لون النص الافتراضي `MM/DD/YYYY` إلى الرمادي في جميع المتصفحات */
.date-input::-webkit-datetime-edit {
  color: #ced4da !important;
}

.date-input::-moz-placeholder {
  color: #ced4da !important;
}

.date-input:-ms-input-placeholder {
  color: #ced4da !important;
}

.date-input::-ms-input-placeholder {
  color: #ced4da !important;
}
</style>
