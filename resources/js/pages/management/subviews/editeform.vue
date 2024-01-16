<template>
  
 <div v-if="loader">
   <LoaderComponents></LoaderComponents>
 </div>
   <div v-else class="row">
     <div class="col-md-12 ">
       <div class="portlet box blue">
         <div class="portlet-title">
           <div class="caption">
             <i class="fa fa-gift"></i> {{ $t("managements.managements") }}
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
                   <div class="col-md-6">
                     <div class="form-group form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                       <label class="control-label">{{ $t("doctors.doctor_name") }} <span style="color: red">*</span>
                       </label>
                       <input type="text" v-bind="tag.name" v-model="management.name" autocomplete="off" maxlength="100" class="form-control">
                       <div v-if="Array.isArray(errors.name) == true" class="error" role="alert">
                         <span style="color: red">{{ errors.name[0] }}</span>
                       </div>
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                       <label class="control-label"> {{ $t("doctors.email") }} : <span style="color: red">*</span></label>
                       <input type="text" v-model="management.email" required maxlength="100" autocomplete="off"
                         class="form-control">
                       <div v-if="Array.isArray(errors.email) == true" class="error" role="alert">
                         <span style="color: red">{{ errors.email[0] }}</span>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="col-md-4" v-for="item in models" :key="item">
                     <div class="form-group form-group" style=" border: 1px solid rgb(144, 186, 240);; background-color: #f3f4f6; padding:10px;">
                       <h5>{{ item }}</h5>
                       <div class="form-check"  v-for="map in maps" :key="index">
                         <input class="form-check-input"
                                 v-model="userPermission"
                                 :true-value="[]"
                                 :value="map+' '+item"
                                 :checked="userPermission.includes(map+' '+item) ? true: false"
                                 type="checkbox" 
                                 style="margin-right: 5px;" 
                                 >
                         <label class="form-check-label" for="flexCheckChecked">
                           {{ map }} {{ item }}
                         </label>
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
 import LoaderComponents from "../../../LoaderComponents.vue";
 import { required, email } from "@vuelidate/validators";
 import { mapGetters, mapActions } from "vuex";
 import axios from "axios";
 
 
 export default {
   components: {
     LoaderComponents,
   },
   setup() {
     return { v$: useVuelidate() };
   },
  
   data() {
     return {
       userPermission: [],
       filename:"filename",
       models:['patients', 'doctors'],
       maps:['create', 'read', 'update', 'delete'],
       tag: {
           name: "",
           email: "",
         },
     };
   },
   mounted() {
     this.$store.commit('managements/REMOVE_ERRORS');
   },
   computed: {
     ...mapGetters("managements", ["errors", "test", "total", "management", "code"]),
     ...mapGetters("loader", ["loader", "successAlert", "message"]),
   },
   created() {
     document.title = this.$route.meta.title;
     this.loadItem();
     
   },
   methods: {
     loadItem() {
       let { dispatch } = this.$store;
       let id = this.$route.params.id  
       dispatch("managements/getManagement",id).then(response => {   
         this.management.permissions.forEach(element => {
           this.userPermission.push(element.name);
         });
         console.log("Got some data")
       }, error =>{
         this.$toast.error("Bad Request", { position: "top" });
         this.$router.push("/management");
       })
     },
     getFormValues(submitEvent) {
       let { dispatch } = this.$store;
       this.v$.$validate();
       this.management.userPermission = this.userPermission
       console.log(this.management.userPermission)
       if (!this.v$.$error) {
         dispatch("managements/updateManagement",this.management).then(() => {
           this.$toast.success(this.$t('management.management_updated'), { position: "top" });
           this.$router.push("/management");
         });
       } else {
         console.log("form val  feild");
       }
     },
   },
 };
 </script>