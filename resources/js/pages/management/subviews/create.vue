<template>
     <div class="row">
      <div class="col-md-12 ">
          <div class="portlet box blue">
              <div class="portlet-title">
                  <div class="caption">
                      <i class="fa fa-gift"></i> {{ $t("management.management") }}</div>
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
                                  <div class="col-md-6">
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
                                  <div class="col-md-6">
                                      <div class="form-group form-group{{ $errors->has('email') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("patients.email") }}  :  <span style="color: red">*</span></label>
                                          <input type="text"  v-model="tag.email"  required maxlength="100" autocomplete="off"  class="form-control">
                                          
                                          <div v-if="Array.isArray(errors.email) == true" class="error" role="alert">
                                            <span style="color: red"> {{ errors.email[0] }}</span>
                                          </div>
                                       
                                      </div>
                                  </div>
                                
                                  <div class="col-md-6">
                                      <div class="form-group form-group{{ $errors->has('password') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("site.password") }}   :  <span style="color: red">*</span></label>
                                          <input type="password" v-model="tag.password" autocomplete="off"  required  class="form-control">
                                          
                                          <div v-if="Array.isArray(errors.password) == true" class="error" role="alert">
                                            <span style="color: red">  {{ errors.password[0] }} </span>
                                          </div> 
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}" >
                                          <label class="control-label"> {{ $t("site.password_confirmation") }}   :  <span style="color: red">*</span></label>
                                          <input type="password" v-model="tag.password_confirmation" autocomplete="off"  required  class="form-control">
                                          
                                          <div v-if="Array.isArray(errors.password_confirmation) == true" class="error" role="alert">
                                            <span style="color: red">  {{ errors.password_confirmation[0] }} </span>
                                          </div> 
                                      </div>
                                  </div>
                                 


                                  
                                  
                              </div>
                              <div class="row">
                                <div class="col-md-4" v-for="item in models" :key="item">
                                  <div class="form-group form-group" style=" border: 1px solid rgb(144, 186, 240);; background-color: #f3f4f6; padding:10px;">
                                    <h5>{{ item }}</h5>
                                    <div class="form-check"  v-for="map in maps" :key="index">
                                      <input class="form-check-input" v-model="tag.userPermission" :true-value="[]" :value="map+' '+item" style="margin-right: 5px;" type="checkbox"  >
                                      <label class="form-check-label" for="flexCheckChecked">
                                        {{ map }} {{ item }}
                                      </label>
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
        models:['patients', 'doctors'],
        maps:['create', 'read', 'update', 'delete'],
        tag: {
          userPermission: [],
          name: "",
          email: "",
          password: "",
          password_confirmation: "",
          message:'',
        },
      };
    },
    created() {
      document.title = this.$route.meta.title;
    },
    mounted() {
     this.$store.commit('managements/REMOVE_ERRORS');
    },  
    computed: {
      ...mapGetters("loader", ["successAlert"]),
      ...mapGetters("managements", ["message", "errors"]),
    },
    methods: {
      SignUp() {
        let { dispatch } = this.$store;

          dispatch("managements/addManagement", this.tag).then(() => {
            this.$toast.success(this.$t('users.user_added'),{ position:"top"});
            this.$router.push("/management");
          });
      },
    },
  };
  </script>
  