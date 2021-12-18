<template>
  <div>
		
  </div>
</template>

<script>
export default {
	components:{

	},
	data(){
		return{
		}
	},
	beforeMount(){
		
	},
	methods:{
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
</style>