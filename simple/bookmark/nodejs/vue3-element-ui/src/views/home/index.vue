<template>
  <Layout />
  <el-container>
    <el-main style="padding-bottom: 0">
      <el-row :gutter="20">
        <el-col :span="12" :offset="6">
          <el-badge :value="sites.length" style="width: 100%">
            <el-input circle v-model="input" placeholder="请输入内容" clearable></el-input>
          </el-badge>
        </el-col>
        <el-col :span="6" style="display: flex; align-items: center; justify-content: flex-end">
          <el-button size="mini" icon="el-icon-check" circle @click="handleSelectAllSite"></el-button>
          <el-upload action="" :show-file-list="false" accept="application/json" style="margin: 0 10px" :on-change="handleUploadOnChange">
            <el-button size="mini" type="primary" icon="el-icon-upload2" circle></el-button>
          </el-upload>
          <el-button size="mini" type="primary" icon="el-icon-download" circle @click="handleDownload"></el-button>
          <el-button size="mini" type="primary" icon="el-icon-plus" circle @click="handleInsert"></el-button>
          <el-button size="mini" type="danger" icon="el-icon-delete" circle :disabled="multiSiteSelection.length === 0" @click="handleDelete()"></el-button>
          <el-avatar style="margin-left: 10px"></el-avatar>
        </el-col>
      </el-row>
      <el-row :gutter="20" class="site-group">
        <el-col :span="4">
          <el-button v-if="tags.length > 0" size="mini" type="info" round style="width: 100%" @click="checkboxGroup1 = []">重置选中标签</el-button>
          <el-scrollbar v-if="tags.length > 0" style="width: 100%; height: calc(100vh - 108px)">
            <el-checkbox-group v-model="checkboxGroup1" size="mini">
              <el-checkbox-button v-for="city in tags" :label="city" :key="city">{{ city }}</el-checkbox-button>
            </el-checkbox-group>
          </el-scrollbar>
          <el-empty v-else description="暂无标签"></el-empty>
        </el-col>
        <el-col :span="18">
          <el-scrollbar v-if="sites.length > 0" style="width: 100%; height: calc(100vh - 80px)">
            <SiteCardGroup>
              <SiteCard v-for="site in sites" :key="site" :site="site" @click="handleClickSite(site)" @delete="handleDelete" @update="handleUpdate" @copy="handleCopy" :selected="multiSiteSelection.includes(site)" />
            </SiteCardGroup>
          </el-scrollbar>
          <el-empty v-else description="暂无数据"></el-empty>
        </el-col>
      </el-row>
    </el-main>
  </el-container>
  <el-dialog :title="dialog.title" v-model="dialog.visible" width="60%">
    <SiteForm ref="siteForm" @submit="handleSubmitForm" />
  </el-dialog>
</template>

