<template>
  <div :class="['app-header',{ mobile:isMobile }]" :style="`background:rgba(0 ,0, 0, ${Math.max(Math.min(opacity,1),0)});`">
		<a class="logo" href="/">
			<img :style="`height:${logoHeight}%;`" src="/images/icons/logo.png" />
		</a>
		<div class="menu-links">
			<a class="menu-link" v-for="(link,index) in links" :key="index" :href="link.href">{{link.title}}</a>
		</div>
	</div>
</template>

<script>
export default {
	name:"app-header",
	props:{
		opacity:{
			type:Number,
			default:0
		}
	},
	data(){
		return {
			links:[],
			scroll:0,
			bannerHeight:this.$variables.get("bannerHeight"),
			isMobile:this.$variables.get('isMobile')
		}
	},
	mounted(){
		this.getMenuLinks();
		document.addEventListener("scroll",()=>{ this.scroll = document.scrollingElement.scrollTop });
	},
	computed:{
		logoHeight(){
			return Math.min((this.scroll*100)/this.bannerHeight,100);
		}
	},
	methods:{
		getMenuLinks(){
			return axios
				.get("/Api/getMenuLinks")
				.then((response)=>{
					this.links = response.data;
				})
				.catch(console.error);
		}
	}
}
</script>

<style lang="scss">
.app-header{
	display: flex;
  position: sticky;
  top: 0;
  width: 100%;
  height: var( --header-height);
  backdrop-filter: blur(15px);
  z-index: 2;
  &.mobile{
    backdrop-filter: none;
    background-color: #000000 !important;
		top:-1px;
		font-size: var(--font-size);
		.logo{
			padding: 15px;
		}
  }
	.logo{
		display: flex;
		height: 100%;
		padding: 6px;
		cursor: pointer;
		transition: padding 0.1s ease-in-out;
		align-items: center;
    justify-content: center;
		&:hover{
			padding: 3px;
		}
		img{
			height: 100%;
		}
	}
	.menu-links{
		display: flex;
		align-items: center;
		justify-content: space-between;
		color: white;
    .menu-link{
      margin: 0 20px;
			user-select: none;
    }
	}
}
</style>