<template>
  <button
    type="button"
    class="btn btn-primary btn-success"
    data-bs-toggle="modal"
    data-bs-target="#addNewUser"
  >
    Add
  </button>

  <div
    class="modal fade"
    id="addNewUser"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Добавить Сотрудника
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent>
            <div
              class="mb-3"
              v-for="col in data.formLableNamesObj"
              v-bind:key="col"
              v-bind:col="col"
            >
              <label for="recipient-name" class="col-form-label">
                {{ col.lable }}</label
              >
              <input
                v-if="col.vmodelName == 'birth'"
                v-model="data.formDataList[col.vmodelName]"
                type="date"
                name="first_name"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
              <input
                v-else
                v-model="data.formDataList[col.vmodelName]"
                type="text"
                name="first_name"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
            </div>
          </form>
        </div>
        <div class="modal-footer addRowBtn">
          <button
            @click="addRow(data.formDataList)"
            class="btn btn-primary btn-success"
            type="submit"
            data-bs-dismiss="modalModeIfValidate"
          >
            Add
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
            ref="Close"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  emits: ["reloadTableEmit"],
  components: {},
  data() {
    return {
      data: {
        formLableNamesObj: [
          { lable: "Имя", vmodelName: "name" },
          { lable: "Логин", vmodelName: "login" },
          { lable: "Пароль", vmodelName: "pass" },
          { lable: "Дата Рождения", vmodelName: "birth" },
          { lable: "Роль в Компании", vmodelName: "text_rule" },
        ],
        formDataList: {},
      },
    };
  },
  methods: {
    checkResponsForErrorOrData(errorCode) {
      if (errorCode == "001") {
        alert("Пользователь уже существует");
      } else {
        alert("Пользователь создан");
        this.$refs.Close.click();
        this.$emit("reloadTableEmit")
      }
    },
    addRow(formData) {
      //ролучил данные из формы
      console.log(formData);
      // console.log(this.$store.getters.getUserCompanyData);
      // //to do отправить запрос на добавление вернуть отвте ошибку или успех
      if (
        !this.data.formDataList.name ||
        !this.data.formDataList.login ||
        !this.data.formDataList.pass ||
        !this.data.formDataList.birth ||
        !this.data.formDataList.text_rule
      ) {
        alert("Заполните Форму");
      } else if(!/^[a-zA-Z]*$/.test(this.data.formDataList.login)){
        alert("Логин не формат");
      }
      else {
        axios
          .post("http://apiks/api/", {
            action: "createUser",
            newUserData: formData,
            companyData: this.$store.getters.getUserCompanyData,
          })
          .then((response) => this.checkResponsForErrorOrData(response.data));
          
        //перезагрузить таблицу
        //обнулить поля формы
        this.formDataList = {};
      }
    },
  },
};
</script>

<style>
</style>