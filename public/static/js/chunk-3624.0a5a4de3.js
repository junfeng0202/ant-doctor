(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-3624"],{Wi0r:function(t,e,i){"use strict";i.d(e,"c",function(){return n}),i.d(e,"b",function(){return a}),i.d(e,"e",function(){return r}),i.d(e,"a",function(){return l}),i.d(e,"d",function(){return d});var o=i("t3Un");function n(t){return Object(o.a)({url:"/material/course/list",method:"get",params:t})}function a(t){return Object(o.a)({url:"/material/course/info/"+t,method:"get"})}function r(t){return Object(o.a)({url:"/material/course/sections/"+t,method:"get"})}function l(t,e){return Object(o.a)({url:"/material/course/section/add/"+t,method:"post",params:e})}function d(t){return Object(o.a)({url:"/material/course/create",method:"post",params:t})}},jr1U:function(t,e,i){t.exports={default:i("wObO"),__esModule:!0}},s7Uw:function(t,e,i){"use strict";i.r(e);var o=i("EJiy"),n=i.n(o),a=i("itRl"),r=i("rfXi"),l=i.n(r),d=i("Kw5r");function s(t,e,i,o,n){var a=[],r=[];return l()(t).forEach(function(t){void 0===t._expanded&&d.default.set(t,"_expanded",e);var l=1;if(void 0!==o&&null!==o&&(l=o+1),d.default.set(t,"_level",l),i?(d.default.set(t,"parent",i),a[l]||(a[l]=0),d.default.set(t,"_marginLeft",a[l]+i._marginLeft),d.default.set(t,"_width",t[n]/i[n]*i._width),a[l]+=t._width):(a[t.id]=[],a[t.id][l]=0,d.default.set(t,"_marginLeft",0),d.default.set(t,"_width",1)),r.push(t),t.children&&t.children.length>0){var u=s(t.children,e,t,l,n);r=r.concat(u)}}),r}var u=i("Wi0r"),c={name:"sections",components:{treeTable:a.a},data:function(){return{loding:{zhangform:!1},listLoading:!1,courseId:0,func:s,expandAll:!1,form:{zhang:{id:0,pid:0,title:""},jie:{id:0,pid:"",source_id:"",duration:"",title:""}},dialog:{zhang:!1,jie:!1},data:[{id:1,pid:0,title:"第一章",source_id:0xb38bfd8bbe2,duration:12,comment:"无",children:[{id:2,pid:1,title:"第一节",source_id:0xb38bfd8bbe2,duration:12},{id:3,pid:1,title:"第二节",source_id:0xb38bfd8bbe2,duration:12}]},{id:4,pid:0,title:"第二章",source_id:0xb38bfd8bbe2,duration:12,children:[{id:5,pid:4,title:"第一节",source_id:0xb38bfd8bbe2,duration:12},{id:6,pid:4,title:"第一节",source_id:0xb38bfd8bbe2,duration:12}]}],args:[null,null,"timeLine"]}},created:function(){this.courseId=this.$route.params&&this.$route.params.id,this.getList()},methods:{message:function(t){console.log(t),this.$message.info(t.title)},getList:function(){var t=this;this.listLoading=!0,Object(u.e)(this.courseId).then(function(e){var i=e.data;t.data=i.data,t.listLoading=!1,t.defultZhangForm()})},addZhang:function(){this.defultZhangForm(),this.dialog.zhang=!0},addJie:function(t){this.defultJieForm(),this.form.jie.pid=t.id,this.dialog.jie=!0},editJie:function(t){this.form.jie={id:t.id,pid:t.pid,source_id:t.source_id,duration:t.duration,title:t.title},this.dialog.jie=!0},editZhang:function(t){this.form.zhang={id:t.id,pid:0,title:t.title},this.dialog.zhang=!0},zhangForm:function(){var t=this;console.log(this.form.zhang),this.loding.zhangform=!0,Object(u.a)(this.courseId,this.form.zhang).then(function(e){200==e.data.code&&(t.$message({message:"课程章添加成功，请在改章下面添加小节。",type:"success"}),t.loding.zhangform=!1,t.dialog.zhang=!1,t.getList())})},jieForm:function(){console.log(this.form.jie),this.loding.zhangform=!0,console.log(n()(this.form.jie.duration))},defultZhangForm:function(){this.form.zhang={id:0,pid:0,title:""}},defultJieForm:function(){this.form.jie={id:0,pid:"",source_id:"",duration:"",title:""}}}},f=i("KHd+"),m=Object(f.a)(c,function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"app-container"},[i("el-tag",{staticStyle:{"margin-bottom":"20px"}},[i("a",{attrs:{href:"https://github.com/PanJiaChen/vue-element-admin/tree/master/src/components/TreeTable",target:"_blank"}},[t._v("哈哈哈")])]),t._v(" "),i("el-button",{attrs:{type:"primary"},on:{click:function(e){t.addZhang()}}},[t._v("添加章"),i("i",{staticClass:"el-icon-plus el-icon--right"})]),t._v(" "),i("tree-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],attrs:{data:t.data,"eval-func":t.func,"eval-args":t.args,"expand-all":t.expandAll,border:""}},[i("el-table-column",{attrs:{label:"标题"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n       "+t._s(e.row.title)+"\n        ")]}}])}),t._v(" "),i("el-table-column",{attrs:{label:"视频ID"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n       "+t._s(e.row.source_id)+"\n        ")]}}])}),t._v(" "),i("el-table-column",{attrs:{label:"视频时长"},scopedSlots:t._u([{key:"default",fn:function(e){return[i("el-tag",[t._v(t._s(e.row.duration))])]}}])}),t._v(" "),i("el-table-column",{attrs:{label:"操作",width:"200"},scopedSlots:t._u([{key:"default",fn:function(e){return[0==e.row.pid?i("el-button",{attrs:{type:"text"},on:{click:function(i){t.editZhang(e.row)}}},[t._v("编辑章")]):t._e(),t._v(" "),0==e.row.pid?i("el-button",{attrs:{type:"text"},on:{click:function(i){t.addJie(e.row)}}},[t._v("添加节")]):t._e(),t._v(" "),0!=e.row.pid?i("el-button",{attrs:{type:"text"},on:{click:function(i){t.editJie(e.row)}}},[t._v("编辑节")]):t._e()]}}])})],1),t._v(" "),i("el-dialog",{attrs:{title:"添加章",visible:t.dialog.zhang},on:{"update:visible":function(e){t.$set(t.dialog,"zhang",e)}}},[i("el-form",{attrs:{model:t.form}},[i("el-form-item",{attrs:{label:"章名称","label-width":"100px"}},[i("el-input",{attrs:{autocomplete:"off"},model:{value:t.form.zhang.title,callback:function(e){t.$set(t.form.zhang,"title",e)},expression:"form.zhang.title"}})],1)],1),t._v(" "),i("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[i("el-button",{on:{click:function(e){t.dialog.zhang=!1}}},[t._v("取 消")]),t._v(" "),i("el-button",{attrs:{type:"primary",loading:t.loding.zhangform},on:{click:function(e){t.zhangForm()}}},[t._v("确 定")])],1)],1),t._v(" "),i("el-dialog",{attrs:{title:"添加节",visible:t.dialog.jie},on:{"update:visible":function(e){t.$set(t.dialog,"jie",e)}}},[i("el-form",{attrs:{model:t.form}},[i("el-form-item",{attrs:{label:"节名称","label-width":"100px"}},[i("el-input",{attrs:{autocomplete:"off"},model:{value:t.form.jie.title,callback:function(e){t.$set(t.form.jie,"title",e)},expression:"form.jie.title"}})],1),t._v(" "),i("el-form-item",{attrs:{label:"视频ID","label-width":"100px"}},[i("el-input",{attrs:{autocomplete:"off"},model:{value:t.form.jie.source_id,callback:function(e){t.$set(t.form.jie,"source_id",e)},expression:"form.jie.source_id"}})],1),t._v(" "),i("el-form-item",{attrs:{label:"视频时长","label-width":"100px"}},[i("el-input",{attrs:{autocomplete:"off"},model:{value:t.form.jie.duration,callback:function(e){t.$set(t.form.jie,"duration",e)},expression:"form.jie.duration"}})],1)],1),t._v(" "),i("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[i("el-button",{on:{click:function(e){t.dialog.jie=!1}}},[t._v("取 消")]),t._v(" "),i("el-button",{attrs:{type:"primary",loading:t.loding.jieform},on:{click:function(e){t.jieForm()}}},[t._v("确 定")])],1)],1)],1)},[],!1,null,null,null);m.options.__file="sections.vue";e.default=m.exports},wObO:function(t,e){t.exports=function(){return Function.call.apply(Array.prototype.concat,arguments)}}}]);