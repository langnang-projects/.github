const state = {
  info: {},
  list: []
}

const mutations = {
  SET_INFO(state: any, info: any) {
    state.info = info;
  },
  SET_LIST(state: any, list: any) {
    state.list = list;
  },
}

const actions = {
}

export default {
  namespace: true,
  state,
  mutations,
  actions
}
