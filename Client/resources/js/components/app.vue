<template>
  <div class="app">
		<div class="top-contents">
			<top-banner v-if="bannerHeight"
				ref="banner"
				src="/images/banners/top-banner.jpg"
				:offset="isMobile?'0px':'200px'"
				:height="bannerHeight"
				:image-height="bannerHeight+$variables.get('headerHeight')">
			</top-banner>
			<app-header :opacity="headerOpacity"></app-header>
			<router-view class="page-content" :hide-title="hidePageTitle"></router-view>
		</div>
		<app-footer></app-footer>
  </div>
</template>

<script>
import AppFooter from './app-footer.vue'
import AppHeader from './app-header.vue'
import TopBanner from './top-banner.vue'

export default {
	name:"app",
	components:{
		AppHeader,
		AppFooter,
		TopBanner,
	},
	data(){
		return{
			bannerHeight:this.$variables.get("bannerHeight"),
			scroll:0,
			headerOpacity:0,
			isMobile:this.$variables.get('isMobile')
		}
	},
	computed:{
		hidePageTitle(){
			return this.scroll>this.bannerHeight;
		},
	},
	mounted(){
		if(this.bannerHeight)
			document.addEventListener("scroll",()=>{
				this.scroll = document.scrollingElement.scrollTop;
				this.headerOpacity = this.$refs.banner.scrollProcent/100;
			});
	}
}
</script>

<style lang="scss">
body{
	margin: 0px;
	background: black;
}
.app{
	max-width: 1400px;
	margin: auto;
	min-height: 100vh;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	background: white;
	box-shadow: 0px 0px 20px 0px #7a9296;
}
.top-contents{
	.page-content{
		background: white;
		z-index: 1;
		position: relative;
		font-size: var(--font-size);
		padding: 10px;

		.page-title{
			transition: opacity 0.5s ease-in;
			&.hidden{
				opacity: 0;
			}
		}
	}
}
</style>