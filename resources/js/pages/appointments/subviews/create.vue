<template>
     <div class="row">
      <div class="col-md-12 ">
          <div class="portlet box blue">
              <div class="portlet-title">
                  <div class="caption">
                      <i class="fa fa-gift"></i> {{ $t("patients.patient_data") }}</div>
                  <div class="tools">
                      <a href="javascript:;" class="collapse"> </a>
                      <a href="javascript:;" class="remove"> </a>
                  </div>
              </div>
              <div class="portlet-body form">
                  <div class="form-body">
                      <div class="form-group">
                          <form >
                     
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('title') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.patient_name") }}  <span style="color: red">*</span> </label>
                                          <input type="text"  v-model="tag.title" autocomplete="off"  required maxlength="100"  class="form-control">
  
                                          <!-- <div class="error"  v-for="error of v$.tag.title.$errors" >
                                            <div class="error-msg">{{ error.$message }}</div>
                                          </div>   -->
                                           <div v-if="Array.isArray(errors.title) == true" class="error" role="alert">
                                            <span style="color: red"> {{ errors.title[0] }} </span>
                                          </div>        
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('email') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.email") }}  :  <span style="color: red">*</span></label>
                                          <input type="text"  v-model="tag.email"  required maxlength="100" autocomplete="off"  class="form-control">
                                          
                                          <div v-if="Array.isArray(errors.email) == true" class="error" role="alert">
                                            <span style="color: red"> {{ errors.email[0] }}</span>
                                          </div>
                                       
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('mobile') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.mobile") }}   :  <span style="color: red">*</span></label>
                                          <input type="text" v-model="tag.mobile" autocomplete="off"  required  class="form-control">
                                          
                                          <div v-if="Array.isArray(errors.mobile) == true" class="error" role="alert">
                                            <span style="color: red">  {{ errors.mobile[0] }} </span>
                                          </div> 
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('job') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.job") }}  : </label>
                                          <input type="text" v-model="tag.job" autocomplete="off" maxlength="100"  class="form-control">
                                          
                                          <div v-if="Array.isArray(errors.job) == true" class="error" role="alert">
                                            <span style="color: red"> {{ errors.job[0] }}</span>
                                          </div>
                                        
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('birthday') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.birthday") }}  :  <span style="color: red">*</span></label>
                                          <input class="form-control" v-model="tag.birthday"    type="date"/>
                                          
                                          <div v-if="Array.isArray(errors.birthday) == true" class="error" role="alert">
                                            <span style="color: red">  {{ errors.birthday[0] }}</span>
                                          </div> 
                                        
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('adress') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.adress") }}   : </label>
                                          <input type="text" autocomplete="off" v-model="tag.adress"  class="form-control">
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('gender') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.gender") }}  : </label>
                                          <select   v-model="tag.gender" class="form-control">
                                              <option value="male">Male</option>
                                              <option value="female">Female</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('height') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.height") }}   : </label>
                                          <input type="number" v-model="tag.height" autocomplete="off"  class="form-control">
                                         
                                          <div v-if="Array.isArray(errors.height) == true" class="error" role="alert">
                                            <span style="color: red">  {{ errors.height[0] }}</span>
                                          </div>
                                        
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('weight') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.weight") }}     : </label>
                                          <input type="number" autocomplete="off" v-model="tag.weight"  class="form-control">
                                          
                                          <div v-if="Array.isArray(errors.weight) == true" class="error" role="alert">
                                            <span style="color: red"> {{ errors.weight[0] }}</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         <div class="form-actions right">
                                <button type="button" @click="SignUp()" class="btn blue" id="add_btn">
                                    <i class="fa fa-check"></i> {{ $t("site.add") }}   </button>
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
  

  import { mapGetters } from "vuex";

  export default {
    setup() {
      
    },
    data() {
      return {
        tag: {
          title: "",
          email: "",
          mobile: "",
          job: "",
          birthday: "",
          adress: "",
          gender: "",
          height: "",
          weight: "",
          message:'',
        },
      };
    },
    created() {
      document.title = this.$route.meta.title;
    },
    mounted() {
     this.$store.commit('patients/REMOVE_ERRORS');
    },  
    computed: {
      ...mapGetters("loader", ["successAlert"]),
      ...mapGetters("patients", ["message", "errors"]),
    },
    methods: {
      SignUp() {
        let { dispatch } = this.$store;
          dispatch("patients/addPatient", this.tag).then(() => {
            this.$toast.success(this.$t('patients.patient_added'),{ position:"top"});
            this.$router.push("/patients");
          });
      },
    },
  };
  </script>
  