<template>
  <div class="articles-page">
    <h1>Статьи</h1>
    <div class="articles">
      <div v-for="article in articles" :key="article.id">
        <img v-if="article.image" :src="article.image">
        <a :href="`/article?id=${article.id}`" >{{article.title}}</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name:"articles-page",
  data(){
    return{
      articles:[]
    }
  },
  beforeMount(){
    this.updateArticles();
  },
  methods:{
    updateArticles(){
      axios.get("/Api/getArticlesTitles")
        .then(({data})=>{
          this.articles = data;
        })
    }
  }
}
</script>

<style>

</style>