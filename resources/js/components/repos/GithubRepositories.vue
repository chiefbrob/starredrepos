<template>
  <div>
    <nav-root></nav-root>

    <div class="mb-5 pb-5 row">
      <div class="col-md-8 offset-md-2 pt-4 row">
        <div class="col-md-12">
          <h3>GitHub <span :v-text="form.token ? 'Starred Repositories' : 'Token'"></span></h3>
        </div>
        <div v-if="loading" class="col-md-12">
          <p><i class="fa fa-spinner"></i> Loading..</p>
        </div>
        <div v-else class="col-md-12">
          <b-form @submit.prevent="saveToken">
            <b-form-group
              id="input-group-1"
              label="Github Token: *"
              label-for="token"
              description="Enter github token with permission to view repositories"
            >
              <b-form-input
                id="token"
                v-model="form.token"
                type="password"
                required
                placeholder=""
              ></b-form-input>
            </b-form-group>
            <field-error :solid="false" :errors="errors" field="token"></field-error>
            <input type="submit" class="btn btn-sm btn-dark" value="Save Token" />
          </b-form>
        </div>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          token: null,
        },
        errors: [],
        loading: true,
      };
    },
    mounted() {
      this.loadToken();
    },

    methods: {
      saveToken() {
        console.log(this.form);
        //post
      },
      loadToken() {
        axios
          .get(`/api/v1/repositories`)
          .then(results => {
            if (results.data) {
              this.token = results.data.data;
            }
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load Repositories');
          })
          .finally(() => {
            this.loading = false;
          });
      },
      deleteToken() {
        //delete
      },
    },
  };
</script>
