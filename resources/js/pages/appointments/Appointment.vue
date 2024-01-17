<style>
@import 'public/admin_assets/en/style.css';
</style> 

<template>
    <div class="row">
        <div class="col-md-12">
            <div class="tile shadow">
                <div class="row">
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <select  v-model="query.doctor" @input="filter" :disabled="validated ? '' : disabled" class="form-control dis">
                              <option value="">select doctor </option>
                              <option :value="doctor.id" v-for="(doctor, i) in doctors" :key="i"> {{ doctor.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select v-model="query.patient" @input="filter" :disabled="validated ? '' : disabled" class="form-control dis" >
                                <option value="">select patient </option>
                                <option :value="patient.id" v-for="(patient, i) in patients" :key="i"> {{ patient.title }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input  v-model="query.startdate" @input="filter" :disabled="validated ? '' : disabled" type="date" id="startdate" class="form-control dis" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input  v-model="query.enddate" @input="filter" :disabled="validated ? '' : disabled" type="date" id="enddate" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="btn-group pull-right" style="margin-top: 5px;;">
                        <router-link :to="{ name: 'appointment-creat', }" class="add_btn"  > <i class="fa fa-plus"></i> {{
                          $t("site.add_new") }}</router-link>
                      </div>
                    </div>
                </div><!-- end of row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                          <div v-if="loader">
            <LoaderComponents></LoaderComponents>
          </div>
          <div v-else>

            <table class="table table-striped table-bordered table-hover" id="sample_1">
              <thead>
                <tr>
                  <th> {{ $t("patients.doctor") }} </th>
                  <th> {{ $t("patients.patient") }} </th>
                  <th> {{ $t("patients.appdata") }} </th>
                  <th v-if="permissions.has('patient') || roles.has('manager')">{{ $t("site.action") }} </th>
                </tr>
              </thead>
              <tbody>
                <tr class="counttr" v-for="(tag, i) in test" :key="i">
                  <td class="_table_name">{{ tag.doctor }}</td>
                  <td class="_table_name">{{ tag.patient }}</td>
                  <td class="_table_name">{{ tag.appdata }}</td>
                  <td v-if="permissions.has('patient')">
                    <button type="button" @click="deletePatient(tag)" class="btn default btn-xs red" style="margin: 5px">
                      <i class="fa fa-trash"></i>
                      {{ $t("site.delete") }}
                    </button>
                    <router-link :to="{
                      name: 'editePatient',
                      params: {
                        id: tag.id,
                      },
                    }" class="btn default btn-xs black">
                      <i class="fa fa-eye"></i>
                      {{ $t("site.edite") }}
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <paginate :first-last-button="true" :hide-prev-next="true" :page-count="Math.ceil(total / 3)" :page-range="3"
            :force-page="force" :container-class="pagination" :prevText="'Prev'" :nextText="'Nexts'" :show-disabled="true"
            :click-handler="paginate">
          </paginate>

                        </div><!-- end of table responsive -->

                    </div><!-- end of col -->

                </div><!-- end of row -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

</template>
<script>
import _ from "lodash";
import axios from "axios";
import LoaderComponents from "../../LoaderComponents.vue";
import Paginate from "vuejs-paginate-next";
import { mapState, mapGetters, mapActions } from "vuex";
export default {
  components: {
    LoaderComponents,
    paginate: Paginate,
  },
  data() {
    return {
      validated:false,
      successAlert: true,
      counttr:1,
      patients:[],
      doctors:[],
      pagenum: this.$route.query.page,
      force: 1,
      roles: new Set(),
      permissions: new Set(),
      tags: {
        type: Object,
        default: null,
      },
      query: {
        patient: this.$route.query.patient || "",
        doctor: this.$route.query.doctor || "",
        startdate: this.$route.query.startdate || "",
        enddate: this.$route.query.enddate || "",
        //page:1,
      },
    };
  },

  // mounted() {
  //   this.getTags();
  // },
  mounted(){
    //alert("moutheds");
  },
  methods: {
    reInitialize: function () {
      var page = this.$route.query.page;
      if (page == null) {
        if (this.query != null) {
          this.query.title = "";
          this.query.mobile = "";
          this.query.page = 1;
        }
        this.force = 1
        this.$router.push({
          query: {"page":this.query.page},
        });
        this.loadItems();
      }
    },
    paginate(page) {
      this.query.page = page
      this.force = page
      this.$router.push({
        query: {"page":this.query.page},
      });
      this.loadItems(page);
    },
    deletePatient(item) {
      let { dispatch } = this.$store;
      let title = item.title;
      let id = item.id;
      this.$swal({
        title: "إعادة  المستخدم",
        text: `سوف يتم إعادة  المستخدم ${title}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "إعادة",
        cancelButtonText: "إغلاق",
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !this.$swal.isLoading(),
        preConfirm: () => {
          return dispatch("patients/remove", id)
            .then(() =>{
              var q =1;
              if(this.query.page > 1){
                if(this.test.length == 1){
                 // alert("INCONDTION");
                  q = this.query.page -1 
                  this.force = q;
                  this.query.page = q
                  this.$router.replace({
                     query: this.query.page,
                  });
                }
              }
              q = this.query.page 
              this.$toast.success(this.$t('patients.patient_deleted'),{ position:"top"});
              this.loadItems(q)
            }
          
             
            )
            .catch((err) => {
              this.$swal.showValidationMessage(
                `فشلت العملية: ${err.response.data.message}`
              );
            });
        },
      });
    },
    loadelements(){
    axios
        .get(`/api/appointments`)
        .then((response) => {
          this.patients = response.data.data.patients;
          this.doctors = response.data.data.doctors;
          this.loader = false;
          console.log(response.data.data.total);
        })
        .catch((errors) => {
          console.log(errors);
          this.loader = true;
        });
    },
    loadItems(page) {
      var current_page = this.$route.query.page;
      if (page == null && current_page != null) {
        this.force = parseInt(current_page, 10);
        this.query.page = current_page;
      }
      let { dispatch } = this.$store;
      var ahmed = {
        page: page,
        query: this.query,
      };
      dispatch("appointments/getAppointments", ahmed).then((res) => {
        this.validated =false;
        this.loader = false;
      });
      
    },

    filter: _.debounce(function (_value) {
      this.force = 1
      this.query.page = 1
      this.$router.push({
        query: {"page":this.query.page},
      });
      this.loadItems(1);
    },2000),
  },



  created() {
    document.title = this.$route.meta.title;
    this.loadItems();
    this.loadelements();
    console.log(window.user)
    console.log(window.user_roles)
    console.log(window.user_permissions)
    window.user_roles.forEach(r => {
      this.roles.add(r.name);
    });
    window.user_permissions.forEach(p => {
      this.permissions.add(p.name);
    });
  },
  mounted() {
  },
  computed: {
    ...mapGetters("appointments", ["tags", "test", "total"]),
    ...mapGetters("loader", ["loader", "successAlert", "message"]),
  },
  watch: {
    '$route': 'reInitialize',
    query: {
      deep: true,
      handler: function () {
        this.validated =true;
        //this.loader = true;
      },
    },
  },
   // watch: {
  //   query: {
  //     deep: true,
  //     handler: function () {
  //       this.filter();
  //     },
  //   },
  // },
};
</script>  