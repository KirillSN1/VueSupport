<template>
  <div class="about-contents">
    <h1 class="page-title">Немного о нас</h1>
    <div>
      <div v-for="category in categories" :key="category.id">
        <h3>{{category.title}}</h3>
        <ul>
          <li v-for="paragraph in category.paragraphs" :key="paragraph.id">{{paragraph.text}}</li>
        </ul>
      </div>
      <img class="banner" src="/images/banners/about.jpg">
    </div>
  </div>
</template>

<script>
export default {
  name:"about",
  data(){
    return {
      categories:[]
    }
  },
  beforeMount(){
    this.updateAboutGroups();
  },
  methods:{
    updateAboutGroups(){
      return axios.get("/Api/getAboutGroups")
      .then(({data})=>{
        this.categories = data;
      }).catch(console.error);
    }
  }
}
</script>

<style>
.about-contents{
  /* font-size: calc(var(--font-size) - 30%) !important; */
}
</style>