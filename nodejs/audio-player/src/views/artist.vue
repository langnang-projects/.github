<template>
  <el-row>
    <el-col :span="24">
      <el-form label-width="80px" size="mini" ref="form">
        <el-form-item label="平台">
          <el-radio-group v-model="platform">
            <el-radio-button label="网易云"></el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="组合">
          <el-radio-group v-model="type" @change="handleChanageType">
            <el-radio-button :label="-1">全部</el-radio-button>
            <el-radio-button :label="1">男歌手</el-radio-button>
            <el-radio-button :label="2">女歌手</el-radio-button>
            <el-radio-button :label="3">组合/乐队</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="地区">
          <el-radio-group v-model="area" @change="handleChanageArea">
            <el-radio-button :label="-1">全部</el-radio-button>
            <el-radio-button :label="7">华语</el-radio-button>
            <el-radio-button :label="96">欧美</el-radio-button>
            <el-radio-button :label="8">日本</el-radio-button>
            <el-radio-button :label="16">韩国</el-radio-button>
            <el-radio-button :label="0">其它</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="歌手" v-if="artists.data.length > 0">
          <el-scrollbar style="height:112px">
            <el-radio-group
              v-model="artists.active"
              @change="handleChangeArtist"
              v-infinite-scroll="load"
            >
              <el-radio-button
                v-for="ar in artists.data"
                :key="ar.id"
                :label="ar.id"
                >{{ ar.name }}</el-radio-button
              >
            </el-radio-group>
          </el-scrollbar>
        </el-form-item>
        <el-form-item>
          <el-button
            :disabled="playlist.tableData.length == 0"
            @click="handlePlay"
            type="info"
            >播放</el-button
          >
          <el-button
            :disabled="playlist.tableData.length == 0"
            @click="handleAddtoPlaylist"
            type="info"
            >添加至播放列表</el-button
          >
        </el-form-item>
      </el-form>
    </el-col>
    <el-col :span="24">
      <el-scrollbar :style="{ height: tableHeight }">
        <el-table
          :data="playlist.tableData"
          v-loading="playlist.loading"
          size="mini"
        >
          <el-table-column type="index" width="50"> </el-table-column>
          <el-table-column prop="name" label="标题" show-overflow-tooltip>
          </el-table-column>
          <el-table-column label="时长" show-overflow-tooltip width="80px">
            <template slot-scope="$scope">
              {{ parseInt($scope.row.dt / 1000 / 60) }}:{{
                parseInt($scope.row.dt / 1000) % 60 > 9
                  ? parseInt($scope.row.dt / 1000) % 60
                  : "0" + (parseInt($scope.row.dt / 1000) % 60)
              }}
            </template>
          </el-table-column>
          <el-table-column label="歌手" show-overflow-tooltip width="280px">
            <template slot-scope="$scope">
              <span v-for="artist in $scope.row.ar" :key="artist.id">{{
                artist.name
              }}</span>
            </template>
          </el-table-column>
        </el-table>
      </el-scrollbar>
    </el-col>
  </el-row>
</template>
<script>
import {
  get_toplist,
  get_playlist,
  get_artist_list,
  get_artist_top_songs,
  get_song_url
} from "@/api";
import { mapGetters } from "vuex";
export default {
  name: "toplist",
  data() {
    return {
      type: "-1",
      area: "-1",
      platform: "网易云",
      artists: {
        loading: false,
        active: "",
        data: [],
        pageNum: 1
      },
      playlist: {
        active: "",
        tableData: [],
        loading: false
      },
      form: {
        clientHeight: 0
      }
    };
  },
  computed: {
    ...mapGetters(["app", "player"]),
    tableHeight() {
      return `calc(100vh - ${this.app.menuHeight}px - ${this.player.height}px - ${this.form.clientHeight}px - 36px)`;
    }
  },
  created() {
    this.getArtistList();
  },
  mounted() {
    this.form.clientHeight = this.$refs["form"].$el.clientHeight;
  },
  updated() {
    this.form.clientHeight = this.$refs["form"].$el.clientHeight;
  },
  methods: {
    // 歌手列表滚动到底部自动请
    load() {
      this.artists.pageNum++;
      this.getArtistList();
      // this.getTopPlaylist();
    },
    handleChanageType() {
      this.artists.data = [];
      this.artists.pageNum = 1;
      this.getArtistList();
    },
    handleChanageArea() {
      this.artists.data = [];
      this.artists.pageNum = 1;
      this.getArtistList();
    },
    handleChangeArtist() {
      this.getArtistTopSongs();
    },
    // 查询歌手列表
    getArtistList() {
      this.artists.loading = true;
      get_artist_list({
        type: this.type,
        area: this.area,
        pageNum: this.artists.pageNum
      }).then(res => {
        this.artists.data = [...this.artists.data, ...res.artists];
        this.artists.loading = false;
      });
    },
    // 查询歌手热门50首歌曲
    getArtistTopSongs() {
      const id = this.artists.active;
      this.playlist.loading = true;
      this.playlist.tableData = [];
      get_artist_top_songs(id).then(res => {
        get_song_url(res.songs).then(r => {
          const total = r.data.reduce((total, value, index) => {
            if (value.url) {
              total.push({ ...res.songs[index], url: value.url });
            }
            return total;
          }, []);
          this.playlist.tableData = total;
          this.playlist.loading = false;
        });
      });
    },
    // 查询排行榜列表
    getToplist() {
      get_toplist().then(res => {
        this.toplist.data = res.list;
        this.toplist.active = res.list[0].id;
        this.getPlaylist();
      });
    },
    // 查询歌单列表
    getPlaylist() {
      const id = this.toplist.active;
      this.playlist.loading = true;
      get_playlist(id).then(res => {
        this.playlist.tableData = res.playlist.tracks;
        this.playlist.loading = false;
      });
    },
    // 选中排行榜
    handleChangeToplist() {
      this.getPlaylist();
    },
    // 播放
    handlePlay() {
      this.$confirm("此操作将替换当前播放列表, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$store.commit("SET_PLAY_LIST", this.playlist.tableData);
          this.$message({
            type: "success",
            message: "添加成功!"
          });
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消添加"
          });
        });
    },
    // 添加至播放列表
    handleAddtoPlaylist() {
      this.$confirm("此操作将排行榜添加至当前播放列表, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$store.dispatch("pushPlaylist", this.playlist.tableData);
          this.$message({
            type: "success",
            message: "添加成功!"
          });
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消添加"
          });
        });
    }
  },
  watch: {}
};
</script>
