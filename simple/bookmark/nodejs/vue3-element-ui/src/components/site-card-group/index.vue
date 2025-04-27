<template>
  <div class="site-group">
    <slot></slot>
  </div>
</template>
<script>
export default {
  name: 'SiteCardGroup',
  date() {
    return {}
  }
}
</script>
<style lang="scss">
.site-group {
  padding: 10px;
  .site {
    margin-bottom: 10px;
  }
}
</style>
