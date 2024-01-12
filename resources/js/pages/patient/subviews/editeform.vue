<template>
  <div class="row">
    <div class="col-md-12 ">
      <div class="portlet box blue">
        <div class="portlet-title">
          <div class="caption">
            <i class="fa fa-gift"></i> {{ $t("patients.patient_data") }}
          </div>
          <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="javascript:;" class="remove"> </a>
          </div>
        </div>
        <div class="portlet-body form">
          <div class="form-body">
            <div class="form-group">
              <form @submit.prevent="getFormValues">

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                      <label class="control-label">{{ $t("patients.patient_name") }} <span style="color: red">*</span>
                      </label>
                      <input type="text" v-model="patient.title" autocomplete="off" maxlength="100" class="form-control">
                      <div v-if="Array.isArray(errors.title) == true" class="error" role="alert">
                        <span style="color: red">{{ errors.title[0] }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label class="control-label"> {{ $t("patients.email") }} : <span style="color: red">*</span></label>
                      <input type="text" v-model="patient.email" required maxlength="100" autocomplete="off"
                        class="form-control">

                      <div v-if="Array.isArray(errors.email) == true" class="error" role="alert">
                        <span style="color: red">{{ errors.email[0] }}</span>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                      <label class="control-label"> {{ $t("patients.mobile") }} : <span
                          style="color: red">*</span></label>
                      <input type="text" v-model="patient.mobile" autocomplete="off" required class="form-control">

                      <div v-if="Array.isArray(errors.mobile) == true" class="error" role="alert">
                        <span style="color: red"> {{ errors.mobile[0] }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group form-group{{ $errors->has('job') ? ' has-error' : '' }}">
                      <label class="control-label"> {{ $t("patients.job") }} : </label>
                      <input type="text" v-model="patient.job" autocomplete="off" maxlength="100" class="form-control">

                      <div v-if="Array.isArray(errors.job) == true" class="error" role="alert">
                        <span style="color: red"> {{ errors.job[0] }}</span>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                      <label class="control-label"> {{ $t("patients.birthday") }} : <span
                          style="color: red">*</span></label>
                      <input class="form-control" v-model="patient.birthday" type="date" />

                      <div v-if="Array.isArray(errors.birthday) == true" class="error" role="alert">
                        <span style="color: red"> {{ errors.birthday[0] }}</span>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group{{ $errors->has('adress') ? ' has-error' : '' }}">
                      <label class="control-label">{{ $t("patients.adress") }} : </label>
                      <input type="text" autocomplete="off" v-model="patient.adress" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                      <label class="control-label">{{ $t("patients.gender") }} : </label>
                      <select v-model="patient.gender" class="form-control">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group{{ $errors->has('height') ? ' has-error' : '' }}">
                      <label class="control-label">{{ $t("patients.height") }} : </label>
                      <input type="number" v-model="patient.height" autocomplete="off" class="form-control">

                      <div v-if="Array.isArray(errors.height) == true" class="error" role="alert">
                        <span style="color: red"> {{ errors.height[0] }}</span>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group form-group{{ $errors->has('weight') ? ' has-error' : '' }}">
                      <label class="control-label"> {{ $t("patients.weight") }} : </label>
                      <input type="number" autocomplete="off" v-model="patient.weight" class="form-control">

                      <div v-if="Array.isArray(errors.weight) == true" class="error" role="alert">
                        <span style="color: red"> {{ errors.weight[0] }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-actions right">
                  <button type="submit" class="btn blue" id="add_btn">
                    <i class="fa fa-check"></i>{{ $t("site.edite") }} </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useVuelidate } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import { mapGetters, mapActions } from "vuex";
export default {
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    // return {
    //   stcode : this.code,

    // };
  },
  mounted() {
    this.$store.commit('patients/REMOVE_ERRORS');
  },
  computed: {
    ...mapGetters("patients", ["errors", "test", "total", "patient", "code"]),
    ...mapGetters("loader", ["successAlert"]),
  },
  created() {
    document.title = this.$route.meta.title;
    this.loadItem();
    
  },
  methods: {
    loadItem() {
      let { dispatch } = this.$store;
      let id = this.$route.params.id
      dispatch("patients/getPatient",id).then(response => {   
        console.log("Got some data")
      }, error =>{
        this.$toast.error("Bad Request", { position: "top" });
        this.$router.push("/patients");
      })
    },
    getFormValues(submitEvent) {
      let { dispatch } = this.$store;
      this.v$.$validate();
      if (!this.v$.$error) {
        console.log("form val sucess");
        dispatch("patients/updatePatient", this.patient).then(() => {
          this.$toast.success(this.$t('patients.patient_updated'), { position: "top" });
          this.$router.push("/patients");
        });
      } else {
        console.log("form val  feild");
      }
    },
  },
};
</script>