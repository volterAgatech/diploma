<template>
  <div class="container-fluid">
    <div class="row dbcomponent-row">
      <div class="col bd-tables">
        <div class="bd-tables-container py-3">
          <h3>Задачи</h3>
          <div class="d-grid gap-2">
            <button type="button" class="btn border-bottom" @click="getMyTasks">
              Мои Задачи
            </button>
            <button
              type="button"
              class="btn border-bottom"
              @click="getPostedTasks"
            >
              Поставленные задачи
            </button>
            <button
              type="button"
              class="btn border-bottom"
              @click="getComplitedTasks"
            >
              Выполненные задачи
            </button>
          </div>
        </div>
      </div>
      <div class="col-8 main-table-container rounded-start border">
        <!-- MyTasks -->
        <div v-if="activeItem == 0" class="selected-option">
          <h1>Мои Задачи</h1>
          <div class="user-list-main pt-2">
            <div
              v-for="task in data.myCreatedTask"
              v-bind:key="task"
              v-bind:task="task"
              class="accordion"
              id="accordionExample"
            >
              <div class="accordion-item">
                <h2 class="accordion-header" :id="'flush-headingOne' + task.id">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="'#' + 'task' + task.id"
                    aria-expanded="true"
                    :aria-controls="'task' + task.id"
                    @click="getUser(task.from_user_id);countTimeTask(task)"
                  >
                    <b>Задача №{{ task.id }}</b
                    ><span>{{ task.title }}</span>
                  </button>
                </h2>
                <div
                  :id="'task' + task.id"
                  class="accordion-collapse collapse"
                  :aria-labelledby="'flush-headingOne' + task.id"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    <h2 class="border-bottom">{{ task.title }}</h2>
                    <span class="border-bottom">Описание задачи</span>
                    <br />
                    <span>{{ task.description }}</span>
                    <br />

                    <div class="calendar-div py-2">
                      <div class="left">
                        <span>Старт задачи:</span>
                        <input
                          v-model="task.date_start"
                          type="date"
                          name=""
                          id=""
                        />
                      </div>
                      <div class="right">
                        <span>Крайний срок:</span>
                        <input
                          v-model="task.dead_line"
                          type="date"
                          name=""
                          id=""
                        />
                      </div>
                    </div>
                    <div class="to-user-div py-2">
                      <span>Ответственный</span>
                      <h2>{{ data.taskMaker.name }}</h2>
                      <h3>{{ data.taskMaker.text_rule }}</h3>
                    </div>

                    <div
                      v-if="task.task_status == 'started'"
                      class="btn-group py-2"
                      role="group"
                    >
                      <button
                        type="button"
                        class="btn btn-outline-success"
                        @click="setStatusTask(task.id, 'stoped')"
                      >
                      Приостановить
                      </button>
                      <button
                        type="button"
                        class="btn btn-outline-danger"
                        @click="setStatusTask(task.id, 'closed')"
                      >
                      Завершить
                      </button>
                      <button
                        type="button"
                        class="btn btn-outline-success"
                        disabled
                      >
                        {{task.visited_data}}
                      </button>
                    </div>
                    <div
                      v-if="task.task_status == 'created' || task.task_status == 'stoped'"
                      class="btn-group py-2"
                      role="group"
                    >
                      <button
                        type="button"
                        class="btn btn-outline-success"
                        @click="setStatusTask(task.id, 'started')"
                      >
                      Начать
                      </button>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- addTasks -->

        <div v-if="activeItem == 1" class="selected-option">
          <h1>Поставленные задачи</h1>
          <addTaskModal @reloadTableEmit="getPostedTasks()" />
          <div class="user-list-main pt-2">
            <div
              v-for="task in data.myCreatedTask"
              v-bind:key="task"
              v-bind:task="task"
              class="accordion"
              id="accordionExample"
            >
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="'#' + 'task' + task.id"
                    aria-expanded="true"
                    :aria-controls="'task' + task.id"
                    @click="getUser(task.to_user_id)"
                  >
                    <b>Задача №{{ task.id }}</b
                    ><span>{{ task.title }}</span>
                  </button>
                </h2>
                <div
                  :id="'task' + task.id"
                  class="accordion-collapse collapse"
                  aria-labelledby="headingOne"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    <h2 class="border-bottom">{{ task.title }}</h2>
                    <span class="border-bottom">Описание задачи</span>
                    <br />
                    <span>{{ task.description }}</span>
                    <br />

                    <div class="calendar-div py-2">
                      <div class="left">
                        <span>Старт задачи:</span>
                        <input
                          v-model="task.date_start"
                          type="date"
                          name=""
                          id=""
                        />
                      </div>
                      <div class="right">
                        <span>Крайний срок:</span>
                        <input
                          v-model="task.dead_line"
                          type="date"
                          name=""
                          id=""
                        />
                      </div>
                    </div>
                    <div class="to-user-div py-2">
                      <span>Ответственный</span>
                      <h2>{{ data.taskMaker.name }}</h2>
                      <h3>{{ data.taskMaker.text_rule }}</h3>
                    </div>
                    <div class="btn-group py-2">
                      <button
                        href="#"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editTaskModal"
                        @click="setEditData(task)"
                      >
                        Изменить
                      </button>

                      <a
                        href="#"
                        class="btn btn-primary active"
                        aria-current="page"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        @click="this.$store.commit('setTempData', task.id)"
                        >Удалить</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <deleteModal @reloadTableEmit="getPostedTasks()" />
            <editTaskModal ref="editTask" />
          </div>
        </div>

        <!-- Closedtasks -->
        <div v-else-if="activeItem == 2" class="selected-option">
          <h1>Выполненные задачи</h1>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import deleteModal from "../components/deleteTask.vue";
