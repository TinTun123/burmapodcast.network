import{r as l,d as g,A as y,u as _,o as c,c as w,a as t,w as s,v as u,x as k,b as f,f as A,q as S}from"./index-9eb7a1ab.js";const U=t("h1",{class:"modal-header mb-4 text-white/80 text-lg font-semibold text-center"},"Add new user",-1),C={class:"flex flex-col justify-center gap-y-4 mb-4"},V=t("option",{value:"",disabled:""},"user type",-1),B=t("option",{value:"1"},"CoHost",-1),D=t("option",{value:"2"},"Host",-1),F=t("option",{value:"3"},"Admin",-1),N=[V,B,D,F],T={class:"flex gap-x-4 justify-end"},j={__name:"AdduserComponent",emits:["scrollToAddShow"],setup(H,{emit:h}){const n=l(""),r=l(""),d=l(""),i=l(""),p=l(""),b=g(),v=y(),m=_();function x(){if(n.value&&r.value&&d.value&&i.value&&p.value){const a=new FormData;a.append("name",n.value),a.append("email",r.value),a.append("password",d.value),a.append("password_confirmation",i.value),a.append("level",p.value),b.register(a).then(e=>(h("scrollToAddShow"),e))}else v.showNotification("Please fill all require fields!","error")}return(a,e)=>(c(),w("div",{class:S([[f(m).name==="adminManageHosts"?"laptop:w-auto":"laptop:w-[50%]"],"w-auto m-auto z-[9999]"])},[U,t("div",C,[s(t("input",{type:"text",id:"name",name:"name","onUpdate:modelValue":e[0]||(e[0]=o=>n.value=o),class:"focus:outline-none appearance-none border border-white/40 pl-2 py-1 rounded-[10px] text-base text-white/80 focus:border-white/80 bg-transparent placeholder:text-white/40",placeholder:"Username"},null,512),[[u,n.value]]),s(t("input",{type:"mail",id:"email",name:"email","onUpdate:modelValue":e[1]||(e[1]=o=>r.value=o),class:"focus:outline-none appearance-none border border-white/40 pl-2 py-1 rounded-[10px] text-base text-white/80 focus:border-white/80 bg-transparent placeholder:text-white/40",placeholder:"Email"},null,512),[[u,r.value]]),s(t("input",{type:"password",id:"password",name:"password","onUpdate:modelValue":e[2]||(e[2]=o=>d.value=o),class:"focus:outline-none appearance-none border border-white/40 pl-2 py-1 rounded-[10px] text-base text-white/80 focus:border-white/80 bg-transparent placeholder:text-white/40",placeholder:"password"},null,512),[[u,d.value]]),s(t("input",{type:"password",id:"password_confirmation",name:"password_confirmation","onUpdate:modelValue":e[3]||(e[3]=o=>i.value=o),class:"focus:outline-none appearance-none border border-white/40 pl-2 py-1 rounded-[10px] text-base text-white/80 focus:border-white/80 bg-transparent placeholder:text-white/40",placeholder:"Confirm password"},null,512),[[u,i.value]]),s(t("select",{class:"rounded-full bg-[#2F2F2F] text-white text-sm px-2 py-1 font-semibold",name:"level",id:"level","onUpdate:modelValue":e[4]||(e[4]=o=>p.value=o)},N,512),[[k,p.value]])]),t("div",T,[f(m).name!=="adminDashboard"?(c(),w("button",{key:0,class:"modal-footer modal-default-button text-black/80 bg-white/80 hover:bg-white/60 active:bg-white/80 rounded-full px-4 py-1 float-right font-medium",onClick:e[5]||(e[5]=o=>a.$emit("scrollToAddShow"))},"Back")):A("",!0),t("button",{class:"modal-footer modal-default-button text-black/80 bg-white/80 hover:bg-white/60 active:bg-white/80 rounded-full px-4 py-1 float-right font-medium",onClick:x},"Add")])],2))}};export{j as _};
