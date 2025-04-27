<template>
  <div class="audio-play-list">
    <el-table
      :data="playList"
      :show-header="false"
      style="width: 100%"
      @row-click="rowClick"
    >
      <el-table-column type="index" width="50"> </el-table-column>
      <el-table-column prop="name"> </el-table-column>
      <el-table-column prop="author" width="160px"> </el-table-column>
      <el-table-column prop="album" width="200px"> </el-table-column>
    </el-table>
  </div>
</template>

<script>
export default {
  name: "AudioPlayList",
  props: {
    playList: {
      type: Array,
      default: null
    }
  },
  methods: {
    rowClick(row) {
      const _index = this.playList.findIndex(value => value == row);
      this.$store.commit("audio/SET_ITEM", row);
    }
  }
};
</script>

<style lang="scss" scoped>
::v-deep {
  .el-table {
    border-radius: 10px;
    // background-color: rgba(0, 0, 0, 0.8);

    th,
    tr {
      // background-color: rgba(0, 0, 0, 0.8);
    }

    td,
    th {
      padding: 8px 0;
    }
  }

  .el-table__body-wrapper {
    min-height: calc(100vh - 100px);
  }
}
</style>
