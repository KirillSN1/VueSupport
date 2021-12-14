<template>
  <div class="list-menu">
    <list-item v-for="item in items" :key="item.id" :root="item.parent==false">
      <template v-slot:title>
        <slot :item="item"></slot>
      </template>
      <list-menu :items="item.children">
        <template v-slot:default="data">
          <slot :item="data.item"></slot>
        </template>
      </list-menu>
    </list-item>
  </div>
</template>

<script>
import ListItem from './list-item.vue'
export default {
  name:"list-menu",
  components:{
    ListItem
  },
  props:{
    items:[Array,Object]
  }
}
</script>

<style>

</style>