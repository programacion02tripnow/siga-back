(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-4c45bcdc"],{"1a20":function(e,t,a){"use strict";a.d(t,"a",(function(){return O}));var n=a("bee2"),c=a("d4ec"),o=a("257e"),i=a("262e"),r=a("2caf"),b=a("ade3"),u=(a("99af"),a("326b")),d=a("fefb"),l=a("8dd5"),s=a("c37f"),f=a("891e"),j=function(e){Object(i["a"])(a,e);var t=Object(r["a"])(a);function a(){var e;Object(c["a"])(this,a);for(var n=arguments.length,i=new Array(n),r=0;r<n;r++)i[r]=arguments[r];return e=t.call.apply(t,[this].concat(i)),Object(b["a"])(Object(o["a"])(e),"endpoint","payment_methods_additional_fields"),Object(b["a"])(Object(o["a"])(e),"fields",[new d["a"]("id","Código").disabled().noFilterable(),new d["a"]("name","Nombre"),new f["a"]("type","Tipo de campo",a.options,"1"),new s["a"]("is_required","¿Es obligatorio?")]),Object(b["a"])(Object(o["a"])(e),"clone",(function(){return a})),e}return Object(n["a"])(a)}(u["a"]);Object(b["a"])(j,"options",{1:"Campo abierto",2:"Archivo adjunto"});var O=function(e){Object(i["a"])(a,e);var t=Object(r["a"])(a);function a(){var e;Object(c["a"])(this,a);for(var n=arguments.length,i=new Array(n),r=0;r<n;r++)i[r]=arguments[r];return e=t.call.apply(t,[this].concat(i)),Object(b["a"])(Object(o["a"])(e),"endpoint","payment_methods"),Object(b["a"])(Object(o["a"])(e),"related",["payment_method_additional_fields"]),Object(b["a"])(Object(o["a"])(e),"fields",[new d["a"]("id","Código").disabled().noFilterable(),new d["a"]("name","Nombre"),new l["a"]("payment_method_additional_fields","Campos adicionales",j).hide().noFilterable()]),Object(b["a"])(Object(o["a"])(e),"clone",(function(){return a})),e}return Object(n["a"])(a)}(u["a"])},c37f:function(e,t,a){"use strict";a.d(t,"a",(function(){return l}));var n=a("d4ec"),c=a("bee2"),o=a("257e"),i=a("262e"),r=a("2caf"),b=a("ade3"),u=(a("d3b7"),a("25f0"),a("fefb")),d=a("8bb7"),l=function(e){Object(i["a"])(a,e);var t=Object(r["a"])(a);function a(e,c){var i,r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"";return Object(n["a"])(this,a),i=t.call(this,e,c,"number",r),Object(b["a"])(Object(o["a"])(i),"options",[{value:0,text:"No"},{value:1,text:"Si"}]),Object(b["a"])(Object(o["a"])(i),"getComponent",(function(){return d["a"]})),Object(b["a"])(Object(o["a"])(i),"getText",(function(e){return e&&"1"===e.toString()?"Si":"No"})),i}return Object(c["a"])(a,[{key:"values",value:function(){return this.options}},{key:"getUserValue",value:function(){var e=this.getText(this.originalValue);return this.mask?this.mask(e):e}}]),a}(u["a"])},f748:function(e,t,a){"use strict";a.r(t);var n=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("table-component",{attrs:{model:e.model}})],1)},c=[],o=a("462e"),i=a("1a20"),r={name:"PaymentMethodsView",components:{TableComponent:o["a"]},data:function(){return{model:i["a"]}}},b=r,u=a("2877"),d=Object(u["a"])(b,n,c,!1,null,"d031a364",null);t["default"]=d.exports}}]);
//# sourceMappingURL=chunk-4c45bcdc.1c597cb1.js.map