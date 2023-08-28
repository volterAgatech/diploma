import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'

const store = createStore({
  plugins: [createPersistedState()],
  state() {
    return {
      userlist: [],
      isAuth: false,
      userAuth: '',
      lang: 'ru',
      tempData: [],
      userData: [],
      companyData: [],
      userRule: "",
      deleteData: {
        id: '',
        tableName: ''
      }
    }
  },
  mutations: {
    setDeleleData(state, param) {
      state.deleteData.id = param.id;
      state.deleteData.tableName = param.tableName;
    },
    setTempData(state, param) {
      state.tempData = param;

    },

    setCompanyData(state, param) {
      state.companyData = param;
    },
    setAuth(state, param) {
      state.isAuth = param
    },
    setUserData(state, param) {
      state.userData = param;
    },
    setUserRule(state, param) {
      state.userRule = param.rule;
    },
    unsetAuth(state) {
      state.isAuth = ''
    },
    unsetUsername(state) {
      state.userAuth = ''
    },
    changeRegUserData(state, data) {
      state.userAuth = data
    },
    registerUserData(state, data) {
      const newUser = {
        userName: data.userName,
        userPass: data.userPass,
        userLogin: data.userLogin,

        userDayBirth: data.userDayBirth,

      }

      state.userlist.push(newUser)
      console.log(newUser, state.userlist)

    }
  },
  getters: {
    getUserByLoginPass: (state) => (login, pass) => {
      state.userAuth = state.userlist.filter(userlist => userlist.userLogin === login && userlist.userPass === pass)
      return state.userlist.filter(userlist => userlist.userLogin === login && userlist.userPass === pass)
    },
    getAuthUserData(state) {
      return state.userData
    },
    getUserRule(state) {
      return state.userRule
    },
    getUserCompanyData(state){
      return state.companyData
    }
  },
  actions: {
    setDelDataAction(state, data) {
      state.commit('setDeleleData', data)
    },
    setAuth(state) {
      state.commit('setAuth', true)
    },
    setCompanyDataAction(state, data) {
      state.commit('setCompanyData', data)
    },
    setUserDataAction(state, param) {
      state.commit('setUserData', param)
    },
    setUserRuleAction(state, param) {
      state.commit('setUserRule', param)
    },

    // Функция сброса всех полей хранилища данных
    unsetStorage(state) {
      state.commit('unsetUsername')
      state.commit('unsetAuth')
    },
    setChangeUserRegistData(state, data) {
      state.commit('setUserData', data)
    }
  }
})
export default store