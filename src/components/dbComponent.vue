<template>
  <div class="container-fluid">
    <div class="row dbcomponent-row">
      <div class="col bd-tables">
        <div class="bd-tables-container py-3">
          <h3>Администрирование</h3>
          <div class="d-grid gap-2">
            <button
              type="button"
              class="btn border-bottom"
              @click="getCompanyData"
            >
              О Комапании
            </button>
            <button
              type="button"
              class="btn border-bottom"
              @click="getCompanysUser"
            >
              Пользователи
            </button>
            <button
              type="button"
              class="btn border-bottom"
              @click="activeItem = 2"
            >
              Задачи
            </button>
          </div>
        </div>
      </div>
      <div class="col-8 main-table-container rounded-start border">
        <!-- aboutComp -->

        <div v-if="activeItem == 0" class="selected-option">
          <h1>О Компании</h1>
          <aboutCompany />
        </div>
        <!-- users -->
        <div v-else-if="activeItem == 1" class="selected-option">
          <h1>Пользователи</h1>
          <addUserModal @reloadTableEmit="getCompanysUser()" />

          <div class="user-list-main pt-2">
            <div
              v-for="user in companyUsers"
              v-bind:key="user"
              v-bind:user="user"
              class="accordion"
              id="accordionExample"
            >
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="'#' + user.login"
                    aria-expanded="true"
                    :aria-controls="user.login"
                  >
                    Имя пользователя: {{ user.name }} Роль: {{ user.text_rule }}
                  </button>
                </h2>
                <div
                  :id="user.login"
                  class="accordion-collapse collapse"
                  aria-labelledby="headingOne"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    <span class="border-bottom">Имя пользователя</span>
                    <h2>{{ user.name }}</h2>
                    <span class="border-bottom">Логин Пользователя</span>
                    <h2>{{ user.login }}</h2>
                    <span class="border-bottom">Пароль Пользователя</span>
                    <h2>{{ user.pass }}</h2>
                    <span class="border-bottom">Дата рожденияя</span>
                    <h2>{{ user.birth }}</h2>
                    <span class="border-bottom">Роль в компании</span>
                    <h2>{{ user.text_rule }}</h2>
                    <div class="btn-group">
                      <a
                        href="#"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editUserModal"
                        @click="setEditData(user)"
                        >Изменить</a
                      >
                      <a
                        href="#"
                        class="btn btn-primary active"
                        aria-current="page"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        @click="this.$store.commit('setTempData', user.id)"
                        >Удалить</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <deleteModal @reloadTableEmit="getCompanysUser()" />
          <editUserModal @reloadTableEmit="getCompanysUser()" ref="editModal" />
        </div>

        <!-- tasks -->
        <div v-else-if="activeItem == 2" class="selected-option">
          <h1>2</h1>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import deleteModal from "../components/deleteRowBtn.vue";
import addUserModal from "../components/addUserBtn.vue";
import editUserModal from "../components/editUserBtn.vue";
import aboutCompany from "../components/aboutCompany.vue";

export default {
  components: {
    deleteModal,
    addUserModal,
    editUserModal,
    aboutCompany,
  },
  data() {
    return {
      companyUsers: [],
      activeItem: 0,
    };
  },
  mounted() {
    //this.fetchTableList();
    //выставить изначальную таблици
  },
  methods: {
    setEditData(data) {
      this.$store.commit("setTempData", data);
      //console.log(this.editData);
      this.$refs.editModal.setDataProp();
    },
    saveData(data) {
      this.companyUsers = data;
      console.log(this.companyUsers);
    },
    getCompanyData() {
      this.activeItem = 0;
    },
    getCompanysUser() {
      this.activeItem = 1;
      //console.log("Получаю список пользователей");
      axios
        .post("http://apiks/api/", {
          action: "getCompanyUsers",
          companyId: this.$store.getters.getUserCompanyData.id,
        })
        .then((response) => this.saveData(response.data));
      //перезагрузить таблицу
      //обнулить поля формы
    },
  },
};
</script>

<style>
.table-table-container {
  overflow-x: scroll;
  width: 100%;
}
.bd-tables {
  background-color: ghostwhite;
}
.row.dbcomponent-row {
  height: 100vh;
}
th {
  border-style: unset;
}
button.btn.border-bottom {
  text-align: start;
}
</style>