<script>
import { mapGetters } from 'vuex';
import SiteForm from '@/components/site-form';
import SiteCardGroup from '@/components/site-card-group';
import SiteCard from '@/components/site-card';
import { saveAs } from 'file-saver';
import Layout from '@/layout';
export default {
  name: 'App',
  components: {
    SiteForm,
    SiteCardGroup,
    SiteCard,
    Layout,
  },
  computed: {
    ...mapGetters({
      mapSites: 'sites',
      tags: 'tags',
    }),
    sites() {
      return this.mapSites.filter(site => site.title.indexOf(this.input) !== -1 && (this.checkboxGroup1.length === 0 || site.tags.filter(tag => this.checkboxGroup1.indexOf(tag) > -1).length === this.checkboxGroup1.length));
    },
  },
  data() {
    return {
      input: '',
      radio1: '',
      multiSiteSelection: [],
      checkboxGroup1: [],
      tabs: [],
      dialog: {
        title: '',
        visible: false,
        form: {
          link: '',
          avatar: '',
          title: '',
          desc: '',
          sortWeight: 0,
          tags: [],
        },
        rules: {
          link: [{ required: true, message: '请输入地址', trigger: 'blur' }],
          avatar: [{ required: true, message: '请输入图标', trigger: 'blur' }],
          title: [{ required: true, message: '请输入标题', trigger: 'blur' }],
          desc: [{ required: true, message: '请输入描述', trigger: 'blur' }],
          sortWeight: [{ required: true, message: '请输入排序权重', trigger: 'blur' }],
        },
      },
    };
  },
  methods: {
    handleInsert() {
      this.dialog.title = '新增';
      this.toggleDialog();
    },
    handleSubmitForm(data) {
      const index = this.mapSites.findIndex(item => item.timestamp === data.timestamp);
      const sites = [...this.mapSites];
      if (index === -1) {
        this.$store.commit('SET_SITES', [...sites, { ...data }]);
      } else {
        sites[index] = data;
        this.$store.commit('SET_SITES', [...sites]);
      }
      this.toggleDialog();
    },
    toggleDialog() {
      if (this.$refs.siteForm) {
        this.$refs.siteForm.handleReset();
      }
      this.dialog.visible = !this.dialog.visible;
    },
    handleClickSite(site) {
      const index = this.multiSiteSelection.indexOf(site);
      if (index === -1) {
        this.multiSiteSelection.splice(this.multiSiteSelection.length - 1, 0, site);
      } else {
        this.multiSiteSelection.splice(index, 1);
      }
    },
    handleDelete(sites) {
      if (!sites) {
        sites = this.multiSiteSelection;
      } else {
        sites = [sites];
      }
      this.$confirm('此操作将永久删除所选内容, 是否继续?', '确认信息', {
        confirmButtonText: '确认',
        cancelButtonText: '取消',
        type: 'warning',
      })
        .then(() => {
          this.$store.commit(
            'SET_SITES',
            this.mapSites.filter(item => !sites.includes(item))
          );
          this.$message.success('操作成功');
        })
        .catch(() => {
          this.$message.success('操作取消');
        });
    },
    handleUpdate(item) {
      const data = { ...item };
      this.dialog.title = '修改';
      this.$nextTick(() => {
        this.$refs.siteForm.handleSet(data);
      });
      this.toggleDialog();
    },
    handleCopy(item) {
      const data = { ...item };
      this.dialog.title = '复制';
      this.toggleDialog();
      this.$nextTick(() => {
        delete data.timestamp;
        this.$refs.siteForm.handleSet(data);
      });
    },
    handleSelectAllSite() {
      this.multiSiteSelection = [...this.sites];
    },
    handleDownload() {
      this.$confirm('此操作将下载所有内容, 是否继续?', '确认信息', {
        confirmButtonText: '确认',
        cancelButtonText: '取消',
        type: 'warning',
      })
        .then(() => {
          const str = new Blob([JSON.stringify(this.mapSites)], { type: 'text/plain;charset=ytf-8' });
          saveAs(str, `simple-bookmark.${new Date().getTime()}.json`);
        })
        .catch(() => {
          this.$message.success('操作取消');
        });
    },
    handleUploadOnChange(file, fileList) {
      if (fileList.length === 0) return;
      console.log(file, fileList);
      const reader = new FileReader();
      reader.readAsText(file.raw, 'utf-8');
      reader.onload = evt => {
        const fileString = evt.target.result;
        console.log(this.mapSites, JSON.parse(fileString));
        console.log([...this.mapSites, ...JSON.parse(fileString)]);
        this.$store.commit('SET_SITES', [...this.mapSites, ...JSON.parse(fileString)]);
      };
    },
    // hanldeUpdate() { },
  },
};
</script>

<style lang="scss">
body {
  margin: 0;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  color: #2c3e50;
  /* margin-top: 60px; */
}
.el-checkbox-button {
  margin-right: 4px;
  margin-top: 4px;
  .el-checkbox-button__inner {
    border: 1px solid #dcdfe6;
    border-radius: 4px !important;
  }
}
.site-group {
  .site {
    margin-bottom: 10px;
  }
}
</style>
