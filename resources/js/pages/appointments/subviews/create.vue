<template>
  <div class="row">
   <div class="col-md-12 ">
       <div class="portlet box blue">
           <div class="portlet-title">
               <div class="caption">
                   <i class="fa fa-gift"></i> {{ $t("appointments.appointments_data") }}</div>
               <div class="tools">
                   <a href="javascript:;" class="collapse"> </a>
                   <a href="javascript:;" class="remove"> </a>
               </div>
           </div>
           <div class="portlet-body form">
               <div class="form-body">
                   <div class="form-group">
                           <form  @submit="formSubmit" >
                              <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group form-group" >

                                        <select  v-model="query.doctor_id"   :disabled="validated ? '' : disabled" class="form-control dis">
                                          <option  value="">select doctor </option>
                                          <option :value="doctor.id" v-for="(doctor, i) in doctors" :key="i"> {{ doctor.name }}</option>
                                        </select>

                                        <div v-if="Array.isArray(errors.title) == true" class="error" role="alert">
                                         <span style="color: red"> {{ errors.title[0] }} </span>
                                       </div>        
                                   </div>
                                </div>
                                <div class="col-md-4">
                                   <div class="form-group form-group" >
                                       <input class="form-control" :disabled="validated ? '' : disabled" v-model="query.appdata"   type="date"/>
                                       <div v-if="Array.isArray(errors.appdata) == true" class="error" role="alert">
                                         <span style="color: red">  {{ errors.appdata[0] }}</span>
                                       </div> 
                                     
                                   </div>
                                </div>
                                <div class="col-md-4"> 
                                   
                                 <div class="form-group form-group">
                                  <button :disabled="upbtn === true" class="btn btn-default btn-block"><i class="fa fa-search"></i> </button>
                                 </div>
                                </div>
                              </div>  
                            </form>
                            <form>

                            <div v-if="loader">
                             <LoaderComponents></LoaderComponents>
                            </div>
                            <div v-else>
                            <table class="table table-bordered">
                             <thead style="background-color: #F5F5F5">
                               <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Patient Name</th>
                               </tr>
                             </thead>
                             <tbody>
                               <tr class="counttr" v-for="(tag, i) in patient_res" :key="i">
                                 <td scope="col">{{ i+1 }}</td>
                                 <td scope="col">{{tag.patient}}</td>
                               </tr>
                             </tbody>
                            </table> 
                            </div>



                            <div class="row">
                               <div class="col-md-12">
                                   <div class="form-group form-group{{ $errors->has('title') ? ' has-error' : '' }}" >
                                       <select v-model="query.patient_id"  :disabled="validated ? '' : disabled" class="form-control dis" >
                                         <option value="">select patient </option>
                                         <option :value="patient.id" v-for="(patient, i) in patients" :key="i"> {{ patient.title }}</option>
                                       </select>  
           
                                        <div v-if="Array.isArray(errors.title) == true" class="error" role="alert">
                                         <span style="color: red"> {{ errors.title[0] }} </span>
                                       </div>        
                                   </div>
                               </div>
                               
                            </div>
                         
                            <div class="row">
                               <div class="col-md-12">
                                   <div class="form-group form-group{{ $errors->has('price') ? ' has-error' : '' }}" >
                                       <label class="control-label"> {{ $t("appointments.price") }}     : </label>
                                       <input type="number" autocomplete="off" v-model="query.price"  class="form-control">
                                       
                                       <div v-if="Array.isArray(errors.price) == true" class="error" role="alert">
                                         <span style="color: red"> {{ errors.price[0] }}</span>
                                       </div>
                                   </div>
                               </div>
                            </div>

                           
                          <button type="button" @click="SignUp()" class="btn blue" id="add_btn">
                            <i class="fa fa-check"></i> {{ $t("site.add") }} </button>
                          </form>
                          <br>
                         
                          
                       
                   </div>
               </div>
           </div>
       </div>
   </div> 
</div>
</template>
<script>

import _ from "lodash";
import { mapGetters } from "vuex";
import LoaderComponents from "../../../LoaderComponents.vue";
import axios from "axios";
export default {
  components: {
    LoaderComponents,
  },
 data() {
   return {
     patient_res:"",
     doctors:[],
     validated:false,
     query: {
       patient_id:"", 
       doctor_id: "",
       appdata:"",
       price:"",
     //page:1,
      },
   };
 },
 created() {
   document.title = this.$route.meta.title;
   this.loadelements();
 },
 mounted() {
  this.$store.commit('patients/REMOVE_ERRORS');
 },  
 computed: {
   ...mapGetters("loader", ["loader", "successAlert", "message"]),
   ...mapGetters("patients", ["message", "errors"]),
 },
 methods: {
   loadelements(){
      axios
       .get(`/api/appointments`)
       .then((response) => {
       this.patients = response.data.data.patients;
       this.doctors = response.data.data.doctors;
       console.log(response.data.data.total);
     })
     .catch((errors) => {
       console.log(errors);
     });
   },
   formSubmit(e) {
    e.preventDefault();
    let { dispatch } = this.$store;
    this.validated = true
    dispatch('loader/startLoader', {}, { root: true })
    const config = {
      headers: {
        'content-type': 'multipart/form-data'
        }
    }
    axios
       .post(`/api/appointments/appointmentsDoctors`,this.query)
       .then((resess) => {
        this.patient_res = resess.data.data
        dispatch('loader/stopLoader', {}, { root: true })
        this.validated = false
     })
     .catch((errors) => {
       console.log(errors);
     });
    },
    
   SignUp() {
      let { dispatch } = this.$store;
      dispatch("appointments/addAppointment", this.query).then(() => {
         this.$toast.success(this.$t('appointments.appointment_added'),{ position:"top"});
         this.$router.push("/appointments");
       });
   },
 },
};
</script>
