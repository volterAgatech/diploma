<template>
  <header class="py-3">
    <div class="container-fluid">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page"><langSwither /></a>
        </li>
        <li class="nav-item dropdown">
          <span
            class="nav-link dropdown-toggle"
            data-bs-toggle="dropdown"
            role="button"
            aria-expanded="false"
            >Навигация</span
          >
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" @click="this.$router.push('/userProfile')">Профиль</a></li>
            <li><a class="dropdown-item" href="#" @click="this.$router.push('/user')">Задачи</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a
            class="nav-link disabled"
            href="#"
            tabindex="-1"
            aria-disabled="true"
            >{{ userName }}</a
          >
        </li>
        <li class="nav-item header-logoutbtn">
          <button type="button" class="btn btn-primary" @click="logOut">
            {{ $t("localeOut") }}
          </button>
        </li>
      </ul>
    </div>
  </header>
  <!-- <nav class="navbar navbar-dark bg-dark" aria-label="First navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">{{ userName }}</a>
      <button
        class="navbar-toggler collapsed"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarsExample01"
        aria-controls="navbarsExample01"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarsExample01" style="">
        <ul class="navbar-nav me-auto mb-2">
          <li class="nav-item">
            <langSwither />
          </li>
          <li class="nav-item">
            <a
              class="nav-link active"
              aria-current="page"
              @click="this.$router.push('profile')"
              >{{ $t("localeProfile") }}</a
            >
          </li>
          <li class="nav-item">
            <a
              class="nav-link active"
              aria-current="page"
              @click="this.$router.push('user')"
              >Задачи</a
            >
          </li>
          <li class="nav-item">
            <button type="button" class="btn btn-primary" @click="logOut">
              {{ $t("localeOut") }}
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav> -->
</template>

<script>
import langSwither from "./langSvither.vue";
export default {
  components: { langSwither },
  data() {
    return {
      userName: "",
    };
  },
  mounted() {
    this.getData();
    //location.reload();
  },
  methods: {
    getData() {
      this.userName = this.$store.getters.getAuthUserData.name;
      this.$router.push('/user');
    },
    logOut() {
      this.$store.commit("setAuth", false);
      this.$router.push("/");
    },
  },
};
</script>
<style>
li.nav-item.header-logoutbtn {
  margin-left: auto;
}
header.py-3 {
    background-color: ghostwhite;
}
a.nav-link.active {
    background-color: ghostwhite !important;
}
</style>