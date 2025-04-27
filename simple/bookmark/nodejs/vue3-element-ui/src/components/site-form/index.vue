<template>
  <el-form ref="form" :model="form" :rules="rules" label-width="100px">
    <el-form-item label="地址" prop="link">
      <template v-slot:label>
        地址
        <el-tooltip effect="dark" content="地址" placement="right"><i class="el-icon-info"></i></el-tooltip>
      </template>
      <el-input v-model="form.link"></el-input>
    </el-form-item>
    <el-form-item label="标题" prop="title">
      <template v-slot:label>
        标题
        <el-tooltip effect="dark" content="标题" placement="right"><i class="el-icon-info"></i></el-tooltip>
      </template>
      <el-input v-model="form.title"></el-input>
    </el-form-item>
    <el-form-item label="图标" prop="avatar">
      <template v-slot:label>
        图标
        <el-tooltip effect="dark" content="图标" placement="right"><i class="el-icon-info"></i></el-tooltip>
      </template>
      <el-input v-model="form.avatar"></el-input>
    </el-form-item>
    <el-form-item label="描述" prop="desc">
      <template v-slot:label>
        描述
        <el-tooltip effect="dark" content="描述" placement="right"><i class="el-icon-info"></i></el-tooltip>
      </template>
      <el-input type="textarea" v-model="form.desc"></el-input>
    </el-form-item>
    <el-form-item label="排序" prop="sortWeight">
      <template v-slot:label>
        排序
        <el-tooltip effect="dark" content="排序权重，值越大越靠前" placement="right"><i class="el-icon-info"></i></el-tooltip>
      </template>
      <el-input v-model="form.sortWeight" type="number" placeholder="排序权重值，值越大越靠前"></el-input>
    </el-form-item>
    <el-form-item label="标签" prop="tags">
      <template v-slot:label>
        标签
        <el-tooltip effect="dark" content="标签" placement="right"><i class="el-icon-info"></i></el-tooltip>
      </template>
      <div class="site-tags" style="display: inline">
        <el-tag class="site-tag" v-for="tag in form.tags" :key="tag" closable :disable-transitions="false" @close="handleCloseTag(tag)">
          {{ tag }}
        </el-tag>
      </div>
      <el-select v-if="tagVisible" v-model="tag" allow-create filterable placeholder="请选择标签" @change="handleChangeSelect">
        <el-option v-for="tag in tags" :key="tag" :label="tag" :value="tag"></el-option>
      </el-select>
      <el-button v-else size="small" @click="handleShowTagSelect">+ New Tag</el-button>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="handleSubmit">提交</el-button>
      <el-button @click="handleReset">重置</el-button>
    </el-form-item>
  </el-form>
</template>
<script>
import { mapGetters } from 'vuex';
export default {
  name: 'SiteForm',
  props: {
    value: Object,
  },
  computed: {
    ...mapGetters({
      tags: 'tags',
    }),
  },
  data() {
    return {
      tagVisible: false,
      tag: '',
      form: {
        link: '',
        avatar: '',
        title: '',
        desc: '',
        sortWeight: 0,
        tags: [],
        timestamp: 0,
      },
      rules: {
        link: [{ required: true, message: '请输入地址', trigger: 'blur' }],
        avatar: [{ required: true, message: '请输入图标', trigger: 'blur' }],
        title: [{ required: true, message: '请输入标题', trigger: 'blur' }],
        desc: [{ required: true, message: '请输入描述', trigger: 'blur' }],
        sortWeight: [{ required: true, message: '请输入排序权重', trigger: 'blur' }],
      },
    };
  },
  methods: {
    // 关闭标签
    handleCloseTag(tag) {
      this.form.tags.splice(this.form.tags.indexOf(tag), 1);
    },
    // 表单提交
    handleSubmit() {
      this.$refs.form.validate(valid => {
        if (!valid) return false;
        this.$emit('submit', {
          ...this.form,
          timestamp: this.form.timestamp ? this.form.timestamp : new Date().getTime(),
        });
      });
    },
    handleSet(item = {}) {
      this.form = { ...this.form, ...item };
    },
    // 表单重置
    handleReset() {
      this.$refs.form.resetFields();
      this.form.timestamp = 0;
      this.$emit('reset');
    },
    // 显示标签选择框
    handleShowTagSelect() {
      this.tagVisible = true;
    },
    // 选中标签选择框
    handleChangeSelect(val) {
      this.form.tags = [...new Set([...this.form.tags, ...val.split(',')])];
      this.tag = '';
      this.tagVisible = false;
    },
  },
};
</script>

<style lang="scss"></style>
