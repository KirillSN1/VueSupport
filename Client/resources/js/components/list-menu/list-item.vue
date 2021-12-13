<template>
  <div class="list-item" @mouseenter="opened = true" @mouseleave="opened = false">
    <div class="list-title"><slot name="title"></slot></div>
    <div ref="menu" @transitionstart="update" :style="`top:${top}px; left:${left}px;`" :class="['menu',{ opened }]"><slot></slot></div>
  </div>
</template>

<script>
export default {
  name:"list-item",
  data(){
    return{
      top:0,
      left:0,
      opened:false
    }
  },
  mounted(){
    document.addEventListener("scroll",()=>{
      if(this.opened) this.update()
      else this.close()
    })
  },
  methods:{
    update(){
      let rect = this.$el.getBoundingClientRect();
      this.top = rect.top;
      this.left = rect.right;
    }
  }
}
</script>

<style lang="scss">
.list-item{
  position: relative;
  width: fit-content;
  .list-title, menu{
    background: black;
    color: white;
    border-radius: 8px;
    padding: 8px;
    width: max-content;
    cursor: pointer;
  }
  .menu{
    position: fixed;
    height: fit-content;
    overflow: hidden;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    pointer-events: none;
    &.opened{
      opacity: 1;
      pointer-events: all;
      transition: opacity 0.3s ease-in-out;
    }
  }
}
</style>