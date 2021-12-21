<template>
  <div class="articles">
    <div class="top-panel" v-if="editable">
      <button class="back" @click="editable=null">Назад</button>
    </div>
    <div v-else>
      <button @click="attachMenu">Привязка статей</button>
      <table>
        <th>ID</th>
        <th>Наименование</th>
        <th>Опубликована</th>
        <th>Действия</th>
        <tbody>
          <article-raw v-for="article in articles" :key="article.id" :article="article"
            @rename="saveArticle(article)"
            @edit="edit"
            @save="saveArticle">
          </article-raw>
        </tbody>
      </table>
      <button @click="addArticle()">Добавить</button>
    </div>
    <article-editor ref="editor" v-if="!attaching && editable"
      :design="editable.design"
      @save="saveArticleContent"
      @save-image="saveArticleImage">
    </article-editor>
    <div v-if="attaching && editable" class="attach-menu">
      <label>Статья</label>
      <select v-model="editable">
        <option v-for="article in articles" :key="article.id" :value="article">{{article.title}}</option>
      </select>
      <list-menu :items="itemsGroups">
        <template v-slot:active="{ item }">
          <span :class="['title',{ attached:item.article_id == editable.id }]">{{item.title}}</span>
        </template>
        <template v-slot:default="{ item }">
          <input v-model="itemToAttach" :disabled="item.article_id == editable.id" :value="item" name="select" type="radio">
          <label class="attached-title" v-if="item.article_id">Привязано: "{{ getArticleById(item.article_id).title }}"</label>
          <button v-if="item.article_id" @click="unlinkArticle(editable,item)">Отвязать</button>
        </template>
      </list-menu>
      <div v-if="itemToAttach">При нажатии на "{{itemToAttach.title}}" (в меню на сайте), вы перейдете на статью "{{editable.title}}"</div>
      <button :disabled="!itemToAttach" @click="linkArticle(editable,itemToAttach)">Привязать</button>
    </div>
  </div>
</template>

<script>
import listMenu from '../list-menu/list-menu.vue';
import articleEditor from '../editors/article-editor.vue';
import Article from '../../classes/article.js'
import ArticleRaw from './article-raw.vue'
export default {
  components: { articleEditor, ArticleRaw, listMenu },
  name:"articles-page",
  data(){
    return{
      articles:[],
      itemsGroups:[],
      editable:null,
      attaching:false,
      itemToAttach:null
    }
  },
  beforeMount(){
    this.getArticles().then(articles=>this.articles = articles);
    this.getItemsGroups().then(links=>this.itemsGroups = links);
  },
  methods:{
    //articles
    getArticles(){
      return axios.get("/Api/getArticles").then(({data})=>data.map(a=>new Article(a)))
        .catch(console.error);
    },
    saveArticleContent({design,html}){
      let article = { ...this.editable };
      article.design = design;
      article.html = html.chunks.body
      article.css = html.chunks.css;
      return axios.post("/Api/saveArticle",JSON.stringify({article}),{ headers:{ 'Content-Type': 'application/json' } })
        .then(()=>{
          window.location.reload();
        })
    },
    saveArticle(article){
      return axios.post("/Api/saveArticle",JSON.stringify({ article:new Article(article) }),{ headers:{ 'Content-Type': 'application/json' } })
    },
    saveArticleImage({ image }){
      let data = new FormData();
      data.append('articleId',this.editable.id);
      data.append('image',image);
      axios.post("/Api/saveArticleImage",data,{ headers:{ 'Access-Control-Allow-Origin': window.location.origin+"/" } }).then(({ data:fileName })=>{
        this.$refs.editor.showLink(`${window.location.origin}/images/Articles/${this.editable.id}/${fileName}`);
      })
    },
    linkArticle(article,groupItem){
      return new Promise((resolve, reject)=>{
        if(!groupItem) reject();
        axios.get("/Api/linkArticle",{ params:{ articleId:article.id, groupItemId:groupItem.id } }).then((e)=>{
          groupItem.article_id = article.id;
          alert("Ссылка на статью была успено привязана.");
          resolve(e);
        }).catch((e)=>{
          alert("Ошибка привязки");
          reject(e);
        });
      });
    },
    unlinkArticle(article,groupItem){
      return new Promise((resolve, reject)=>{
        if(!groupItem) reject();
        axios.get("/Api/unlinkArticle",{ params:{ articleId:article.id, groupItemId:groupItem.id } }).then((e)=>{
          groupItem.article_id = 0;
          alert("Ссылка на статью была успено отвязана.");
          resolve(e);
        }).catch((e)=>{alert("Ошибка");reject(e);});
      });
    },
    getArticleById(id){
      return this.articles.find(article=>article.id==id);
    },
    //menu links
    getItemsGroups(){
      return axios.get("/Api/getItemsGroups").then(({data})=>data);
    },
    edit(article){
      this.back();
      this.editable = article;
    },
    attachMenu(){
      if(!this.articles.length) return;
      this.edit(this.articles[0]);
      this.attaching = true;
    },
    back(){
      this.editable = null;
      this.attaching = false;
    },
    addArticle(){
      let title = prompt("Введите название новой статьи:","Новая статья");
      let article = new Article({ title });
      this.saveArticle().then(({data})=>{
        article.id = data.id;
        this.articles.push(article);
      }).catch(()=>{ alert("Ошибка"); });
    }
  }
}
</script>

<style lang="scss">
.articles{
  input[type="checkbox"]{
    width: 100%;
    margin: auto;
  }
  .attach-menu{
    li>span{
      cursor: pointer;
    }
    .title.attached{
      color: lightgray;
    }
    .attached-title{
      font-size: small;
      color: coral;
    }
  }
}
</style>