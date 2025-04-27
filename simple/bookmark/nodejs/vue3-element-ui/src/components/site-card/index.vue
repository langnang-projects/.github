<template>
  <el-card class="site" :class="{ selected: selected }">
    <slot name="header"></slot>
    <el-row style="position: absolute; top: 6px; right: 4px">
      <el-button size="mini" icon="el-icon-edit" circle @click.stop="$emit('update', cloneSite(site))"></el-button>
      <el-button size="mini" icon="el-icon-copy-document" circle @click.stop="$emit('copy', cloneSite(site))"></el-button>
      <el-button size="mini" type="danger" icon="el-icon-delete" circle @click.stop="$emit('delete', cloneSite(site))"></el-button>
    </el-row>
    <div class="site-header">
      <el-avatar class="site-avatar" :size="60" :src="site.avatar"></el-avatar>
      <div class="site-header-right">
        <el-link :href="site.link" target="_blank" :underline="false">
          <div class="site-title">{{ site.title }}</div>
        </el-link>
        <div class="site-tags">
          <el-tag class="site-tag" v-for="tag in site.tags" :key="tag" size="small">{{ tag }}</el-tag>
        </div>
      </div>
    </div>
    <div class="site-desc">
      <small>{{ site.desc }}</small>
    </div>
  </el-card>
</template>
<script>
export default {
  name: 'SiteCard',
  props: {
    site: Object,
    selected: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      multipleSelection: [],
    };
  },
  methods: {
    cloneSite(site) {
      const data = { ...site };
      data.tags = [...site.tags];
      return data;
    },
  },
};
</script>

<style lang="scss">
.el-card {
  position: relative;
  overflow: inherit;
  &.selected {
    border: 1px solid var(--el-color-primary);
    overflow: unset;
  }
}
.site-header {
  display: flex;
  /* justify-content: center; */
  flex-direction: row;
}
.site-avatar {
}
.site-header-right {
  width: 100%;
  margin-left: 10px;
}
.site-title {
  height: 30px;
  line-height: 30px;
  font-size: 18px;
  font-weight: 600;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.site-desc {
  margin-top: 10px;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  // -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  // height: 63px;
}
.site-tags {
  margin-top: 6px;
}
.site-tag {
  & + .site-tag {
    margin-left: 4px;
  }
}
</style>
