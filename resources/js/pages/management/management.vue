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
            <i class="fa fa-globe"></i>{{ $t("management.management") }}
          </div>
          <div class="btn-group pull-right" style="margin-top: 5px;">
            <router-link :to="{ name: 'management-creat', }" class="add_btn"> <i class="fa fa-plus"></i> {{
              $t("site.add_new") }}</router-link>
          </div>
        </div>
        <div class="portlet-body">
          <div v-if="loader">
            <LoaderComponents></LoaderComponents>
          </div>
          <div v-else>

            <table class="table table-striped table-bordered table-hover" id="sample_1">
              <thead>
                <tr>
                  <th> {{ $t("patients.name") }} </th>
                  <th> {{ $t("patients.email") }} </th>
                  <th v-if="permissions.has('read users') || roles.has('manager')">{{ $t("site.action") }} </th>
                </tr>
              </thead>
              <tbody>
                <tr class="counttr" v-for="(tag, i) in test" :key="i">
                  <td class="_table_name">{{ tag.name }}</td>
                  <td class="_table_name">{{ tag.email }}</td>
                  <td v-if="permissions.has('read users')">
                    <button type="button" @click="deleteManagement(tag)" class="btn default btn-xs red" style="margin: 5px">
                      <i class="fa fa-trash"></i>
                      {{ $t("site.delete") }}
                    </button>
                    <router-link :to="{
                      name: 'editeManagement',
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
      tags: {
        type: Object,
        default: null,
      },
      query: {
        //page:1,
      },
    };
  },

  // mounted() {
  //   this.getTags();
  // },
  mounted(){
   // alert("moutheds");
  },
  methods: {
    reInitialize: function () {
      var page = this.$route.query.page;
      if (page == null) {
       // alert("reint");
        if (this.query != null) {
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
    deleteManagement(item) {
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
          return dispatch("managements/remove", id)
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
        //alert("INLOADITEM  adasdasd " +this.force)
      }
      let { dispatch } = this.$store;
      // this.$route.query.page || page,
      var ahmed = {
        page: page,
        query: this.query,
      };
      dispatch("managements/getManagements", ahmed).then((res) => {
        this.loader = false;
      });
    },
  },



  created() {
  //  alert("created");
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
    ...mapGetters("managements", ["tags", "test", "total"]),
    ...mapGetters("loader", ["loader", "successAlert", "message"]),
  },
  watch: {
    // call method if the route changes
    '$route': 'reInitialize'
  },
};
</script>  