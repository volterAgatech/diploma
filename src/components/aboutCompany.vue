<template>
  <div class="about-container">
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
          v-model="data.myCompanyData[col.vmodelName]"
          type="text"
          name="first_name"
          class="form-control class-formDataList"
          autocomplete="on"
          required
        />
      </div>
      <button
        type="submit"
        class="btn btn-primary"
        @click="editRow(data.myCompanyData)"
      >
        Изменить
      </button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  //emits: ["reloadTable"],
  components: {},
  data() {
    return {
      data: {
        formLableNamesObj: [
          { lable: "Название организации", vmodelName: "name_company" },
          { lable: "Адрес", vmodelName: "adress" },
          { lable: "Номер Компании", vmodelName: "phone_number" },
          { lable: "Администратор", vmodelName: "admin_name" },
          { lable: "ИНН Компании", vmodelName: "inn" },
        ],
        formDataList: {},
        myCompanyData:{},
      },
    };
  },
  mounted() {
    this.setCompanyData()
  },
  methods: {
    setCompanyData(){
      this.data.myCompanyData = this.$store.getters.getUserCompanyData;
    },
    errorMsg(){
      alert('Данные о Компании успешно обновленны');
    },
    editRow(formData) {
      //ролучил данные из формы
      //to do отправить запрос на добавление вернуть отвте ошибку или успех
      axios
        .post("http://apiks/api/", {
          action: "updateTableRow",
          selectedTableName: 'companys',
          rowId: formData.id,
          updateData: formData,
        })
        .then(
          (response) => (
            console.log(response),
            //перезагрузить таблицу
            this.$emit("reloadTableEmit"),
            this.errorMsg()
          )
        );
    },
  },
};
</script>

<style>
</style>