<template>
  <div
    class="modal fade"
    id="editTaskModal"
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
                v-if="
                  col.vmodelName == 'date_start' ||
                  col.vmodelName == 'dead_line'
                "
                v-model="data.taskData[col.vmodelName]"
                type="date"
                name="first_name"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
              <input
                v-else-if="
                  col.vmodelName != 'description' &&
                  col.vmodelName != 'to_user_id'
                "
                v-model="data.taskData[col.vmodelName]"
                type="text"
                name="first_name"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
              <div v-if="col.vmodelName == 'description'" class="viftextarea">
                <div class="form-floating">
                  <textarea
                    class="form-control"
                    placeholder="Leave a comment here"
                    id="floatingTextarea2"
                    style="height: 100px"
                    v-model="data.taskData[col.vmodelName]"
                  ></textarea>
                  <label for="floatingTextarea2">Опишите Задачу</label>
                </div>
              </div>
              <div v-if="col.vmodelName == 'to_user_id'" class="viftextarea">
                <select
                  class="form-select form-select-sm"
                  aria-label=".form-select-sm example"
                  v-model="data.taskData[col.vmodelName]"
                >
                  <option disabled value="">Выберите исполнителя</option>
                  <option
                    v-for="selectUser in data.companyUsers"
                    v-bind:key="selectUser"
                    v-bind:selectUser="selectUser"
                    :value="selectUser.id"
                   
                  >
                   id: {{selectUser.id}} Имя:{{selectUser.name}} Должность:{{selectUser.text_rule}}
                  </option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            @click="editRow(this.data.taskData)"
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
        companyUsers:[],
        id: "",
        tableName: "",
        taskData: {},
        formLableNamesObj: [
          { lable: "Заголовок задачи", vmodelName: "title" },
          { lable: "Описание", vmodelName: "description" },
          { lable: "Начало задачи", vmodelName: "date_start" },
          { lable: "Крайний срок", vmodelName: "dead_line" },
          { lable: "Ответственный", vmodelName: "to_user_id" },
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
      this.data.taskData = this.$store.state.tempData;
      //console.log(this.data.taskData);
    },
    editRow(formData) {
      //ролучил данные из формы
      //to do отправить запрос на добавление вернуть отвте ошибку или успех
      axios
        .post("http://apiks/api/", {
          action: "updateTableRow",
          selectedTableName: 'tasks',
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
    },
    saveData(param) {
      this.data.companyUsers = param;
      console.log(this.data.companyUsers);
    },
    getCompanyUsers() {
      //console.log("Получаю список пользователей");
      axios
        .post("http://apiks/api/", {
          action: "getCompanyUsers",
          companyId: this.$store.getters.getUserCompanyData.id,
        })
        .then((response) => this.saveData(response.data));
    },
  },
};
</script>

<style>
</style>