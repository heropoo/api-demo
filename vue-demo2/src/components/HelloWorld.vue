<template>
  <div class="hello">
    <!-- {{msg}} -->

    <el-form :inline="true" :model="formInline" class="demo-form-inline">
      <el-form-item label="用户名">
        <el-input v-model="formInline.user" placeholder="用户名"></el-input>
      </el-form-item>
      <!-- <el-form-item label="活动区域">
        <el-select v-model="formInline.region" placeholder="活动区域">
          <el-option label="区域一" value="shanghai"></el-option>
          <el-option label="区域二" value="beijing"></el-option>
        </el-select>
      </el-form-item> -->
      <el-form-item>
        <el-button type="primary" @click="onSubmit">查询</el-button>
      </el-form-item>
    </el-form>

    <el-table
      :data="tableData"
      style="width: 100%"
      :default-sort="{ prop: 'date', order: 'descending' }"
    >
      <el-table-column prop="date" label="日期" sortable width="180">
      </el-table-column>
      <el-table-column prop="name" label="姓名" sortable width="180">
      </el-table-column>
      <el-table-column prop="address" label="地址" :formatter="formatter">
      </el-table-column>
    </el-table>

    <div class="block">
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage3"
        :page-size="pageSize"
        layout="prev, pager, next, jumper"
        :total="total"
      >
      </el-pagination>
    </div>
  </div>
</template>

<script>
export default {
  name: "HelloWorld",
  data() {
    return {
      //msg: 'Welcome to Your Vue.js App',
      formInline: {
        user: "",
      },

      pageNo: 1,
      pageSize: 2,
      total: 1,

      currentPage1: 1,
      currentPage2: 2,
      currentPage3: 1,
      currentPage4: 1,

      tableData: [
        // {
        //   date: "2016-05-02",
        //   name: "王小虎",
        //   address: "上海市普陀区金沙江路 1518 弄",
        // },
        // {
        //   date: "2016-05-04",
        //   name: "王小虎",
        //   address: "上海市普陀区金沙江路 1517 弄",
        // },
        // {
        //   date: "2016-05-01",
        //   name: "王小虎",
        //   address: "上海市普陀区金沙江路 1519 弄",
        // },
        // {
        //   date: "2016-05-03",
        //   name: "王小虎",
        //   address: "上海市普陀区金沙江路 1516 弄",
        // },
      ],
    };
  },
  //页面加载完成之后事件
  created() {
    let vueThis = this;
    this.$axios
      .get("/api/user", {
        params: {
          pageNo: 1,
          pageSize: 2,
          total: 4,
        },
      })
      .then(function (response) {
        console.log(response);
        if (response.data.code === 0) {
          vueThis.tableData = [];
          let dataList = response.data.data.list;
          console.log(dataList);
          for (let i = 0; i < dataList.length; i++) {
            let row = {
              date: dataList[i].id,
              name: dataList[i].username,
              address: dataList[i].phone,
            };
            vueThis.tableData.push(row);
          }
          vueThis.total = response.data.data.total;

          //console.log(vueThis.tableData)
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  },
  methods: {
    onSubmit() {
      console.log("submit!");
      console.log(this.formInline.user);
      // if(this.formInline.user.length){

      // }
      let username = this.formInline.user;
      let vueThis = this;
      this.$axios
        .get("/api/user", {
          params: {
            pageNo: 1,
            pageSize: 2,
            name: username,
          },
        })
        .then(function (response) {
          console.log(response);
          if (response.data.code === 0) {
            vueThis.tableData = [];
            let dataList = response.data.data.list;
            console.log(dataList);
            for (let i = 0; i < dataList.length; i++) {
              let row = {
                date: dataList[i].id,
                name: dataList[i].username,
                address: dataList[i].phone,
              };
              vueThis.tableData.push(row);
            }
            vueThis.total = response.data.data.total;

            //console.log(vueThis.tableData)
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    handleSizeChange(val) {
      console.log(`每页 ${val} 条`);
    },
    handleCurrentChange(val) {
      console.log(`当前页: ${val}`);
      let username = this.formInline.user;
      let vueThis = this;
      this.$axios
        .get("/api/user", {
          params: {
            pageNo: val,
            pageSize: 2,
            name: username,
          },
        })
        .then(function (response) {
          console.log(response);
          if (response.data.code === 0) {
            vueThis.tableData = [];
            let dataList = response.data.data.list;
            console.log(dataList);
            for (let i = 0; i < dataList.length; i++) {
              let row = {
                date: dataList[i].id,
                name: dataList[i].username,
                address: dataList[i].phone,
              };
              vueThis.tableData.push(row);
            }
            //console.log(vueThis.tableData)
          }
        });
    },

    formatter(row) {
      return row.address;
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1,
h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
