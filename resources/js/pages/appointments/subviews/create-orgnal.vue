<template>
 
  

  <div v-if="successAlert" class="alert alert-success" role="alert">
    This is a success alert—check it out!
  </div>
  <form>
    <div class="form-group">
      <label for="exampleInputEmail1">Name</label>
      <input
        type="email"
        v-model="tag.title"
        class="form-control"
        id="exampleInputEmail1"
        aria-describedby="emailHelp"
        placeholder="title"
      />
      <div
        class="input-errors"
        v-for="error of v$.tag.title.$errors"
        :key="error.$uid"
      >
        <div class="error-msg">{{ error.$message }}</div>
      </div>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">email</label>
      <input
        type="email"
        v-model="tag.email"
        class="form-control"
        id="exampleInputEmail1"
        aria-describedby="emailHelp"
        placeholder="email"
      />
      <div
        class="input-errors"
        v-for="error of v$.tag.email.$errors"
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
import { mapGetters } from "vuex";
export default {
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      arr2: ["The title must not be greater than 5 characters."],
      arr: ["Vue js", "React Js", "Angular Js", "Express Js", "Node Js"],
      firstElement: "wwwwwwwwwwwww",
      tag: {
        title: "",
        email: "",
      },
    };
  },
  validations() {
    return {
      tag: {
        title: { required }, // Matches this.firstName
        email: { required }, // Matches this.firstName
      },
    };
  },
  mounted() {
    this.firstElement = this.arr[1];
  },
  computed: {
    ...mapGetters("loader", ["successAlert"]),
    ...mapGetters("tags", ["message", "errors"]),
  },
  methods: {
    SignUp() {
      let { dispatch } = this.$store;
      this.v$.$validate();
      if (!this.v$.$error) {
        console.log("form val sucess");
        dispatch("patients/addPatient", this.tag).then(() => {
          // this.$router.push("/");
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
