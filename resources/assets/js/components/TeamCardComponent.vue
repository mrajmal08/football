<template>
  <div class="card mb-0">
    <div class="row no-gutters">
      <div class="col-4">
        <img
          :src="
            team.logo_url != null
              ? team.logo_url
              : 'https://cdn.head-fi.org/g/2283245_l.jpg'
          "
          class="img-fluid team-logo"
          alt=""
        >
      </div>
      <div class="col">
        <div class="card-block px-1">
          <h4 class="card-title m-0">{{ team.name }}</h4>
          <p class="card-text">{{ team.manager_name }}</p>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <b-table
        responsive
        striped
        hover
        class="no-table-margin"
        :items="team.players"
        :fields="table_columns"
      />
    </div>
  </div>
</template>

<style>
.no-table-margin table {
  margin-bottom: 0rem;
}
.no-gutters {
  max-height: 70px;
}
</style>

<script>
export default {
  props: {
    team: { required: false },
    isTeam: { type: Boolean, required: true },
  },
  data() {
    return {
      id: "",
      name: "",
      manager_name: "",
      players: [],
      table_columns: [
        { key: "position", label: "POS", class: "text-center" },
        { key: "name", label: "Player" },
        { key: "bye_week", label: "BYE", class: "text-center" },
      ],
      logo_url: "",
    };
  },
};
</script>
