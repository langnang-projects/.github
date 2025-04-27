<template>
  <div id="app">
    <el-row>
      <el-menu
        ref="menu"
        mode="horizontal"
        :router="true"
        :default-active="activeMenu"
        size="mini"
        background-color="#313237"
        text-color="#686f74"
        active-text-color="#c6c7cb"
      >
        <el-menu-item index="/">首页</el-menu-item>
        <el-menu-item index="/toplist">排行榜</el-menu-item>
        <el-menu-item index="/playlist">歌单</el-menu-item>
        <el-menu-item index="/artist">歌手</el-menu-item>
        <el-menu-item index="/repo" style="float:right;">
          <a
            href="https://github.com/langnang/simple-audio-player"
            target="_blank"
          >
            GitHub
          </a>
        </el-menu-item>
      </el-menu>
    </el-row>
    <keep-alive>
      <router-view
        :current-time="currentTime"
        @play="$refs['player'].onPlay(0)"
        :is-playing="isPlaying"
      ></router-view>
    </keep-alive>
    <AudioPlayer
      ref="player"
      :src-list="[song]"
      src-key="url"
      @playing="playing"
      @play="onPlay"
      @pause="onPause"
      @play-prev="onPlayPrev"
      @play-next="onPlayNext"
      @ended="onEnded"
      style="margin-top:12px"
    />
    <iframe src="https://3dqx3.sse.codesandbox.io/" style="display:none" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "App",
  components: {},
  data() {
    return {
      activeMenu: this.$route.path,
      currentTime: null,
      isPlaying: false
    };
  },
  computed: {
    ...mapGetters(["song"])
  },
  created() {},
  mounted() {
    this.$store.commit("SET_PLAYER", {
      height: this.$refs["player"].$el.clientHeight
    });
    this.$store.commit("SET_APP", {
      menuHeight: this.$refs["menu"].$el.clientHeight
    });
  },
  methods: {
    playing(time) {
      this.currentTime = time;
    },
    onPlay() {
      window.document.title = this.song.name;
      this.isPlaying = true;
    },
    onPause() {
      this.isPlaying = false;
    },
    onPlayNext() {
      this.$store.dispatch("playNext");
    },
    onPlayPrev() {
      this.$store.dispatch("playPrev");
    },
    onEnded() {
      this.isPlaying = false;
      this.$store.dispatch("playNext").then(() => {
        this.$refs["player"].onPlay(0);
      });
    }
  }
};
</script>

<style lang="scss">
html,
body,
* {
  margin: 0;
  padding: 0;
}

body {
  background-color: #222327;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
