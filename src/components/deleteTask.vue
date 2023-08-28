<template>
  <div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Вы действительно хотите удалить эту записть?
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-footer">
          <button
            @click="deleteUser()"
            type="button"
            class="btn btn-danger"
            data-bs-dismiss="modal"
          >
            Delete
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
  emits: ["reloadTableEmit"],
  data() {
    return {
      data: {
        id: "",
        tableName: "",
      },
    };
  },
  methods: {
    deleteUser() {
      console.log("удалить строку с id = ", this.$store.state.tempData);
      axios
        .post("http://apiks/api/", {
          action: "deleteRowById",
          selectedTableName: "tasks",
          selectedId: this.$store.state.tempData,
        })
        .then(
          (response) => (
            console.log(response),
            
            this.$emit("reloadTableEmit")
          )
        );
        
    },
  },
};
</script>

<style>
</style>