<template>
  <tr>
    <td>{{article.id}}</td>
    <td>
      <input ref="nameInput" v-if="oldName!=null" v-model="article.title" type="text" @change="$emit('rename',{ old:oldName }); oldName = null">
      <a v-else :href="`/article?id=${article.id}`" target="_blank">{{article.title}}</a>
    </td>
    <td>
      <select v-model="article.posted" @change="$emit('save',article)">
        <option :value="1">Да</option>
        <option :value="0">Нет</option>
      </select>
    </td>
    <td>
      <button @click="oldName = article.title; $nextTick(()=>$refs.nameInput.focus())">Переименовать</button>
      <button @click="$emit('edit',article)">Редактировать</button>
    </td>
  </tr>
</template>

<script>
export default {
  name:"article-raw",
  props:{
    article:{
      type:Object,
      required:true
    }
  },
  data(){
    return{
      oldName:null
    }
  }
}
</script>

<style>

</style>