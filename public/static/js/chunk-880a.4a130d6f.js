(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-880a"],{Oplo:function(e,t,n){"use strict";n.r(t);var a=n("itRl"),l=n("rfXi"),i=n.n(l),r=n("Kw5r");function o(e,t,n,a,l){var s=[],c=[];return i()(e).forEach(function(e){void 0===e._expanded&&r.default.set(e,"_expanded",t);var i=1;if(void 0!==a&&null!==a&&(i=a+1),r.default.set(e,"_level",i),n?(r.default.set(e,"parent",n),s[i]||(s[i]=0),r.default.set(e,"_marginLeft",s[i]+n._marginLeft),r.default.set(e,"_width",e[l]/n[l]*n._width),s[i]+=e._width):(s[e.id]=[],s[e.id][i]=0,r.default.set(e,"_marginLeft",0),r.default.set(e,"_width",1)),c.push(e),e.children&&e.children.length>0){var d=o(e.children,t,e,i,l);c=c.concat(d)}}),c}var s={name:"CustomTreeTableDemo",components:{treeTable:a.a},data:function(){return{func:o,expandAll:!1,data:[{id:1,event:"事件1",timeLine:100,comment:"无",children:[{id:2,event:"事件2",timeLine:10,comment:"无"},{id:3,event:"事件3",timeLine:90,comment:"无"}]},{id:1,event:"事件1",timeLine:100,comment:"无",children:[{id:2,event:"事件2",timeLine:10,comment:"无"},{id:3,event:"事件3",timeLine:90,comment:"无"}]}],args:[null,null,"timeLine"]}},methods:{message:function(e){this.$message.info(e.event)}}},c=n("KHd+"),d=Object(c.a)(s,function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"app-container"},[n("el-tag",{staticStyle:{"margin-bottom":"20px"}},[n("a",{attrs:{href:"https://github.com/PanJiaChen/vue-element-admin/tree/master/src/components/TreeTable",target:"_blank"}},[e._v("Documentation")])]),e._v(" "),n("tree-table",{attrs:{data:e.data,"eval-func":e.func,"eval-args":e.args,"expand-all":e.expandAll,border:""}},[n("el-table-column",{attrs:{label:"事件"},scopedSlots:e._u([{key:"default",fn:function(t){return[n("span",{staticStyle:{color:"sandybrown"}},[e._v(e._s(t.row.event))]),e._v(" "),n("el-tag",[e._v(e._s(t.row.timeLine+"ms"))])]}}])}),e._v(" "),n("el-table-column",{attrs:{label:"时间线"},scopedSlots:e._u([{key:"default",fn:function(e){return[n("el-tooltip",{attrs:{content:e.row.timeLine+"ms",effect:"dark",placement:"left"}},[n("div",{staticClass:"processContainer"},[n("div",{staticClass:"process",style:{width:500*e.row._width+"px",background:e.row._width>.5?"rgba(233,0,0,.5)":"rgba(0,0,233,0.5)",marginLeft:500*e.row._marginLeft+"px"}},[n("span",{staticStyle:{display:"inline-block"}})])])])]}}])}),e._v(" "),n("el-table-column",{attrs:{label:"操作",width:"200"},scopedSlots:e._u([{key:"default",fn:function(t){return[n("el-button",{attrs:{type:"text"},on:{click:function(n){e.message(t.row)}}},[e._v("点击")])]}}])})],1)],1)},[],!1,null,null,null);d.options.__file="customTreeTable.vue";t.default=d.exports},jr1U:function(e,t,n){e.exports={default:n("wObO"),__esModule:!0}},wObO:function(e,t){e.exports=function(){return Function.call.apply(Array.prototype.concat,arguments)}}}]);