import addTaskModal from "../components/addTaskBtn.vue";
import editTaskModal from "../components/editTask.vue";

export default {
  components: {
    deleteModal,
    addTaskModal,
    editTaskModal,
    //editUserModal,
  },
  data() {
    return {
      companyUsers: [],
      activeItem: 0,
      data: {
        taskTime:{
          days:"",
          hours:"",
          seconds:"",
        },
        taskMaker: {},
        taskStatus: "",
        taskStatusDescr: [
          { lable: "Начать", vmodelName: "started" },
          { lable: "Завершить", vmodelName: "closed" },
          { lable: "Приостановить", vmodelName: "stoped" },
        ],
        idtask: "",
        myCreatedTask: {},
        myTasks: {},
        myComlitedTasks: {},
      },
    };
  },
  mounted() {
    this.getMyTasks();
    //this.fetchTableList();
    //выставить изначальную таблици
  },
  methods: {
    setEditData(data) {
      this.$store.commit("setTempData", data);
      //console.log(this.editData);
      this.$refs.editTask.setDataProp();
      this.$refs.editTask.getCompanyUsers();
    },
    editBtnRef() {},
    setData(res) {
      //сохранить список полученных задач
      this.data.myCreatedTask = res;
    },
    getMyTasks() {
      //вывести список полученных задач
      this.activeItem = 0;
      axios
        .post("http://apiks/api/", {
          action: "getMyTasks",
          userId: this.$store.getters.getAuthUserData.id,
        })
        .then((response) => this.setData(response.data));
    },
    getPostedTasks() {
      //вывести список поставленных задач
      this.activeItem = 1;
      axios
        .post("http://apiks/api/", {
          action: "getCreatedTask",
          userId: this.$store.getters.getAuthUserData.id,
        })
        .then((response) => this.setData(response.data));
    },
    getComplitedTasks() {
      //вывести список завершенных задач
      this.activeItem = 2;
    },
    returnUserName(res) {
      //сохранить исполнителя либо постановщика задачи
      this.data.taskMaker = res;
    },
    getUser(userid) {
      //получить исполнителя либо постановщика задачи
      axios
        .post("http://apiks/api/", {
          action: "getUserById",
          userId: userid,
        })
        .then((response) => this.returnUserName(response.data));
    },
    
    countTimeTask(param){
      //console.log(param);
      //countTimeTask
      axios
          .post("http://apiks/api/", {
            action: "countTimeTask",
            taskId: param.id,
            status: param.task_status,
          })
          .then((response) => response);
    },
    setStatusTask(id, param) {
      console.log(id, param);
      if (param) {
        axios
          .post("http://apiks/api/", {
            action: "setTaskStatus",
            taskId: id,
            status: param,
          })
          .then((response) => console.log(response),this.getMyTasks());
        
      }
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
.calendar-div {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}
</style>