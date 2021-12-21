<template>
	<div id="article-editor">
    <div class="actions-header">
      <div>
        <input :disabled="!loaded" type="submit" class="article-save-b" @click="saveDesign()" value="Сохранить и выйти"/>
        <input :disabled="!loaded" type="button" class="article-save-b" @click="discardChanges" value="Отменить изменения дизайна"/>
      </div>
      <input type="text" class="project-state" :value="projectState" readonly="readonly"/>
      <input ref="imageLink" type="text" class="project-state link" placeholder="URL изображения будет здесь."/>
    </div>
		<div id="editorContainer"></div>
	</div>
</template>

<script>
export default {
	props:{
    design:Object
	},
  data(){
    return{
      projectState:"",
      loaded:false,
      defaultHtml:"",
      optionsOpened:false,
      unlayerOptions:{
        init:{
          id: 'editorContainer',
          projectId: 1234,
          displayMode: 'web',
          locale: 'ru-RU'
        }
      }
    }
  },
  async mounted(){
    this.projectState = "Загрузка...";
    this.unlayer = await this.injectScript('//editor.unlayer.com/embed.js','unlayer');
    this.unlayer.init(this.unlayerOptions.init);
    this.loadDesign();
    this.configurateImageSource();
    this.initAutosave();
  },
  methods: {
    injectScript(src,objectName){
      let scriptEl = document.createElement('script');
      scriptEl.setAttribute('src',src);
      return new Promise((resolve, reject)=>{
        scriptEl.onload = ()=>{resolve(window[objectName]);}
        document.body.appendChild(scriptEl);
      });
    },
    loadDesign(){
      if(this.design){
        this.unlayer.loadDesign(this.design);
        this.unlayer.exportHtml((data)=>{this.defaultHtml = data.chunks.body});
        this.projectState = "Загружено";
        this.loaded = true;
      }
      else
        this.projectState = "Дизайн не найден";  
    },
    configurateImageSource(){
      this.unlayer.addEventListener('image',(file, done)=>{
        let data = new FormData();
        this.$emit("save-image",{ image:file.attachments[0] })
      });
    },
    showLink(link){
      this.$refs.imageLink.value = link;
    },
    initAutosave() {
      this.unlayer.addEventListener('design:updated',(data)=>{
        if(this.autosave)
          this.saveDesign();
      });
    },
    saveDesign() {
      this.unlayer.saveDesign((design) => {
        this.unlayer.exportHtml((html)=>{
          if(design == null || html == null){
            this.projectState = 'Ошибка сохранения'
            return false;
          }
          this.$emit("save", { design, html });
          this.projectState = "Сохранено";
        });
      });
      this.projectState = "Сохранение...";
    },
    discardChanges(){
      this.unlayer.saveDesign((design) => {
        let defaultJson = JSON.stringify(this.design);
        let currentJson = JSON.stringify(design);
        if(defaultJson.length>2 && currentJson.length>2 && (defaultJson != currentJson)){
          this.unlayer.loadDesign(this.design);
          this.saveDesign();
          this.projectState = "Изменения сброшены";
        }
        this.projectState = "Изменения не обнаружены";
        return;
      });
    }
  }
}
</script>
<style lang="scss">
.app-body{
  height: 100%;
}
#article-editor{
  height: 100%;
  min-width: max-content;
  display: flex;
	flex-direction: column;
}
#editorContainer{
	height: 740px;
  display: flex;
}
#editor-1{
  min-width: 100%
}
.article-save-b{
  width: max-content;
  border-color: #ffffff;
  background-color: #d3d3d3;
  outline: none;
  box-shadow: none;
  border-radius: 3px;
}
.actions-header{
  display: flex;
  justify-content: space-between;
  width: 100%;
  background-color:#931515;
  padding: 10px;
  min-width: max-content;
}
.project-state{
  width: 40%;
  background-color: #882020;
  border:2px solid #6b1818;
  outline: none;
  color: whitesmoke;
  text-align: center;
}
.link{
  width: 300px;
  background-color: white;
  color: black;
  margin-left: 0;
}
.editor-options-body{
  background-color: white;
  right: 10px;
  border-radius: 4px;
  padding: 0px 3px;
  border:1px solid rgb(133, 133, 133);
}
</style>