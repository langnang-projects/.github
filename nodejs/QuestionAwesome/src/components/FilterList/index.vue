<template>
    <div class="filter-list">
        Filter-List：
        <el-checkbox-group v-model="city">
            <el-checkbox-button v-for="city in cities" :label="city" :key="city">{{city}}</el-checkbox-button>
        </el-checkbox-group>
    </div>
</template>

<script>
export default {
    data() {
        return {
            city: [],
            cities: ["一年级", "二年级上", "三年级上", "四年级上"]
        };
    }
};
</script>
<style lang="scss">
.filter-list {
    .el-checkbox-button {
        margin-right: 10px;
        &:first-child {
            // margin-left: 10px;
        }
        .el-checkbox-button__inner {
            border-radius: 0.5em !important;
            padding: 6px 12px;
        }
    }
}
</style>