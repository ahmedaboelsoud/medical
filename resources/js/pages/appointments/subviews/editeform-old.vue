<template>
  <div v-if="successAlert" class="alert alert-success" role="alert">
    This is a success alert—check it out!
  </div>
  <form>
    <div class="form-group">
      <label for="exampleInputEmail1">Name</label>
      <input
        type="email"
        v-model="patient.title"
        class="form-control"
        id="exampleInputEmail1"
        aria-describedby="emailHelp"
        placeholder="title"
      />
      <div
        class="input-errors"
        v-for="error of v$.patient.title.$errors"
        :key="error.$uid"
      >
        <div class="error-msg">{{ error.$message }}</div>
      </div>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Author</label>
      <input
        type="email"
        v-model="patient.mobile"
        class="form-control"
        id="exampleInputEmail1"
        aria-describedby="emailHelp"
        placeholder="mobile"
      />
      <div
        class="input-errors"
        v-for="error of v$.patient.mobile.$errors"
        :key="error.$uid"
      >
        <div class="error-msg">{{ error.$message }}</div>
      </div>
    </div>

    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1" />
      <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="button" @click="SignUp()" class="btn btn-primary">
      Submit
    </button>
  </form>
</template>
<script>
import { useVuelidate } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import { mapGetters, mapActions } from "vuex";
export default {
 
  setup() {
    return { v$: useVuelidate() };
  },
  validations() {
    return {
      patient: {
        title: { required }, // Matches this.firstName
        mobile: { required }, // Matches this.firstName
      },
    };
  },
  computed: {
    ...mapGetters("patients", ["tags", "test", "total", "patient"]),
    ...mapGetters("loader", ["successAlert"]),
  },
  created() {
    this.loadItem();
  },
  methods: {
    loadItem() {
      let { dispatch } = this.$store;
      let id = this.$route.params.id;
      dispatch("patients/getPatient", id).then((res) => {});
    },
    SignUp() {
      let { dispatch } = this.$store;
      this.v$.$validate();
      var qu = {
        id: this.patient.id,
        title: this.patient.title,
        mobile: this.patient.mobile,
      };
      if (!this.v$.$error) {
        console.log("form val sucess");
        dispatch("patients/updatePatient", qu).then(() => {
          //this.loader = true;
        });
        // dispatch("tags/getTags", query).then((res) => {
        //   // this.loader = false;
        // });
      } else {
        console.log("form val  feild");
      }
    },
  },
};
</script>
