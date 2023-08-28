<template>
  <div class="container-fluid">
    <h1>{{ $t("localeProfileh1") }}</h1>
    <form class="p-3 border" @submit.prevent>
      <h2>{{ $t("localeProfileh2") }}</h2>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">{{
          $t("localeNameUser")
        }}</label>
        <input
          type="text"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          v-model="profileData.name"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">{{
          $t("localeLoginUser")
        }}</label>
        <input
          type="text"
          class="form-control"
          id="exampleInputPassword1"
          v-model="profileData.login"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" type="password" class="form-label">{{
          $t("localePassUser")
        }}</label>
        <input
          type="text"
          class="form-control"
          id="exampleInputPassword1"
          v-model="profileData.pass"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" type="password" class="form-label">Роль</label>
        <input
          type="text"
          class="form-control"
          id="exampleInputPassword1"
          v-model="profileData.text_rule"
        />
      </div>
      <div class="mb-3">
        <label for="inputDate">{{ $t("localeDateUser") }}</label>
        <input type="date" class="form-control" v-model="profileData.birth" />
      </div>
      <button type="submit" class="btn btn-primary" @click="changeUserData">
        {{ $t("loacleBtnSubmite") }}
      </button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      profileData: {},
    };
  },
  mounted() {
    this.getUserData();
    //   console.log(this.profileData)
  },
  methods: {
    getUserData() {
      this.profileData = this.$store.getters.getAuthUserData;
      //console.log(this.$store.getters.getAuthUserData);
      console.log(this.$store.state.userData);
    },
    changeUserData() {
      //this.$store.dispatch('setChangeUserRegistData',this.profileData)
      //обновить данные формы
      console.log(this.profileData);
      axios
        .post("http://apiks/api/", {
          action: "updateTableRow",
          selectedTableName: "users",
          rowId: this.profileData.id,
          updateData: this.profileData,
        })
        .then(
          (response) => console.log(response),
          this.$store.commit("setUserData", this.response),
          alert("Личные данные успешно изменены")
        );
      this.$store.dispatch('setChangeUserRegistData',this.profileData)
      this.getUserData();
    },
  },
};
</script>

<style>
</style>