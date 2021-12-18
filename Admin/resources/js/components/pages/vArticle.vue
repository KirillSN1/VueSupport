<template>
  <div>
    <div v-if="article">
      <h1>{{article.title}}</h1>
      <div>
        {{article.text}}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name:"v-article",
  data(){
    return{
      article:null
    }
  },
  beforeMount(){
    this.getArticle();
  },
  methods:{
    getArticle(){
      axios.get("/Api/getArticle?"+new URLSearchParams(window.location.search).toString())
        .then(({data})=>{
          this.article = data;
        })
    }
  }
}
</script>

<style>

</style>