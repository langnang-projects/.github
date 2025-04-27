<template>
  <el-header>
    <el-row :gutter="20" style="margin-top: 10px">
      <el-col :span="12" :offset="6">
        <el-badge :value="0" style="width: 100%">
          <el-input circle placeholder="请输入内容" clearable></el-input>
        </el-badge>
      </el-col>
      <el-col :span="6" style="display: flex; align-items: center; justify-content: flex-end">
        <el-button size="mini" icon="el-icon-check" circle></el-button>
        <el-upload action="" :show-file-list="false" accept="application/json" style="margin: 0 10px">
          <el-button size="mini" type="primary" icon="el-icon-upload2" circle></el-button>
        </el-upload>
        <el-button size="mini" type="primary" icon="el-icon-download" circle></el-button>
        <el-button size="mini" type="primary" icon="el-icon-plus" circle @click="handleInsert"></el-button>
        <el-button size="mini" type="danger" icon="el-icon-delete" circle></el-button>
        <el-avatar style="margin-left: 10px"></el-avatar>
      </el-col>
    </el-row>
  </el-header>
  <LayoutHeaderDialog v-bind="dialog" />
</template>
<script>
import LayoutHeaderDialog from './dialog.vue';
export default {
  name: 'LayoutHeader',
  components: {
    LayoutHeaderDialog,
  },
  data() {
    return {
      dialog: {
        visible: false,
      },
    };
  },
  methods: {
    handleInsert() {
      this.dialog.visible = true;
    },
  },
};
</script>
