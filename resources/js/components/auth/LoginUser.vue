<template>
  <div class="container">
    <div class="mb-5 pb-5 row">
      <div class="col-md-4 offset-md-4">
        <h4 class="pt-3">Login</h4>

        <form
          class="py-3 row"
          @submit.prevent="submitForm"
          method="POST"
          v-if="!loading && !loaded"
        >
          <div class="col-md-12">
            <b-form-group id="input-group-2" label="Username: *" label-for="username">
              <b-form-input
                id="username"
                v-model="form.username"
                type="text"
                required
              ></b-form-input>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="username"></field-error>

            <b-form-group id="input-group-3" label="Password: *" label-for="password">
              <b-form-input
                id="password"
                v-model="form.password"
                type="password"
                required
              ></b-form-input>
            </b-form-group>

            <field-error :solid="false" :errors="errors" field="password"></field-error>

            <p class="py-3">
              <b-button id="loginbtn" size="sm" @click="submitForm" variant="success"
                >Login</b-button
              >
              <b-button
                class="float-right"
                size="sm"
                variant="link"
                @click="$router.push({ name: 'register' })"
                >Create Account</b-button
              >
              <b-button size="sm" variant="link" href="/password/reset">Reset</b-button>
            </p>
          </div>
        </form>

        <div v-if="loading">
          <p>
            <i class="fa fa-spinner"></i>
            Loading...
          </p>
        </div>

        <div v-if="loaded">
          <p>
            Welcome back.
            <br />

            <i class="fa fa-spinner"></i>
            Loading profile
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: [],
    data() {
      return {
        form: {
          username: null,
          password: null,
        },
        errors: [],
        loading: false,
        loaded: false,
      };
    },
    computed: {},
    methods: {
      submitForm() {
        this.loading = true;
        axios
          .post(`/login`, this.form)
          .then(results => {
            this.loaded = true;
            this.$root.$emit('loadUser');
            this.$root.$emit('sendMessage', 'Login Success', 'success');
            setTimeout(() => {
              let originalToPath = localStorage.getItem('original-to-path');
              if (originalToPath) {
                localStorage.removeItem('original-to-path');
                return (window.location = originalToPath);
              }
              window.location = '/home';
            }, 1000);
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to login!');
          })
          .finally(() => {
            this.loading = false;
          });
      },
    },
    created() {},
  };
</script>
