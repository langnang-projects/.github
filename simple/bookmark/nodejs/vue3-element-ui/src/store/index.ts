import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';

import tab from './modules/tab';

import getters from './getters';
export default createStore({
  state: {
    siteInfo: {
      href: '',
      title: '',
      keywards: [],
      description: '',
      icon: '',
      timestamp: 0,
      sortWeight: 0,
    },
    siteList: [],
    sites: [],
  },
  mutations: {
    SET_SITES(state, payload) {
      state.sites = payload;
    },
  },
  actions: {},
  getters,
  modules: {
    tab,
  },
  plugins: [createPersistedState()],
});
