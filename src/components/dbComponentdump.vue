<template>
  <div class="container-fluid">
    <div class="row dbcomponent-row">
      <div class="col-2 bd-tables">
        <div class="bd-tables-container py-3">
          <h3>Список таблиц</h3>
          <div class="d-grid gap-2">
            <button
              v-for="item in tableNamesList"
              v-bind:key="item"
              v-bind:item="item"
              @click="setTableInfo(Object.values(item)[0])"
              type="button"
              class="btn btn-primary btn-sm"
            >
              {{ Object.values(item)[0] }}
            </button>
          </div>
        </div>
      </div>
      <!-- about company-->
      <div
        v-if="selectedTableName === 'about_company'"
        class="col main-table-container"
      >
        <h1>Данные о компании</h1>
        <form class="p-3 border" @submit.prevent>
          <div
            class="mb-3"
            v-for="col in onlyColumns"
            v-bind:key="col"
            v-bind:col="col"
          >
            <label for="exampleInputEmail1" class="form-label">{{ col }}</label>
            <input
              type="text"
              class="form-control"
              
              aria-describedby="emailHelp"
            />
          </div>
          <button type="submit" class="btn btn-primary">Изменить</button>
        </form>
      </div>
      <div v-else class="col main-table-container rounded-start border">
        <div class="table-container py-3">
          <h2>{{ selectedTableName }}</h2>
          <!-- CREATE ROW -->
          <addModal
            :tableNameProp="selectedTableName"
            :tableColProp="selectedTableColumns"
            @reloadTable="setTableInfo(selectedTableName)"
          />
          <!-- end CR -->
          <div class="table-container table-table-container">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th
                    v-for="item in selectedTableColumns"
                    v-bind:key="item"
                    v-bind:item="item"
                    scope="col"
                  >
                    {{ item.Field }}
                  </th>
                  <!-- <th scope="col">First</th>
                  <th scope="col">Last</th>
                  <th scope="col">Handle</th> -->
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="row in selectedTableRows"
                  v-bind:key="row"
                  v-bind:row="row"
                >
                  <th v-for="part in row" v-bind:key="part" v-bind:item="part">
                    {{ part }}
                  </th>
                  <div class="edit-row-btns text-end">
                    <button
                      v-on:click="
                        selectedRowId = row.id;
                        editData.row = row;
                      "
                      @click="refEdit"
                      type="button"
                      class="btn btn-success mx-1"
                      data-bs-toggle="modal"
                      data-bs-target="#editModal"
                    >
                      Edit
                    </button>
                    <button
                      v-on:click="selectedRowId = row.id"
                      @click="refDel"
                      type="button"
                      class="btn btn-danger"
                      data-bs-toggle="modal"
                      data-bs-target="#deleteModal"
                    >
                      Delete
                    </button>

                    <!-- <editModal :tableNameProp="selectedTableName" :tableColProp="selectedTableColumns" @reloadTable="setTableInfo(selectedTableName)"/> -->
                    <!-- <deleteModal :idProp="row.id" :tableNameProp="selectedTableName" @reloadTable="setTableInfo(selectedTableName)"/> -->
                  </div>
                </tr>
                <editModal
                  :tableColProp="selectedTableColumns"
                  @reloadTable="setTableInfo(selectedTableName)"
                  ref="editModal"
                />
                <deleteModal
                  @reloadTable="setTableInfo(selectedTableName)"
                  ref="deleteModal"
                />
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import deleteModal from "./deleteRowBtn.vue";
import addModal from "./addRowBtn.vue";
import editModal from "./editRowBtn.vue";
export default {
  components: { deleteModal, addModal, editModal },

  data() {
    return {
      data: [],
      deleteData: {
        idRow: "",
        tableName: "",
      },
      editData: {
        idRow: "",
        row: "",
        tableName: "",
      },
      tableNamesList: [],
      activeItem: 0,
      selectedTableName: "",
      selectedTableColumns: "",
      onlyColumns: [],
      selectedTableRows: "",
      selectedRowId: "",
    };
  },
  mounted() {
    this.fetchTableList();
    
    //выставить изначальную таблици
  },
  methods: {
    refEdit() {
      //формируем дату
      this.editData.idRow = this.selectedRowId;
      this.editData.tableName = this.selectedTableName;
      //отправляем в глобал стор
      this.$store.commit("setTempData", this.editData);
      //берем из глобал стор
      this.$refs.editModal.onShow();
    },
    refDel() {
      //формируем дату
      this.deleteData.idRow = this.selectedRowId;
      this.deleteData.tableName = this.selectedTableName;
      //отправляем в глобал стор
      this.$store.commit("setTempData", this.deleteData);
      //берем из глобал стор
      this.$refs.deleteModal.onShow();
    },
    setTableInfo(tableName) {
      //to do отправить дату на апи и вернуть массив строк и стобцов таблицы по имени
      this.setTableColByName(tableName);
      this.selectTableRowsByName(tableName);
    },
    setIndexTableData(param) {
      this.selectedTableName = Object.values(param[0])[0]; //Object.values(param[0])[0]
      this.setTableInfo(this.selectedTableName);
      
      
      //to do index table infoo
    },
    setTableColByName(tableName) {
      this.selectedTableName = tableName;
      axios
        .post("http://apiks/api/", {
          action: "getTableColByName",
          selectedTableName: tableName,
        })
        .then((response) => (this.selectedTableColumns = response.data));
        this.onlyColumns = [];
        this.selectedTableColumns.forEach((element) => {
        this.onlyColumns.push(element.Field);
        //console.log(this.onlyColumns);
      });
    },
    selectTableRowsByName(tableName) {
      //to do отправить дату на апи и вернуть массив строк и стобцов таблицы по имени
      this.selectedTableName = tableName;
      axios
        .post("http://apiks/api/", {
          action: "getTableRowByName",
          selectedTableName: tableName,
        })
        .then((response) => (this.selectedTableRows = response.data));
    },
    fetchTableList() {
      axios
        .post("http://apiks/api/", {
          action: "getTableNames",
        })
        .then(
          (response) => (
            (this.tableNamesList = response.data),
            this.setIndexTableData(this.tableNamesList)
          )
        );
        
    },
  },
};
</script>

<style>
.table-table-container {
  overflow-x: scroll;
  width: 79vw;
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
</style>