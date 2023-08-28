<template>
  <div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Edit row in "{{ data.tableName }}" table
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
              <input
                v-if="col === 'dateofmanufacture'"
                v-bind:value="data.row[col]"
                type="date"
                name="first_name"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
              <input
                v-else
                v-model.lazy="data.row[col]"
                type="text"
                name="first_name"
                true-value="modelValue"
                class="form-control class-formDataList"
                autocomplete="on"
                required
              />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            @click="editRow(data.row)"
            class="btn btn-primary btn-success"
            type="submit"
            data-bs-dismiss="modal"
          >
            Edit
          </button>
          <button
            @click="editClose(data.row)"
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
      modelValue: "",
      data: {
        tableName: "",
        tableColumns: [],
        rowId: "",
        row: "",
      },
      fdata: {
        row: {},
      },
      formDataList: {},
    };
  },
  props: {
    tableColProp: Object,
  },
  methods: {
    onShow() {
      //получил пропы из родителя

      this.data.tableName = this.$store.state.tempData.tableName;
      this.data.tableColumns = [];
      this.tableColProp.forEach((element) => {
        this.data.tableColumns.push(element.Field);
      });
      this.data.rowId = this.$store.state.tempData.idRow;
      this.data.row = this.$store.state.tempData.row;
      //delete this.data.tableColumns[0];
      //убираем Id для
      this.data.tableColumns.splice(0, 1);
      console.log(this.data);
    },
    editRow(formData) {
      //ролучил данные из формы
      //to do отправить запрос на добавление вернуть отвте ошибку или успех
      axios
        .post("http://apiks/api/", {
          action: "updateTableRow",
          selectedTableName: this.data.tableName,
          rowId: this.data.rowId,
          updateData: formData,
        })
        .then(
          (response) => (
            console.log(response),
            //перезагрузить таблицу
            this.$emit("reloadTable")
          )
        );
    },
    editClose(formData) {
      console.log(formData);
      this.$emit("reloadTable");
    },
  },
};
</script>

<style>
</style>