<template>
  <div class="pt-3">
    <!-- Button trigger modal -->
    <button
      @click="onShow"
      type="button"
      class="btn btn-primary btn-lg"
      data-bs-toggle="modal"
      data-bs-target="#modelId"
    >
      {{$t('localeBtnChange')}}
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="modelId"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{$t('localeChangeGraffString')}}</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col input-group mb-3">
                <span class="input-group-text" id="basic-addon1">A</span>
                <input
                  v-bind:value="form.a"
                  @input="form.a = $event.target.value"
                  type="text"
                  class="form-control"
                  placeholder="enter A"
                  aria-label="Username"
                  aria-describedby="basic-addon1"
                />
              </div>
              <div class="col input-group mb-3">
                <span class="input-group-text" id="basic-addon1">B</span>
                <input
                  v-bind:value="form.b"
                  @input="form.b = $event.target.value"
                  type="text"
                  class="form-control"
                  placeholder="enter B"
                  aria-label="Username"
                  aria-describedby="basic-addon1"
                />
              </div>
              <div class="col input-group mb-3">
                <span class="input-group-text" id="basic-addon1">C</span>
                <input
                  v-bind:value="form.c"
                  @input="form.c = $event.target.value"
                  type="text"
                  class="form-control"
                  placeholder="enter C"
                  aria-label="Username"
                  aria-describedby="basic-addon1"
                />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary" @click="submit">
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { QInput, QField, QDialog, QLayout, QFooter } from "quasar";
export default {
  extends: QInput,
  QField,
  QDialog,
  QLayout,
  QFooter,
  data() {
    return {
      form: {
        a: 0,
        b: 0,
        c: 0,
      },
    };
  },
  props: {
    Aprop: Number,
    Bprop: Number,
    Cprop: Number,
  },
  methods: {
    onShow() {
      this.form.a = this.Aprop;
      this.form.b = this.Bprop;
      this.form.c = this.Cprop;
    },
    submit() {
      // по нажатию передать данные в родителя из form в
      //console.log(this.Aprop)
      this.$emit("setNewValue", this.form);
    },
  },
};
</script>

<style>
</style>