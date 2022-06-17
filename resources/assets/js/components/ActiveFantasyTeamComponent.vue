<template>
  <b-table
    responsive
    striped
    bordered
    large
    :items="activeTeams"
    :fields="fields"
  >
    <!-- A custom formatted column -->
    <template v-slot:cell(logo)="data">
      <b-img
        class="spark-nav-profile-photo"
        rounded="circle"
        :src="data.item.logo"
      />
    </template>
  </b-table>
</template>

<script>
export default {
  data() {
    return {
      activeTeams: [],
      error: "",
      loading: false,
      fields: [
        { key: "number", label: "" },
        { key: "logo", label: "" },
        { key: "name", label: "Fantasy Team" },
        { key: "user", label: "Owner" },
        { key: "created", label: "Joined" },
      ],
    };
  },
  created() {
    this.getActiveFantasyTeams();
  },
  methods: {
    getActiveFantasyTeams() {
      this.loading = true;
      axios
        .get("/league/active-fantasy-teams")
        .then((response) => {
          if (typeof response.data.error != "undefined") {
            this.error = response.data.error;
            this.loading = false;
          } else {
            this.activeTeams = response.data;
            this.loading = false;
            this.error = "";
          }
        })
        .catch((error) => {});
    },
  },
};
</script>
