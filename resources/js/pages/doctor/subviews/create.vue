<template>
     <div class="row">
      <div class="col-md-12 ">
          <div class="portlet box blue">
              <div class="portlet-title">
                  <div class="caption">
                      <i class="fa fa-gift"></i> {{ $t("doctors.doctor_data") }}</div>
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
                                      <div class="form-group form-group{{ $errors->has('name') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("doctors.doctor_name") }}  <span style="color: red">*</span> </label>
                                          <input type="text"  v-model="tag.name" autocomplete="off"  required maxlength="100"  class="form-control">
  
                                          <!-- <div class="error"  v-for="error of v$.tag.name.$errors" >
                                            <div class="error-msg">{{ error.$message }}</div>
                                          </div>   -->
                                           <div v-if="Array.isArray(errors.name) == true" class="error" role="alert">
                                            <span style="color: red"> {{ errors.name[0] }} </span>
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
                                      <div class="form-group form-group{{ $errors->has('birthday') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.birthday") }}  :  <span style="color: red">*</span></label>
                                          <input class="form-control" v-model="tag.birthday"    type="date"/>
                                          
                                          <div v-if="Array.isArray(errors.birthday) == true" class="error" role="alert">
                                            <span style="color: red">  {{ errors.birthday[0] }}</span>
                                          </div> 
                                        
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('password') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("site.password") }}   :  <span style="color: red">*</span></label>
                                          <input type="password" v-model="tag.password" autocomplete="off"  required  class="form-control">
                                          
                                          <div v-if="Array.isArray(errors.password) == true" class="error" role="alert">
                                            <span style="color: red">  {{ errors.password[0] }} </span>
                                          </div> 
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("site.password_confirmation") }}   :  <span style="color: red">*</span></label>
                                          <input type="password" v-model="tag.password_confirmation" autocomplete="off"  required  class="form-control">
                                          
                                          <div v-if="Array.isArray(errors.password_confirmation) == true" class="error" role="alert">
                                            <span style="color: red">  {{ errors.password_confirmation[0] }} </span>
                                          </div> 
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group form-group{{ $errors->has('status') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("doctors.status") }}  : </label>
                                          <select   v-model="tag.status" class="form-control">
                                              <option value="active">Active</option>
                                              <option value="inactive">InActive</option>
                                          </select>
                                      </div>
                                  </div>
                                  
                              </div>
                              <div class="row">
                                
                                 
                                  <div class="col-md-12">
                                      <div class="form-group form-group{{ $errors->has('brief') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("doctors.brief") }}   : </label>
        
                                          <textarea style="resize: none;" v-model="tag.brief" class="form-control" ></textarea>

                                          <div v-if="Array.isArray(errors.brief) == true" class="error" role="alert">
                                            <span style="color: red">  {{ errors.brief[0] }}</span>
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
          name: "",
          email: "",
          password: "",
          photo: "",
          birthday: "",
          brief: "",
          status: "",
          message:'',
        },
      };
    },
    created() {
      document.title = this.$route.meta.title;
    },
    mounted() {
     this.$store.commit('doctors/REMOVE_ERRORS');
    },  
    computed: {
      ...mapGetters("loader", ["successAlert"]),
      ...mapGetters("doctors", ["message", "errors"]),
    },
    methods: {
      SignUp() {
        let { dispatch } = this.$store;
          dispatch("doctors/addDoctor", this.tag).then(() => {
            this.$toast.success(this.$t('doctors.doctor_added'),{ position:"top"});
            this.$router.push("/doctors");
          });
      },
    },
  };
  </script>
  