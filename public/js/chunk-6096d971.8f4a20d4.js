(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-6096d971"],{4581:function(e,a,t){"use strict";t.r(a);var n=function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("div",[t("table-component",{attrs:{model:e.model}})],1)},c=[],r=t("462e"),i=t("9bef"),o={name:"LeadsBackupView",components:{TableComponent:r["a"]},data:function(){return{model:i["a"]}}},b=o,l=t("2877"),u=Object(l["a"])(b,n,c,!1,null,"1cd3f91a",null);a["default"]=u.exports},"606b":function(e,a,t){"use strict";t.d(a,"a",(function(){return s}));var n=t("bee2"),c=t("d4ec"),r=t("257e"),i=t("262e"),o=t("2caf"),b=t("ade3"),l=(t("99af"),t("326b")),u=t("fefb"),s=function(e){Object(i["a"])(t,e);var a=Object(o["a"])(t);function t(){var e;Object(c["a"])(this,t);for(var n=arguments.length,i=new Array(n),o=0;o<n;o++)i[o]=arguments[o];return e=a.call.apply(a,[this].concat(i)),Object(b["a"])(Object(r["a"])(e),"endpoint","lead_channels"),Object(b["a"])(Object(r["a"])(e),"fields",[new u["a"]("id","Código").disabled().noFilterable(),new u["a"]("name","Nombre")]),Object(b["a"])(Object(r["a"])(e),"clone",(function(){return t})),e}return Object(n["a"])(t)}(l["a"])},"9a2d":function(e,a,t){"use strict";t.d(a,"a",(function(){return d}));var n=t("bee2"),c=t("d4ec"),r=t("257e"),i=t("262e"),o=t("2caf"),b=t("ade3"),l=(t("99af"),t("326b")),u=t("fefb"),s=t("c37f"),d=function(e){Object(i["a"])(t,e);var a=Object(o["a"])(t);function t(){var e;Object(c["a"])(this,t);for(var n=arguments.length,i=new Array(n),o=0;o<n;o++)i[o]=arguments[o];return e=a.call.apply(a,[this].concat(i)),Object(b["a"])(Object(r["a"])(e),"endpoint","lead_statuses"),Object(b["a"])(Object(r["a"])(e),"fields",[new u["a"]("id","Código").disabled().noFilterable(),new u["a"]("name","Nombre"),new u["a"]("color","Color","color"),new u["a"]("order","Orden","number"),new s["a"]("cancelled_status","Estado cancelado")]),Object(b["a"])(Object(r["a"])(e),"clone",(function(){return t})),e}return Object(n["a"])(t)}(l["a"])},"9bef":function(e,a,t){"use strict";t.d(a,"a",(function(){return w}));var n=t("bee2"),c=t("d4ec"),r=t("257e"),i=t("262e"),o=t("2caf"),b=t("ade3"),l=(t("99af"),t("326b")),u=t("fefb"),s=t("c37f"),d=t("f9b9"),f=t("9a2d"),j=t("3779"),O=t("606b"),w=function(e){Object(i["a"])(t,e);var a=Object(o["a"])(t);function t(){var e;Object(c["a"])(this,t);for(var n=arguments.length,i=new Array(n),o=0;o<n;o++)i[o]=arguments[o];return e=a.call.apply(a,[this].concat(i)),Object(b["a"])(Object(r["a"])(e),"endpoint","leads"),Object(b["a"])(Object(r["a"])(e),"related",["lead_channel","lead_status","user"]),Object(b["a"])(Object(r["a"])(e),"fields",[new u["a"]("id","Código").disabled().noFilterable(),new u["a"]("first_name","Nombre"),new u["a"]("last_name","Apellido(s)"),new u["a"]("email","Correo"),new u["a"]("phone","Teléfono","tel"),new s["a"]("is_agency","Agencia").hide(),new s["a"]("is_mini_vacs","Mini vacs"),new d["a"]("lead_channel","Canal de contacto",O["a"],"name"),new u["a"]("campaign","Campaña"),new u["a"]("destination","Destino"),new u["a"]("desirable_date","Fecha deseada de viaje","date"),new d["a"]("lead_status","Estado",f["a"],"name"),new d["a"]("user","Usuario",j["a"],"username").disabled()]),Object(b["a"])(Object(r["a"])(e),"clone",(function(){return t})),e}return Object(n["a"])(t)}(l["a"])},c37f:function(e,a,t){"use strict";t.d(a,"a",(function(){return s}));var n=t("d4ec"),c=t("bee2"),r=t("257e"),i=t("262e"),o=t("2caf"),b=t("ade3"),l=(t("d3b7"),t("25f0"),t("fefb")),u=t("8bb7"),s=function(e){Object(i["a"])(t,e);var a=Object(o["a"])(t);function t(e,c){var i,o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"";return Object(n["a"])(this,t),i=a.call(this,e,c,"number",o),Object(b["a"])(Object(r["a"])(i),"options",[{value:0,text:"No"},{value:1,text:"Si"}]),Object(b["a"])(Object(r["a"])(i),"getComponent",(function(){return u["a"]})),Object(b["a"])(Object(r["a"])(i),"getText",(function(e){return e&&"1"===e.toString()?"Si":"No"})),i}return Object(c["a"])(t,[{key:"values",value:function(){return this.options}},{key:"getUserValue",value:function(){var e=this.getText(this.originalValue);return this.mask?this.mask(e):e}}]),t}(l["a"])}}]);
//# sourceMappingURL=chunk-6096d971.8f4a20d4.js.map