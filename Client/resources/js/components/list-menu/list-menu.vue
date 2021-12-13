<template>
  <div>
    <div v-for="item,index in data" :key="index">
    </div>
  </div>
</template>

<script>
export default {
  name:"list-menu",
  props:{
    data:Array
  }
}
</script>

<style>

</style>