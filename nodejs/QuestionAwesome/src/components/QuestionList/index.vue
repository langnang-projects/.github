<template>
    <div class="question-list">
        <el-card shadow="hover" style="margin-top:0;">
            <p class="question-title">{{list.length}} questions proposed</p>
        </el-card>
        <router-link
            :to="'?id=' + o.id"
            v-for="o in list"
            :key="o.id"
            :class="{active:o.id==$route.query.id}"
        >
            <el-card shadow="hover">
                <el-row>
                    <el-col :span="4" class="question-difficulty">
                        <!-- <font-awesome-icon :icon="o.difficulty>0?['fas','star']:['far','star']"></font-awesome-icon> -->
                        <font-awesome-icon v-if="o.difficulty == 0" :icon="['far', 'star']"></font-awesome-icon>
                        <font-awesome-icon v-if="o.difficulty > 0" :icon="['fas', 'star']"></font-awesome-icon>
                        <font-awesome-icon v-if="o.difficulty > 1" :icon="['fas', 'star']"></font-awesome-icon>
                        <font-awesome-icon v-if="o.difficulty > 2" :icon="['fas', 'star']"></font-awesome-icon>
                        <font-awesome-icon v-if="o.difficulty > 3" :icon="['fas', 'star']"></font-awesome-icon>
                        <font-awesome-icon v-if="o.difficulty > 4" :icon="['fas', 'star']"></font-awesome-icon>
                    </el-col>
                    <el-col :span="20">
                        <p class="question-title">{{ o.title }}</p>
                        <!-- <p class="question-info">{{ o.description }}</p> -->
                    </el-col>
                </el-row>
            </el-card>
        </router-link>
    </div>
</template>
<script>
export default {
    data() {
        return {};
    },
    mounted() {
        console.log(this);
        console.log(this.$route);
    },
    computed: {
        list() {
            return this.$store.getters.getQuestionList(this.$route.params.type);
        }
    }
};
</script>
<style lang="scss">
.question-list {
    .router-link-exact-active {
        background-color: #44337a;
        .el-card {
            background-color: #44337a !important;
        }
    }
    .el-card {
        background-color: #2d3748 !important;
        margin-top: 20px;
        &:hover {
            background-color: #4a5568 !important;
        }
    }
    .question-difficulty {
        // color: red;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 10px;
        height: 20px;
    }
    .question-title {
        padding: 0;
        margin: 0;
        font-size: 16px;
        line-height: 20px;
    }
    .question-info {
        padding: 0;
        margin: 0;
        font-size: 12px;
    }
}
</style>
