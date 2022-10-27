<template>
  <div>
    <nav-root></nav-root>

    <div class="mb-5 pb-5 row">
      <div class="col-md-8 offset-md-2 pt-4 row">
        <div class="col-md-12">
          <h3>
            Repositories
            <b-button
              :disabled="loading"
              v-if="$store.getters.user.github_token"
              @click="deleteToken"
              class="float-right"
              size="sm"
              variant="danger"
              >Delete Token</b-button
            >
          </h3>
        </div>
        <div v-if="loading" class="col-md-12">
          <p><i class="fa fa-spinner"></i> Loading..</p>
        </div>
        <div v-else-if="!$store.getters.user.github_token" class="col-md-12">
          <b-form @submit.prevent="saveToken">
            <b-form-group
              id="input-group-1"
              label="Github Token: *"
              label-for="github_token"
              description="Enter github token with permission to view repositories"
            >
              <b-form-input
                id="github_token"
                v-model="form.github_token"
                type="text"
                required
                placeholder=""
              ></b-form-input>
            </b-form-group>
            <field-error :solid="false" :errors="errors" field="github_token"></field-error>
            <input
              :disabled="!form.github_token || form.github_token.length < 5"
              type="submit"
              class="btn btn-sm btn-dark"
              value="Save Token"
            />
          </b-form>
        </div>
        <div v-else class="row">
          <div class="col-md-4" v-for="repo in repositories" v-bind:key="repo">
            <b-card :sub-title="repo.full_name" :title="repo.name" :footer="repo.private">
              <b-card-text>
                {{ repo.description }}
              </b-card-text>

              <b-card-text>
                <b-list-group>
                  <b-list-group-item>
                    <a :href="repo.html_url" target="_blank" rel="noopener noreferrer"
                      ><i class="fa-brands fa-github"></i
                    ></a>
                    View on GitHub</b-list-group-item
                  >
                  <b-list-group-item>Created {{ repo.created_at | relative }}</b-list-group-item>
                  <b-list-group-item>Updated {{ repo.updated_at | relative }}</b-list-group-item>
                  <b-list-group-item>Stars {{ repo.stargazers_count }}</b-list-group-item>
                  <b-list-group-item>Watchers {{ repo.watchers_count }}</b-list-group-item>
                  <b-list-group-item>Language {{ repo.language }}</b-list-group-item>
                  <b-list-group-item>Open issues {{ repo.open_issues }}</b-list-group-item>
                </b-list-group>
              </b-card-text>
            </b-card>
          </div>
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
          github_token: null,
        },
        repositories: [],
        errors: [],
        loading: true,
      };
    },
    mounted() {
      if (this.$store.getters.user.github_token) {
        this.loadRepositories();
      }
    },

    methods: {
      saveToken() {
        this.loading = true;
        axios
          .post(`/api/v1/Github/`, this.form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Github token saved!', 'success');
            this.github_token = null;
            this.loadRepositories();
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to save github token');
          })
          .finally(() => {
            this.loading = false;
          });
      },
      loadRepositories() {
        this.loading = true;
        axios
          .get(`/api/v1/Github/repositories/starred`)
          .then(results => {
            this.repositories = results.data;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load Starred Repositories');
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
