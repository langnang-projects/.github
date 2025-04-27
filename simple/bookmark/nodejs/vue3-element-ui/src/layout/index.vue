<template>
  <el-container>
    <el-main>
      <LayoutHeader />
      <el-tabs type="border-card" stretch>
        <el-tab-pane lazy v-for="tab in tabs" :key="tab.key">
          <template v-slot:label>
            <i :class="tab.icon"></i>
            {{ tab.label }}
          </template>
          <el-container>
            <el-header>
              <el-row :gutter="20">
                <el-col :span="12" :offset="6">
                  <el-input placeholder="请输入内容"></el-input>
                </el-col>
                <el-col :span="6" style="display: flex; align-items: center; justify-content: flex-end">
                  <el-button size="mini" icon="el-icon-check" circle></el-button>
                  <el-upload action="" :show-file-list="false" accept="application/json" style="margin: 0 10px">
                    <el-button size="mini" icon="el-icon-upload2" circle></el-button>
                  </el-upload>
                  <el-button size="mini" icon="el-icon-download" circle></el-button>
                  <el-button size="mini" icon="el-icon-plus" circle></el-button>
                  <el-button size="mini" icon="el-icon-delete" circle></el-button>
                  <el-button size="mini" icon="el-icon-setting" circle></el-button>
                </el-col>
              </el-row>
              {{ tab.label }}
            </el-header>
            <el-main>
              <el-row :gutter="20">
                <el-col :span="4">
                  <el-empty description="暂无标签"></el-empty>
                </el-col>
                <el-col :span="16">
                  <el-empty description="暂无数据"></el-empty>
                </el-col>
              </el-row>
            </el-main>
          </el-container>
        </el-tab-pane>
      </el-tabs>
    </el-main>
  </el-container>
</template>
<script>
import LayoutHeader from './header';
export default {
  name: 'Layout',
  components: { LayoutHeader },
  data() {
    return {
      tabs: [
        { key: 'bookmark', label: '书签', icon: 'el-icon-date', description: '', form: '', card: '' },
        { key: 'article', label: '文章', icon: 'el-icon-date', description: '', form: '', card: '' },
        { key: 'book', label: '书籍', icon: 'el-icon-date', description: '', form: '', card: '' },
        { key: 'todo', label: '代办事项', icon: 'el-icon-date', description: '', form: '', card: '' },
      ],
    };
  },
  methods: {
    handleSetTab(tab) {
      console.log('handleSetTab', tab);
    },
  },
};
</script>
<style lang="scss" scoped>
.el-tabs__item {
  .el-button {
    display: none;
    position: absolute;
    top: 0;
    right: 10px;
    padding: 0;
    font-size: 20px;
  }
  &.is-active .el-button {
    display: block;
  }
}
</style>
