<template>
  <div class="article">
    <div ref="wrapper">
      <iframe ref="frame" class="frame" :src="`/articledoc?id=${articleId}`" @load="iframeLoaded"></iframe>
    </div>
  </div>
</template>

<script>
export default {
  name:"v-article",
  data(){
    return{
      articleId:new URLSearchParams(window.location.search).get("id"),
    }
  },
  methods:{
    iframeLoaded() {
      let frameDocument = this.$refs.frame.contentWindow.document;
      this.update(frameDocument);
      window.addEventListener("resize",()=>this.update(frameDocument));
      frameDocument.body.style = `
        margin:0px;
        overflow:hidden;
      `;
    },
    update(frameDocument){
      this.$refs.frame.style.height = Math.max(frameDocument.documentElement.scrollHeight,this.$refs.wrapper.scrollHeight-5)+"px";
    }
  }
}
</script>

<style lang="scss">
.article{
  .frame{
    width: 100%;
    border: none;
  }
}
</style>