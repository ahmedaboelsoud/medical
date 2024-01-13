<template>
  <div class="row">
    <div class="col-md-12 ">
      <div class="portlet box blue">
        <div class="portlet-title">
          <div class="caption">
            <i class="fa fa-gift"></i> {{ $t("doctors.doctor_data") }}
          </div>
          <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="javascript:;" class="remove"> </a>
          </div>
        </div>
        <div class="portlet-body form">

          <div class="row">
            
          <div class="col-md-4"  style="margin-top: 5px;">
           
                    
          <div class="form-group form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
            <img :src="imgURL || doctor.image" style="border-radius: 50% !important; width: 200px;" class="image">
            <form @submit="formSubmit" enctype="multipart/form-data">
                  <input type="file"  ref="file" class="form-control" v-on:change="onChange">
                  <button :disabled="upbtn === true" class="btn btn-primary btn-block">Upload</button>
              </form>


          </div>
         
          </div>
          

          </div>
          <hr/>
          <div class="form-body">
            <div class="form-group">


              
              <form @submit.prevent="getFormValues">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label class="control-label">{{ $t("doctors.doctor_name") }} <span style="color: red">*</span>
                      </label>
                      <input type="text" v-model="doctor.name" autocomplete="off" maxlength="100" class="form-control">
                      <div v-if="Array.isArray(errors.name) == true" class="error" role="alert">
                        <span style="color: red">{{ errors.name[0] }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label class="control-label"> {{ $t("doctors.email") }} : <span style="color: red">*</span></label>
                      <input type="text" v-model="doctor.email" required maxlength="100" autocomplete="off"
                        class="form-control">

                      <div v-if="Array.isArray(errors.email) == true" class="error" role="alert">
                        <span style="color: red">{{ errors.email[0] }}</span>
                      </div>

                    </div>
                  </div>
               
                
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                      <label class="control-label"> {{ $t("doctors.birthday") }} : <span
                          style="color: red">*</span></label>
                      <input class="form-control" v-model="doctor.birthday" type="date" />

                      <div v-if="Array.isArray(errors.birthday) == true" class="error" role="alert">
                        <span style="color: red"> {{ errors.birthday[0] }}</span>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                      <label class="control-label">{{ $t("doctors.status") }} : </label>
                      <select v-model="doctor.status" class="form-control">
                        <option value="inactive">inactive</option>
                        <option value="active">active</option>
                      </select>
                    </div>
                  </div>
                 
               
                </div>
                <div class="row">
                
                  <div class="col-md-12">
                    <div class="form-group form-group{{ $errors->has('brief') ? ' has-error' : '' }}">
                      <label class="control-label"> {{ $t("doctors.brief") }} : </label>
                  
                      <textarea style="resize: none;" v-model="doctor.brief"  class="form-control" ></textarea>

                      <div v-if="Array.isArray(errors.brief) == true" class="error" role="alert">
                        <span style="color: red"> {{ errors.brief[0] }}</span>
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
import axios from "axios";


export default {
  setup() {
    return { v$: useVuelidate() };
  },
 
  data() {
    return {
      upbtn:true,
     // id:this.doctor.id,
      name: '',
      imgURL:'',
      file: '',
      success: ''
    };
  },
  mounted() {
    this.$store.commit('doctors/REMOVE_ERRORS');
  },
  computed: {
    ...mapGetters("doctors", ["errors", "test", "total", "doctor", "code"]),
    ...mapGetters("loader", ["successAlert"]),
  },
  created() {
    document.title = this.$route.meta.title;
    this.loadItem();
    
  },
  methods: {

    onChange(e) {
      this.file = e.target.files[0];
      this.upbtn = false
    },
   

    formSubmit(e) {
      let self = this;
      e.preventDefault();
      let existingObj = this;
      self.upbtn =true;
     // existingObj.upbtn = true
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
          }
      }
      let data = new FormData();
      data.append('file', this.file);
      data.append("id",this.doctor.id);
      axios.post('/api/upload-doctor', data, config).then(
        res => {
          this.$refs.file.type='text';    
            this.$refs.file.type='file';  
          // console.log(this.file.name)
           this.$toast.success(this.$t('doctors.image-updated'), { position: "top" });
           self.upbtn = true
           this.imgURL = res.data.data;
        }
      ).catch(err => {
        existingObj.output = err;
      });
    },
    

    
    loadItem() {
      let { dispatch } = this.$store;
      let id = this.$route.params.id  
      dispatch("doctors/getDoctor",id).then(response => {   
        console.log("Got some data")
      }, error =>{
        this.$toast.error("Bad Request", { position: "top" });
        this.$router.push("/doctors");
      })
    },
    getFormValues(submitEvent) {
      let { dispatch } = this.$store;
      this.v$.$validate();
      if (!this.v$.$error) {
        console.log("form val sucess");
        dispatch("doctors/updateDoctor", this.doctor).then(() => {
          this.$toast.success(this.$t('doctors.doctor_updated'), { position: "top" });
          this.$router.push("/doctors");
        });
      } else {
        console.log("form val  feild");
      }
    },
  },
};
</script>