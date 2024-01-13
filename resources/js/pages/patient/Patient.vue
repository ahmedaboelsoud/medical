<style>
@import 'public/admin_assets/en/style.css';
</style> 
<template>
  <div class="row">
    <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet box blue-hoki">
        <div class="portlet-title">
          <div class="caption">
            <i class="fa fa-globe"></i>{{ $t("patients.patients") }}
          </div>
          <div class="btn-group pull-right" style="margin-top: 5px;">
            <router-link :to="{ name: 'patient-creat', }" class="add_btn"> <i class="fa fa-plus"></i> {{
              $t("site.add_new") }}</router-link>
          </div>
        </div>

        <div class="portlet-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input class="form-control" type="text" id="customers_search_query" placeholder="title"
                  v-model="query.title" @input="filter" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input class="form-control" type="text" id="customers_search_query" placeholder="mobile"
                  v-model="query.mobile" @input="filter" />
              </div>
            </div>
          </div>
          <div v-if="loader">
            <LoaderComponents></LoaderComponents>
          </div>
          <div v-else>

            <table class="table table-striped table-bordered table-hover" id="sample_1">
              <thead>
                <tr>
                  <th> {{ $t("patients.title") }} </th>
                  <th> {{ $t("patients.mobile") }} </th>
                  <th> {{ $t("patients.email") }} </th>
                  <th v-if="permissions.has('patient') || roles.has('manager')">{{ $t("site.action") }} </th>
                </tr>
              </thead>
              <tbody>
                <tr class="counttr" v-for="(tag, i) in test" :key="i">
                  <td class="_table_name">{{ tag.title }}</td>
                  <td class="_table_name">{{ tag.mobile }}</td>
                  <td class="_table_name">{{ tag.email }}</td>
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


        </div>
      </div>
    </div>
  </div>
</template>
<script>
import _ from "lodash";
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
      successAlert: true,
      counttr:1,
      pagenum: this.$route.query.page,
      force: 1,
      // loader: true,
      roles: new Set(),
      permissions: new Set(),
      leg: 0,
      ccc: 10,
      tagName: "",
      tags: {
        type: Object,
        default: null,
      },
      query: {
        //general: this.$route.query.general || this.$route.query.query || "",
        title: this.$route.query.title || "",
        mobile: this.$route.query.mobile || "",
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
      // this.usernameinput = 'fsdfsdf';
      var page = this.$route.query.page;
      if (page == null) {
        //alert("reint");
        if (this.query != null) {
          this.query.title = "";
          this.query.mobile = "";
          this.query.page = 1;
        }
        this.force = 1
        this.$router.replace({
          query: this.query,
        });
        this.loadItems();
      }
    },
    // ...mapActions("tags", ["getTags"]),
    paginate(page) {
     // alert("poagainton");
      this.query.page = page
      this.force = page
      this.$router.replace({
        query: this.query,
      });
      this.loadItems(page);
      // var price = document.getElementsByClassName("page-item");
      // for (var i = 0; i < price.length; i++) {
      //       price[i].classList.remove('active')
      // }
      ///price[page].classList.add("active");
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
                     query: this.query,
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

    loadItems(page) {
     // alert("loaditem");
      var current_page = this.$route.query.page;

      if (page == null && current_page != null) {

        this.force = parseInt(current_page, 10);
        this.query.page = current_page;
       // alert("INLOADITEM  adasdasd " +this.force)
      }




      let { dispatch } = this.$store;
      // this.$route.query.page || page,
      var ahmed = {
        page: page,
        query: this.query,
      };

      // if (current_page == null) {
      //   query.query.page = 1;
      // }


      //var page = this.$route.query.page || 1;
     // alert("INLOADITEM   " +this.force)
      dispatch("patients/getPatients", ahmed).then((res) => {
        var price = document.getElementsByClassName("page-item");

        // if(current_page == null){
        //  for (var i = 0; i < price.length; i++) {
        //   //  price[i].classList.remove('active')
        //   }
        //  //  price[1].classList.add("active");
  
        // }else{
        //   for (var i = 0; i < price.length; i++) {
        //     price[i].classList.remove('active')
        //     console.log(i);
        //   }
        //   //console.log("Page" + (price.length - 2));
        //   if(page == (price.length -2)){
        //    // price[0].classList.remove("disabled");
        //     price[4].classList.add("disabled");
        //   }
        // price[page].classList.add("active");

        //  }
        this.loader = false;

      });



      //price[current_page].classList.add("active");




      // axios
      //   .post(`/api/bookstest?page=${page}`, this.query)
      //   .then((response) => {
      //     this.tags = response.data.data.data;
      //     this.loader = false;
      //     this.leg = response.data.data.total;
      //     console.log(response.data.data.total);
      //   })
      //   .catch((errors) => {
      //     console.log(errors);
      //     this.loader = true;
      //   });
    },

    filter: _.debounce(function (_value) {
      //alert("filter");
      this.force = 1
      this.query.page = 1
      this.$router.replace({
        query: this.query,
      });
      this.loadItems(1);
    }, 2000),
  },



  created() {
    //alert("created");
    // this.$watch(
    //   () => this.$route.params,
    //   () => {
    //     this.loadItems()
    //   },
    //   { immediate: true }
    // ),
    document.title = this.$route.meta.title;
    this.loadItems();
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
    ...mapGetters("patients", ["tags", "test", "total"]),
    ...mapGetters("loader", ["loader", "successAlert", "message"]),
  },
  watch: {
    // call method if the route changes
    '$route': 'reInitialize'
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