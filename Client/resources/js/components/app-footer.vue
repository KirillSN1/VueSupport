<template>
  <div class="app-footer">
		<div class="footer-categories">
			<div class="category" v-for="category in footerCategories" :key="category.id">
				<h3 :class="['title',{ interactive:category.href }]">{{category.title}}</h3>
				<ul class="paragraphs">
					<li :class="['paragraph',{ interactive:paragraph.href }]" v-for="paragraph in category.paragraphs" :key="paragraph.id">
						<a :href="paragraph.href">{{paragraph.text}}</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name:"app-footer",
	data(){
		return {
			footerCategories:[
				{ id:0, title:"Меню", paragraphs:[{ id:0, title:"Главная страница", href:"" }] }
			]
		}
	},
	beforeMount(){
		this.updateFooterGroups();
	},
	methods:{
		updateFooterGroups(){
			return axios
				.get("/Api/getFooterGroups")
				.then((response)=>{
					this.footerCategories = response.data;
				})
				.catch(console.error);
		}
	}
}
</script>

<style lang="scss">
.app-footer{
	min-height: 50px;
	box-sizing: border-box;
	background: #22212a;
	font-weight: 100;
	.footer-categories{
		display: flex;
		.category {
			width: 100%;
			&:hover > .title{
				color: pink;
			}
			.title {
				color: white;
				margin: 15px;
				cursor: default;
				.interactive{
					cursor: pointer;
					text-decoration: underline;
				}
			}
			.paragraphs {
				list-style-type: none;
				cursor: default;
				.paragraph{
					color: #ffffff85;
					& > a{
						cursor: default;
					}
					&.interactive{
						list-style-type: disclosure-closed;
						cursor: pointer;
						& > a{
							cursor: pointer;
						}
						&:hover {
							color: white;
						}
					}
				}
			}
		}
	}
}
</style>