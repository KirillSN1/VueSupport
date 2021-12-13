<template>
  <div class="top-banner" :style="`height:${height}px`">
    <div class="image-wrapper" :style="`height:${this.imageHeight}px`">
      <img :src="src" :style="`transform:translateY(calc(${-(scroll*0.5)}px - ${offset}));`"/>
      <div class="banner-title" :style="`opacity:${(50-scrollProcent)*2}%;`">МИР КОСМЕТИКИ</div>
    </div>
  </div>
</template>

<script>
export default {
  name:"top-banner",
  props:{
    offset:{
      type:String,
      default:"20px"
    },
    src:{
      type:String,
      required:true
    },
    height:{
      type:Number,
      default(){
        return 0;
      }
    },
    'image-height':{
      type:Number,
      default(){
        return this.height;
      }
    }
  },
  data(){
    return{
      scroll:0,
    }
  },
  computed:{
    scrollProcent(){
      return Math.min(this.height?(this.scroll*100)/this.height:0,100);
    }
  },
  mounted(){
    document.addEventListener("scroll",()=>{ this.scroll = document.scrollingElement.scrollTop });
  }
}
</script>

<style lang="scss">
.top-banner{
  position: relative;
  pointer-events: none;
  user-select: none;
  .banner-title{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    color: #ffa5b9;
    z-index: 10;
    font-size: 50px;
    font-weight: 600;
    font-family: 'Mont';
  }
  .image-wrapper{
    overflow: hidden;
    max-height: 100vh;
    img {
      height: auto;
    }
  }
}
</style>