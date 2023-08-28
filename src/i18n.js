import { createI18n } from 'vue-i18n'

/**
 * Load locale messages
 *
 * The loaded `JSON` locale messages is pre-compiled by `@intlify/vue-i18n-loader`, which is integrated into `vue-cli-plugin-i18n`.
 * See: https://github.com/intlify/vue-i18n-loader#rocket-i18n-resource-pre-compilation
 */
// function loadLocaleMessages() {
//   const locales = require.context('./locales', true, /[A-Za-z0-9-_,\s]+\.json$/i)
//   const messages = {}
//   locales.keys().forEach(key => {
//     const matched = key.match(/([A-Za-z0-9-_]+)\./i)
//     if (matched && matched.length > 1) {
//       const locale = matched[1]
//       messages[locale] = locales(key).default
//     }
//   })
//   return messages
// }

export default createI18n({
  legacy: false,
  globalInjection: true,
  locale: process.env.VUE_APP_I18N_LOCALE || 'en',
  fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || 'en',
  // massages:loadLocaleMessages()
  messages: {
    en: {
      localeLoginUser: 'User Login',
      localePassUser: 'User password',
      localeNameUser: 'Username',
      localeDateUser: 'Enter site of birth:',
      localeIpUser: 'Enter an IP address',
      localeRegist: 'Regitration',
      localeAuth: 'Authorization',
      loacleBtnSubmite: 'Go',
      localeProfile:'Profile',
      localeOut:'Logout',
      localeBtnChange:'Change graff',
      localeChangeGraffString:'Enter values ​​for constants a,b,c',
      localeProfileh1:'Personal Profile',
      localeProfileh2:'Data to change'
    },
    ru: {
      localeLoginUser: 'Логин пользователя',
      localePassUser: 'Пароль пользователя',
      localeNameUser: 'Имя пользователя',
      localeDateUser: 'Введите дату рождения:',
      localeIpUser: 'Ввведите IP адресс',
      localeRegist: 'Регистрация',
      localeAuth: 'Авторизация',
      loacleBtnSubmite: 'Вперед',
      localeProfile:'Профиль',
      localeOut:'Покинуть',
      localeBtnChange:'Изменить граф',
      localeChangeGraffString:'Введите значения постоянных а,b,c',
      localeProfileh1:'Личный профиль',
      localeProfileh2:'Изменить данныые'
    }
  }
})
