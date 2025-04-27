<template>
  <div class="audio-lyric">
    <!--音频信息：歌词 -->
    <div class="audio-info__lyric">
      <el-scrollbar ref="lyricScrollbar" style="height: calc(100vh - 152px)">
        <ul
          ref="lyric"
          class="audio-info__lyric-group"
          style="list-style: none"
        >
          <li
            v-for="(l, index) in split_lyric"
            :key="index"
            class="audio-info__lyric-item"
            :class="{ active: index == currentIndex }"
          >
            {{ l.lyric }}
          </li>
        </ul>
      </el-scrollbar>
    </div>
  </div>
</template>

<script>
export default {
  name: "AudioLyric",
  props: {
    currentTime: {
      type: Number,
      default: null
    },
    lyric: {
      type: String,
      default: null
    }
  },
  data() {
    return {};
  },
  computed: {
    split_lyric() {
      const lyricArray = [];
      if (!this.lyric) {
        return [];
      }
      this.lyric.split(/\n/).forEach(value => {
        // console.log(v.match(/\[\d{2}:\d{2}.\d{2,3}\]/))
        const item = {
          start: null,
          lyric: value,
          end: null
        };
        let startIndex = value.indexOf("[");
        let endIndex = value.indexOf("]");
        if (startIndex != -1) {
          item.start = 0;
          item.start += parseInt(value.substr(startIndex + 1, 2)) * 60;
          item.start += parseInt(value.substr(startIndex + 4, 2));
          item.start += parseInt(value.substr(startIndex + 7, 2)) * 0.01;
          item.lyric = item.lyric.substr(endIndex + 1);
        }
        if (item.lyric != "") {
          lyricArray.push(item);
        }
      });
      return lyricArray;
    },
    currentIndex() {
      const index = this.split_lyric.findIndex(v => v.start > this.currentTime);
      return index - 1;
    }
  },
  methods: {},
  watch: {
    currentIndex: function(val) {
      this.$refs.lyric.style.transform = `translateY(${330 -
        25 * (val + 1)}px)`;
    }
  }
};
</script>

<style lang="scss" scoped>
.audio-info {
  text-align: center;

  .audio-info__cover {
    width: 160px;
    height: 160px;
    margin: 0 auto;

    img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
    }
  }
}

.audio-info__lyric-group {
  transition: transform 1s;
}

.audio-info__lyric-item {
  font: {
    size: 14px;
  }
  color: #606266;
  // color: rgba(225, 225, 225, 0.8);
  padding: 3px 0;
}

.active {
  color: #7f6ce9;
}
</style>
