<template>
  <div
    class="modal fade"
    id="editUserModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Вы действительно хотите изменить эту записть?
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
                v-model="data.userData[col.vmodelName]"
                type="date"
                name="first_name"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
              <input
                v-else
                v-model="data.userData[col.vmodelName]"
                type="text"
                name="first_name"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            @click="editRow(this.data.userData)"
            type="button"
            class="btn btn-danger"
            data-bs-dismiss="modal"
          >
            Изменить
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
            @click="close"
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
  data() {
    return {
      data: {
        id: "",
        tableName: "",
        userData: {},
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
  
  mounted() {
    
  },
  methods: {
    close(){
      this.$emit("reloadTableEmit")
    },
    setDataProp(){
      this.data.userData = this.$store.state.tempData;
      console.log(this.data.userData);
    },
    editRow(formData) {
      if (
        !formData.name ||
        !formData.login ||
        !formData.pass ||
        !formData.birth ||
        !formData.text_rule
      ) {
        alert("Заполните Форму");
      } else if(!/^[a-zA-Z]*$/.test(formData.login)){
        alert("Логин не формат");
      }
      else {
      //ролучил данные из формы
      //to do отправить запрос на добавление вернуть отвте ошибку или успех
      axios
        .post("http://apiks/api/", {
          action: "updateTableRow",
          selectedTableName: 'users',
          rowId: formData.id,
          updateData: formData,
        })
        .then(
          (response) => (
            console.log(response),
            //перезагрузить таблицу
            this.$emit("reloadTableEmit")
          )
        );
      }
    }
  },
};
</script>

<style>
</style>