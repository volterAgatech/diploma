<template>
  <button
    @click="onShow"
    type="button"
    class="btn btn-primary btn-success"
    data-bs-toggle="modal"
    data-bs-target="#addModalNew"
  >
    Add
  </button>

  <div
    class="modal fade"
    id="addModalNew"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Add row to "{{ data.tableName }}" table
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
              v-for="col in data.tableColumns"
              v-bind:key="col"
              v-bind:col="col"
            >
              <label for="recipient-name" class="col-form-label">
                {{ col }}</label
              >
              <input v-if="col ==='dateofmanufacture'"
                v-model="formDataList[col]"
                type="date"
                name="first_name"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
              <input v-else
                v-model="formDataList[col]"
                type="text"
                name="first_name"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
            </div>
          </form>
        </div>
        <div class="modal-footer suka">
          <button
            @click="addRow(formDataList)"
            class="btn btn-primary btn-success"
            type="submit"
            data-bs-dismiss="modal"
          >
            Add
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
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
  emits: ["reloadTable"],
  components: {},
  data() {
    return {
      data: {
        tableName: "",
        tableColumns: [],
      },
      formDataList: {},
    };
  },
  props: {
    tableNameProp: String,
    tableColProp: Object,
  },
  methods: {
    onShow() {
      //получил пропы из родителя
      this.data.tableName = this.tableNameProp;
      this.data.tableColumns = [];
      this.tableColProp.forEach((element) => {
        this.data.tableColumns.push(element.Field);
      });
      //delete this.data.tableColumns[0];
      //убираем Id для
      this.data.tableColumns.splice(0, 1);
      console.log(this.data.tableColumns);
    },
    addRow(formData) {
      //ролучил данные из формы
      console.log(formData);
      // //to do отправить запрос на добавление вернуть отвте ошибку или успех
      axios
        .post("http://apiks/api/", {
          action: "insertIntoTable",
          selectedTableName: this.data.tableName,
          insertInto: formData,
          selectedTableCol:this.data.tableColumns,
        })
        .then(
          (response) => (
            (this.selectedTableRows = response.data,
            console.log(response),
            this.$emit("reloadTable")
            )
            
            //setTableInfo(tableName)
            //this.$emit("reloadTable")
          )
        );
      //перезагрузить таблицу
      //обнулить поля формы
      this.formDataList = {};
    },
  },
};
</script>

<style>
</style>