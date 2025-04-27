<template>
  <el-row :gutter="6" style="margin: 0">
    <el-col :span="14">
      <el-scrollbar :style="{ height: cardHeight }">
        <el-table
          :data="playlist"
          :show-header="false"
          style="width: 100%"
          :row-class-name="tableRowClassName"
          size="mini"
        >
          <el-table-column type="index" width="50"> </el-table-column>
          <el-table-column>
            <template v-slot="scope">
              <label>{{ scope.row.name }}</label>
              <span class="audio-play__button-group">
                <el-tooltip
                  class="item"
                  effect="dark"
                  content="播放"
                  placement="top"
                >
                  <el-button
                    size="mini"
                    type="info"
                    icon="el-icon-video-play"
                    circle
                    @click="onRowPlay(scope.row)"
                  >
                  </el-button>
                </el-tooltip>
              </span>
            </template>
          </el-table-column>
          <el-table-column
            label="时长"
            show-overflow-tooltip
            width="80px"
            :formatter="playTime"
          >
          </el-table-column>
          <el-table-column show-overflow-tooltip width="120px">
            <template v-slot="scope">
              {{ scope.row.ar.map(item => item.name).join("  ") }}
            </template>
          </el-table-column>
        </el-table>
      </el-scrollbar>
    </el-col>
    <el-col :span="10">
      <div
        class="audio-info"
        style=" background-color:#313237;position:static;"
      >
        <!--音频信息：封面 -->
        <div class="audio-info__cover" style="position:absolute;">
          <img
            :src="song.al ? song.al.picUrl : null"
            :class="{ active: isPlaying }"
          />
        </div>
        <!--音频信息：专辑 -->
        <div
          class="audio-info__album"
          style="height:20px;line-height:20px;color:#606266;"
        >
          {{ song.al ? song.al.name : null }}
        </div>
        <!--音频信息：作者 -->
        <div
          class="audio-info__author"
          style="height:20px;line-height:20px;color:#606266;"
        >
          {{ song.ar ? song.ar.map(item => item.name).join("  ") : null }}
        </div>
        <!--音频信息：歌词 -->
        <AudioLyric :lyric="song.lyric" :current-time="currentTime" />
      </div>
    </el-col>
  </el-row>
</template>

<script>
import AudioLyric from "@/components/AudioLyric";
import { mapGetters } from "vuex";

export default {
  props: {
    currentTime: {},
    isPlaying: {}
  },
  components: {
    AudioLyric
  },
  data() {
    return {};
  },
  computed: {
    ...mapGetters(["playlist", "song", "app", "player"]),
    // audioList() {
    //   return this.audio_list.reduce((total, value) => {
    //     total.push(value.src);
    //     return total;
    //   }, []);
    // }
    cardHeight() {
      return `calc(100vh - ${this.app.menuHeight}px - ${this.player.height}px - 24px)`;
    }
  },
  created() {},
  methods: {
    tableRowClassName(data) {
      return data.row.id === this.song.id ? "active" : "";
    },
    onTableRowClick(row) {
      const _index = this.audio_list.findIndex(value => value == row);
      this.$store.commit("audio/SET_ITEM", row);
      this.$refs.player.currentIndex = _index;
    },
    onRowPlay(row) {
      this.$store.dispatch("getSong", row.id).then(() => {
        this.$emit("play");
      });
    },
    playTime(row) {
      const minute = parseInt(row.dt / 1000 / 60);
      const second = parseInt(row.dt / 1000) % 60;
      return minute + ":" + (second > 9 ? second : "0" + second);
    }
  }
};
</script>

<style lang="scss" scoped>
@import "./../styles";

::v-deep .el-scrollbar__wrap {
  overflow-x: hidden;
}

.audio-player-container {
  height: 60px;

  &:hover .audio-player {
    height: 60px;
  }
}

.audio-info {
  text-align: center;

  .audio-info__cover {
    position: absolute;
    width: initial;
    height: initial;
    overflow: hidden;
    opacity: 0.1;
    img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      &.active {
        animation: rotation 6s infinite linear;
      }
    }
  }
  .audio-info__album {
    // color: aliceblue;
  }
  .audio-info__author {
    // color: aliceblue;
  }
}

.audio-play__button-group {
  float: right;
  display: none;
}

::v-deep .el-table__row:hover .audio-play__button-group {
  display: block;

  .el-button--mini.is-circle {
    padding: 4px;
  }
}
@keyframes rotation {
  from {
    transform: rotate(0deg);
  }

  to {
    transform: rotate(359deg);
  }
}
</style>
