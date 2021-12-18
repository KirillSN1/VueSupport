<template>
  <div class="app">
		<div class="header">
			<div class="link">
				<a href="/">Главная</a>
			</div>
			<div class="link">
				<a href="/articles">Редактирование статей</a>
			</div>
			<div v-if="profile" class="ligin-info">
				<div class="name">{{profile.name||profile.email}}</div>
				<a href="/logout">Выйти</a>
			</div>
		</div>
		<router-view></router-view>
  </div>
</template>

<script>
export default {
	name:"app",
	data(){
		return{
			profile:null
		}
	},
	beforeMount(){
		this.getProfile().then(p=>this.profile=p);
	},
	methods:{
		async getProfile(){
			return await axios.get("/Api/getProfile").then(({data})=>data);
		}
	}
}
</script>

<style lang="scss">
body{
	margin: 0;
}
.header{
	display: flex;
	min-height: 30px;
	background: rgb(223, 223, 223);
	.link{
		display: flex;
		align-items: center;
		margin: 5px;
		width: auto;
		background: transparent;
	}
}
.ligin-info{
	margin-left: auto;
	margin-right: 10px;
	display: flex;
	align-items: center;
	.name{
		margin-right: 15px;
	}
}
</style>