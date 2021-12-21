<template>
  <ul class="list-menu">
    <li :class="{ opened:opened.includes(index), empty:!Object.keys(item.children).length }" v-for="(item, index) in items" :key="index">
      <span @click="opened.includes(index)?opened.remove(index):opened.push(index)"><slot name="active" :item="item"></slot></span>
      <slot :item="item"></slot>
      <list-menu v-show="opened.includes(index)" v-if="item.children" :items="item.children">
        <template v-slot:active="{ item:child }">
          <slot name="active" :item="child"></slot>
        </template>
        <template v-slot:default="{ item:child }">
          <slot :item="child"></slot>
        </template>
      </list-menu>
    </li>
  </ul>
</template>

<script>
export default {
  name:"list-menu",
  props:{
    items:[Array,Object]
  },
  data(){
    return{
      opened:[]
    }
  }
}
</script>
<style lang="scss">
.list-menu{
  li{
    list-style-type: disclosure-closed;
    &.opened{
      list-style-type: disclosure-open;
    }
    &.empty{
      list-style-type:circle;
    }
  }
}
</style>