<template>
  <div class="app-header">
		<a class="logo" href="/">
			<img src="/images/icons/logo.png" />
		</a>
		<div class="menu-links">
			<a v-for="(link,index) in links" :key="index" :href="link.href">{{link.title}}</a>
		</div>
	</div>
</template>

<script>
export default {
	name:"app-header",
	data(){
		return {
			links:[]
		}
	},
	mounted(){
		this.getMenuLinks();
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
	width:100%;
	height: var(--header-height);
	background: black;
	.logo{
		display: block;
		height: 100%;
		width: min-content;
		padding: 6px;
		cursor: pointer;
		transition: padding 0.1s ease-in-out;
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
	}
}
</style>