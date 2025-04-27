import Vue from "vue";
import Vuex from "vuex";
import persistedState from "vuex-persistedstate";
import getters from "./getters";
import { get_lyric } from "@/api";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    playlist: [],
    song: {},
    app: {
      menuHeight: 0,
      mainBgColor: "#222327",
      mainHoverColor: "",
      mainActiveColor: "",
      cardBgColor: "#313237"
    },
    player: {
      height: 0
    }
  },
  mutations: {
    SET_PLAY_LIST(state, list) {
      localStorage.setItem("playlist", JSON.stringify(list));
      state.playlist = list;
    },
    SET_SONG(state, song) {
      state.song = song;
    },
    SET_APP(state, params) {
      state.app = { ...state.app, ...params };
    },
    SET_PLAYER(state, params) {
      state.player = { ...state.player, ...params };
    }
  },
  getters,
  actions: {
    pushPlaylist({ state, commit }, list) {
      commit("SET_PLAY_LIST", [
        ...(state.playlist.length ? state.playlist : []),
        ...list
      ]);
    },
    getSong({ state, commit, dispatch }, song_id) {
      let index = state.playlist.findIndex(s => s.id === song_id);
      let song = state.playlist[index];
      if (song.lyric) {
        commit("SET_SONG", state.playlist[index]);
        return Promise.resolve(song);
      }
      new Promise(resolve => get_lyric(song_id).then(resolve)).then(res => {
        state.playlist[index].lyric = res.lrc ? res.lrc.lyric : "";
        commit("SET_SONG", state.playlist[index]);
        if (!song.url) {
          console.log(this._vm.$message.error("未找到音频源"));
          return dispatch("playNext");
        }
        return Promise.resolve(song);
      });
    },
    playNext({ state, dispatch }) {
      let index = state.playlist.findIndex(item => item.id == state.song.id);
      if (index == state.playlist.length - 1) {
        index = 0;
      } else {
        index++;
      }

      return dispatch("getSong", state.playlist[index].id);
    },
    playPrev({ state, dispatch }) {
      let index = state.playlist.findIndex(item => item.id == state.song.id);
      if (index == 0) {
        index = state.playlist.length - 1;
      } else {
        index--;
      }

      return dispatch("getSong", state.playlist[index].id);
    }
  },
  plugins: [persistedState()]
});
