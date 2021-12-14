<template>
  <div :class="['list-item',{ root },{child:!root}]" :style="`min-width:${this.width}px;`" @mouseenter="opened = true" @mouseleave="opened = false">
    <div :class="['list-title',{active:opened}]" >
      <div class="content" ref="title">
        <slot name="title"></slot>
      </div>
    </div>
    <div ref="menu" @transitionstart="update" :style="`top:${top}px; left:${left}px;`" :class="['menu',{ opened }]"><slot></slot></div>
  </div>
</template>

<script>
export default {
  name:"list-item",
  props:{
    root:Boolean
  },
  data(){
    return{
      top:0,
      left:0,
      opened:false,
      width:0
    }
  },
  mounted(){
    new ResizeObserver(()=>this.updateWidth).observe(this.$el.parentElement);//при изменении размера родителя, постраиваемся под его размер
    new ResizeObserver((e)=>this.$emit("resize",e)).observe(this.$refs.title);//при изменении собственого размера контента генерируем событие
    //подписываемся на тоже событие, но только соседей того же типа, чтобы знать, когда они изменят свой размер и в последствии обновить свой
    //это нужно для того, чтобы отследить в том числе и уменьшение размера контента
    this.$parent.$children.forEach(component=>{
      if(component == this || component.constructor != this.constructor) return;
        component.$on("resize",this.updateWidth);
    })
    document.addEventListener("scroll",()=>{//обновляем позицию всклывающей части
      if(this.opened) this.update()
      else this.opened = false;
    })
  },
  methods:{
    updateWidth(){
      this.width = 0;//сбрасываем ограничение размера по минимуму
      this.$nextTick(()=>{//после перерисовки присваимаем новую ширину родителя
        this.width = this.$el.parentElement.getBoundingClientRect().width;
      })
    },
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
  padding: 2px;
  .list-title{
    min-width: 100%;
    .content{
      width: fit-content;
    }
  }
  .list-title, menu{
    cursor: pointer;
    width: max-content;
  }
  .menu{
    position: fixed;
    height: fit-content;
    overflow: hidden;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    pointer-events: none;
    transition: 1s ease-in-out;
    transition-property: left, top;
    &.opened{
      opacity: 1;
      pointer-events: all;
      transition: opacity 0.3s ease-in-out;
    }
  }
}
</style>