<template>
  <el-row>
    <el-col :span="24">
      <el-form label-width="80px" size="mini" ref="form">
        <el-form-item label="平台">
          <el-radio-group v-model="platform">
            <el-radio-button label="网易云"></el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="系列">
          <el-radio-group
            v-model="catlist.activeCat"
            @change="handleChangeCat"
            v-loading="catlist.loading"
          >
            <el-radio-button :label="-1">{{
              catlist.all.name
            }}</el-radio-button>
            <el-radio-button
              v-for="(cat, key) in catlist.categories"
              :key="key"
              :label="key"
              >{{ cat }}</el-radio-button
            >
          </el-radio-group>
        </el-form-item>
        <el-form-item label="分类" v-if="catlist.activeCat != '-1'">
          <el-radio-group v-model="catlist.activeSub" @change="handleChangeSub">
            <el-radio-button
              v-for="(cat, key) in catlist.sub.filter(
                item => item.category == catlist.activeCat
              )"
              :key="key"
              :label="cat.name"
            ></el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="歌单" v-if="playlists.tableData.length > 0">
          <el-scrollbar style="height:140px">
            <el-radio-group
              v-model="playlists.active"
              @change="handleChangePlaylist"
              v-infinite-scroll="load"
            >
              <el-radio-button
                v-for="(play, key) in playlists.tableData"
                :key="key"
                :label="play.id"
                >{{ play.name }}</el-radio-button
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
      <el-scrollbar :style="{ height: tableHeight }" ref="scroll">
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
          <el-table-column label="专辑名" show-overflow-tooltip width="280px">
            <template slot-scope="$scope">
              {{ $scope.row.al.name }}
            </template>
          </el-table-column>
        </el-table>
      </el-scrollbar>
    </el-col>
  </el-row>
</template>
<script>
import {
  get_playlist,
  get_playlist_catlist,
  get_playlist_top,
  get_song,
  get_song_url
} from "@/api";
import { mapGetters } from "vuex";
export default {
  name: "toplist",
  data() {
    return {
      platform: "网易云",
      catlist: {
        loading: false,
        all: {},
        activeCat: "-1",
        categories: {},
        activeSub: "",
        sub: []
      },
      playlists: {
        active: "",
        tableData: [],
        loading: false,
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
    this.getPlaylistCatlist();
  },
  mounted() {
    this.form.clientHeight = this.$refs["form"].$el.clientHeight;
  },
  updated() {
    this.form.clientHeight = this.$refs["form"].$el.clientHeight;
  },
  methods: {
    // 歌单列表滚动到底部自动请
    load() {
      this.playlists.pageNum++;
      this.getTopPlaylist();
    },
    // 选中排行榜
    handleChangePlaylist() {
      this.getPlaylist();
    },
    getPlaylistCatlist() {
      this.catlist.loading = true;
      get_playlist_catlist().then(res => {
        if (res == "") {
          setTimeout(this.getPlaylistCatlist(), 1000);
          return;
        }
        this.catlist.all = res.all;
        this.catlist.categories = res.categories;
        this.catlist.sub = res.sub;
        this.playlists.pageNum = 1;
        this.catlist.loading = false;
        this.getTopPlaylist();
      });
    },
    handleChangeCat() {
      if (this.catlist.activeCat == -1) {
        this.getTopPlaylist();
      }
    },
    handleChangeSub() {
      this.playlists.pageNum = 1;
      this.playlists.tableData = [];
      this.getTopPlaylist();
    },
    // 查询精选碟歌单
    getTopPlaylist() {
      // 默认歌单类别
      let cat = this.catlist.activeSub;
      if (this.catlist.activeCat == -1 || !this.catlist.activeSub) {
        cat = "全部";
      }
      this.playlists.loading = true;
      get_playlist_top({ cat, pageNum: this.playlists.pageNum }).then(res => {
        this.playlists.tableData = [
          ...this.playlists.tableData,
          ...res.playlists
        ];
        this.playlists.loading = false;
      });
    },
    // 查询歌单列表
    getPlaylist() {
      const id = this.playlists.active;
      this.playlist.loading = true;
      this.playlist.tableData = [];
      // this.$refs["scroll"].wrap.scrollTop = 0;
      get_playlist(id).then(res => {
        Promise.all([
          get_song(res.playlist.trackIds),
          get_song_url(res.playlist.trackIds)
        ]).then(r => {
          const total = r[1].data.reduce((total, value, index) => {
            if (value.url) {
              total.push({ ...r[0].songs[index], url: value.url });
            }
            return total;
          }, []);
          this.playlist.tableData = total;
          this.playlist.loading = false;
        });
      });
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
          this.$emit("play");
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
