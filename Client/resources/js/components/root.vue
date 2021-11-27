<template>
  <div class="app">
		<div class="page-contents">
			<app-header></app-header>
			<router-view></router-view>
		</div>
		<app-footer></app-footer>
  </div>
</template>

<script>
import AppFooter from './app-footer.vue'
import AppHeader from "./app-header.vue"
export default {
	name:"root",
	components:{
		AppHeader,
		AppFooter,
	}
}
</script>

<style lang="scss">
body{
	margin: 0px;
}
.app{
	height: 100vh;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
}
</style>