<template>
  <langSwither />

  <div class="container-fluid">
    <form class="p-3 border" @submit.prevent>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">{{
          $t("localeLoginUser")
        }}</label>
        <input
          type="text"
          class="form-control"
          id="login-input"
          v-model="formAuth.userLogin"
          autocomplete="on"
          required
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" type="password" class="form-label">{{
          $t("localePassUser")
        }}</label>
        <input
          type="password"
          class="form-control"
          id="password-input"
          v-model="formAuth.userPass"
          autocomplete="on"
          required
        />
      </div>
      <div class="mb-3">
        <button class="btn btn-primary" @click="this.$router.push('regist')">
          {{ $t("localeRegist") }}
        </button>
      </div>
      <button type="submit" class="btn btn-primary" @click="aithorizationUser">
        {{ $t("loacleBtnSubmite") }}
      </button>
    </form>
  </div>
</template>

<script>
import langSwither from "../components/langSvither.vue";
import axios from "axios";
export default {
  components: {
    langSwither,
  },
  data() {
    return {
      responseUserData: {},
      responseCompanyData: {},
      formAuth: {
        userLogin: "",
        userPass: "",
      },
    };
  },
  mounted() {},
  methods: {
    isValidate() {
      return this.formAuth.userLogin && this.formAuth.userPass;
    },
    checkResponsForErrorOrData(errorCode) {
      if (errorCode == 0) {
        alert("Неверный логин или пароль");
      } else {
        //запись данных об пользователев store
        this.$store.dispatch("setUserDataAction", this.responseUserData);
        this.$store.dispatch("setUserRuleAction", this.responseUserData);
        //запись данных о компании пользователя в store
        this.$store.dispatch('setCompanyDataAction',this.responseCompanyData)
        //this.$store.commit("setUserData", this.responseUserData);
        this.$store.commit("setAuth", true);
        this.$router.push("/home");
        //console.log(this.$store.state.userRule);
        //подмена router
      }
    },
    aithorizationUser() {
      if (this.isValidate()) {
        this.findUserAndAuth();
      }
    },
    findUserAndAuth() {
      axios
        .post("http://apiks/api/", {
          action: "authorizationUser",
          authForm: this.formAuth,
        })
        .then(
          (response) => (
            ((this.responseUserData = response.data.userInfo),
            (this.responseCompanyData = response.data.companyInfo)),
            console.log(this.responseUserData),
            //вызвать функцию проверки даты
            this.checkResponsForErrorOrData(this.responseUserData)
            //
          )
        );
    },
  },
};
</script>

<style scoped>
.container-fluid {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>