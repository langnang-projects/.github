<template>
  <el-dialog title="新建表单收集册" v-model="is_visible" width="90%">
    <el-steps :active="step" finish-status="success" align-center>
      <el-step title="新建收集册"></el-step>
      <el-step title="新建表单">
        <el-form ref="form"></el-form>
      </el-step>
      <el-step title="新建单元视图">
        <el-form ref="view"></el-form>
      </el-step>
    </el-steps>
    <el-form v-if="step === 0" ref="collection" label-width="80px">
      <el-form-item label="标题"></el-form-item>
      <el-form-item label="图标"></el-form-item>
      <el-form-item label="键值"></el-form-item>
      <el-form-item label="描述"></el-form-item>
    </el-form>
    <ElFormBuilder v-if="step === 1" />
    <template v-slot:footer>
      <el-button v-if="step < 2" type="primary" @click="handleNextStep">下一步</el-button>
      <el-button v-else type="primary">提交</el-button>
      <el-button>取消</el-button>
    </template>
  </el-dialog>
</template>

<script>
import ElFormBuilder from '@/components/form-builder/src/form-builder.vue';
export default {
  name: 'LayoutHeaderDialog',
  components: {
    ElFormBuilder,
  },
  props: {
    visible: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      is_visible: this.visible,
      step: 0,
    };
  },
  watch: {
    visible: {
      handler(val) {
        console.log(val);
        this.is_visible = val;
      },
    },
  },
  computed: {},
  methods: {
    handleNextStep() {
      this.step++;
    },
  },
};
</script>
