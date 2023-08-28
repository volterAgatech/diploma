<template>
  <langSwither />
  <div class="container-fluid">
    <form class="p-3 border" @submit.prevent>
      <div v-if="formState == 0" class="form-state">
        <div class="form-state"></div>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"
              >О Компании</a
            >
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              @click="companyDataValidate"
              aria-current="page"
              href="#"
              >Администратор</a
            >
          </li>
        </ul>
        <div class="mb-3">
          <label for="companyName" class="form-label">Имя Компании</label>
          <input
            type="text"
            class="form-control"
            id="companyName"
            aria-describedby="emailHelp"
            v-model="formReg.company.name_company"
            autocomplete="on"
            required
          />
        </div>
        <div class="mb-3">
          <label for="companyAdres" class="form-label">Адрес Комании</label>
          <input
            type="text"
            class="form-control"
            id="companyAdres"
            v-model="formReg.company.adress"
            autocomplete="on"
            required
          />
        </div>
        <div class="mb-3">
          <label for="companyPhone" type="password" class="form-label"
            >Телефон Комании</label
          >
          <input
            type="text"
            class="form-control"
            id="companyPhone"
            v-model="formReg.company.phone_number"
            autocomplete="on"
            required
          />
        </div>
        <div class="mb-3">
          <label for="companyInn">Инн Комании</label>
          <input
            type="text"
            class="form-control"
            id="companyInn"
            v-model="formReg.company.inn"
            autocomplete="on"
            required
          />
        </div>

        <div class="mb-3">
          <button class="btn btn-primary" @click="this.$router.push('/')">
            {{ $t("localeAuth") }}
          </button>
        </div>
        <button
          type="submit"
          class="btn btn-primary go"
          @click="companyDataValidate"
        >
          {{ $t("loacleBtnSubmite") }}
        </button>
      </div>
      <div class="form-state" v-if="formState == 1">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a
              class="nav-link"
              @click="formState--"
              aria-current="page"
              href="#"
              >О компании</a
            >
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"
              >Администратор</a
            >
          </li>
        </ul>
        <div class="mb-3">
          <label for="adminName" class="form-label">Имя Администратора</label>
          <input
            type="text"
            class="form-control"
            id="adminName"
            aria-describedby="emailHelp"
            v-model="formReg.admin.name"
            autocomplete="on"
            required
          />
        </div>
        <div class="mb-3">
          <label for="adminLogin" class="form-label">Логи Администратор</label>
          <input
            type="text"
            class="form-control"
            id="adminLogin"
            v-model="formReg.admin.login"
            autocomplete="on"
            required
          />
        </div>
        <div class="mb-3">
          <label for="adminPass1" type="password" class="form-label"
            >Пароль</label
          >
          <input
            type="password"
            class="form-control"
            id="adminPass1"
            v-model="formReg.admin.pass"
            autocomplete="on"
            required
          />
        </div>
        <div class="mb-3">
          <label for="adminPass1" type="passwor2" class="form-label"
            >Повторите Пароль</label
          >
          <input
            type="password"
            class="form-control"
            id="adminPass2"
            v-model="formReg.admin.pass2"
            autocomplete="on"
            required
          />
        </div>
        <div class="mb-3">
          <label for="inputDate">{{ $t("localeDateUser") }}</label>
          <input
            type="date"
            class="form-control"
            v-model="formReg.admin.birth"
            autocomplete="on"
            required
          />
        </div>

        <div class="mb-3">
          <button class="btn btn-primary" @click="this.$router.push('/')">
            {{ $t("localeAuth") }}
          </button>
        </div>
        <button type="submit" class="btn btn-primary" @click="registerUser">
          Создать Команию
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import langSwither from "../components/langSvither.vue";
import axios from "axios";
export default {
  components: { langSwither },
  data() {
    return {
      formState: 0,
      rePass:"",
      errorMsg: "",
      formReg: {
        company: {
          name_company: "",
          adress: "",
          phone_number: "",
          inn: "",
        },
        admin: {
          name: "",
          login: "",
          pass: "",
          birth: "",
        },
      },
    };
  },
  methods: {
    companyDataValidate() {
      if (
        this.formReg.company.name_company &&
        this.formReg.company.adress &&
        this.formReg.company.phone_number &&
        this.formReg.company.inn
      ) {
        this.formState++;
      }
    },
    isValidate() {
      return (
        this.formReg.company.name_company &&
        this.formReg.company.adress &&
        this.formReg.company.phone_number &&
        this.formReg.company.inn &&
        this.formReg.admin.name &&
        this.formReg.admin.pass &&
        this.formReg.admin.pass2 &&
        this.formReg.admin.login &&
        this.formReg.admin.birth
      );
    },
    registerUser() {
      if (this.isValidate()) {
        console.log("data from regist form", this.formReg);
        this.sendDataToApi();
      }
    },
    errorAlert(errorCode) {
      if (errorCode == "001") {
        alert("Компания уже существует или Логин уже занят");
      }else if(errorCode == "002"){
        alert("Пароли не совпадают");
      }else{
        alert("Компания создана");
      }
      //to do иначе придет обект его передать во vuex
    },
    sendDataToApi() {
      axios
        .post("http://apiks/api/", {
          action: "registCompanyAndAdmCompany",
          companyData: this.formReg.company,
          adminData: this.formReg.admin,
        })
        .then(
          (response) => (
            (this.errorMsg = response.data),
            console.log(response),
            this.errorAlert(this.errorMsg)
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