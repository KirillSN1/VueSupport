<template>
  <div>
    <table>
      <th>Наименование</th>
      <th>Опубликована</th>
      <tbody>
        <tr v-for="article in articles" :key="article.id">
          <td>{{article.title}}</td>
          <td></td>
        </tr>
      </tbody>
    </table>
    <article-editor v-if="selected"></article-editor>
  </div>
</template>

<script>
import articleEditor from '../editors/article-editor.vue'
export default {
  components: { articleEditor },
  name:"articles-page",
  data(){
    return{
      articles:[],
      selected:null,
    }
  },
  beforeMount(){
    this.getArticles().then(articles=>this.articles = articles);
  },
  methods:{
    getArticles(){
      return axios.get("/Api/getArticles").then(({data})=>data)
        .catch(console.error);
    }
  }
}
</script>

<style>

</style>