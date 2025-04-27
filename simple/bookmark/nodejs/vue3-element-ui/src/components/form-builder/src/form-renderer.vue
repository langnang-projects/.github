<template>
  <el-form v-bind="formAttrs"></el-form>
</template>
<script>
export default {
  name: 'ElFormRenderer',
  data() {
    return {
      formAttrs: {},
    };
  },
};
</script>
