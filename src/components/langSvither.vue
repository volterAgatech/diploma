<template>
  <!-- <div>{{ $t("localeLoginUser") }}</div> -->
  <button type="button" class="btn btn-primary" @click="changeLanguage('ru')">RU</button>
  <button type="button" class="btn btn-primary" @click="changeLanguage('en')">EN</button>
</template>

<script>
export default {
  data() {
    return {};
  },
  mounted() {
    console.log(this.$i18n.locale);
  },
  methods: {
    msg() {
      console.log('da')
    },
    changeLanguage(locale) {
      this.$i18n.locale = locale;
      this.selectedLanguage = locale;
      this.isDropdownOpened = false;
    },
  },
};
</script>

<style>
</style>