<template>
  <div>
    <div class="mb-5 mt-2 pb-5 mt-2 row">
      <div class="col-md-4 offset-md-4">
        <h4>
          <i class="fa fa-pen"></i> <span v-if="team">{{ team.name }}</span>
          <span v-else><i class="fa fa-spinner"></i></span>
        </h4>
        <team-form :team="team" v-if="team" @submit="submitted" :errors="errors"></team-form>
      </div>
    </div>
  </div>
</template>

<script>
  import TeamForm from './TeamForm';
  export default {
    components: { TeamForm },
    props: [],
    data() {
      return {
        team: null,
        errors: [],
      };
    },
    computed: {},
    methods: {
      loadTeam() {
        this.team_id = this.$router.currentRoute.params.team_id;
        axios
          .get(`/api/v1/teams/?team_id=${this.team_id}`)
          .then(results => {
            this.team = results.data;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load team');
          })
          .finally(f => {
            this.loading = false;
          });
      },
      submitted(form) {
        axios
          .put(`/api/v1/teams/${this.team_id}`, form)
          .then(results => {
            this.$root.$emit('sendMessage', 'Team updated', 'success');
            this.$router.push({
              name: 'team-single',
              params: {
                team_id: results.data.id,
              },
            });
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to update team!');
          });
      },
    },
    created() {
      this.loadTeam();
    },
  };
</script>
