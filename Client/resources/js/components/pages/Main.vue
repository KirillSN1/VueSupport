<template>
  <div class="main">
		<div style="display:flex;">
			<div class="vertical-menu" style="margin-right:5px">
				<div class="title">Предоставляемые услуги</div>
				<list-menu :items="items">
					<template v-slot:default="{ item }">
						<a v-if="item.href || (item.article_posted && item.article_id)" :href="item.href || `/article?id=${item.article_id}`">{{item.title}}</a>
						<span v-else>{{item.title}}</span>
					</template>
				</list-menu>
			</div>
			<div class="banner-wrapper" style="height:440px">
				<img style="height:100%; width:auto;" src="/images/banners/pages/main/1.jpg">
			</div>
		</div>
  </div>
</template>

<script>
import ListItem from '../list-menu/list-item.vue';
import ListMenu from '../list-menu/list-menu.vue';
export default {
	components:{
		ListMenu,
		ListItem
	},
	data(){
		return{
			items:[]
		}
	},
	beforeMount(){
		this.updateItemsGroups();
	},
	methods:{
		updateItemsGroups(){
			axios.get("/Api/getItemsGroups")
				.then(({data})=>{
					this.items = data;
				})
		}
	}
}
</script>

<style lang="scss">
.vertical-menu{
	--color:#22212a;
	background: var(--color);
	width: fit-content;
	border-radius: 8px;
	.title{
		text-align: center;
    padding: 2px 10px;
    background: white;
    margin: 5px;
    border-radius: 4px;
    box-shadow: inset 0px 0px 3px 0px black;
		white-space: nowrap;
	}
	.list-item{
		--border: 2px solid var(--color);
		.list-title{
			border: var(--border);
			font-size: var(--font-size);
			transition: border-color 0.3s ease-in-out;
			background:  var(--color);
			color: white;
			border-radius: 6px;
			padding: 8px;
			&.active{
				background: #ff4848;
				border-color: #ff6d6d;
			}
		}
		&.child .list-title{
			box-shadow: 0px 0px 2px 0px gray;
		}
		&.root{
			&:first-child{ padding-bottom: 1px; }
			&:last-child{ padding-top: 1px;	}
		}
	}
}
.main{
	.banner-wrapper{
		overflow: hidden;
		display: flex;
		justify-content: center;
	}
}
</style>