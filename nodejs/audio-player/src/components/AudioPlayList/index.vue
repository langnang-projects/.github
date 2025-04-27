<template>
  <el-row :gutter="10" style="margin:0">
    <el-col
      :span="4"
      v-for="item in list"
      :key="item.id"
      :xs="24"
      :sm="12"
      :md="8"
      :lg="4"
      :xl="3"
    >
      <router-link :to="'list?id=' + item.id">
        <el-card :body-style="{ padding: '0px' }">
          <img :src="item.cover" style="width:100%" />
          <span>{{ item.name }}</span>
        </el-card>
      </router-link>
    </el-col>
  </el-row>
</template>
<script>
export default {
  name: "AudioPlayList",
  props: {
    list: {}
  },
  data() {}
};
</script>
