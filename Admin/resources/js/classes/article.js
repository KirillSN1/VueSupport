export default class Article{
  constructor(props){
    props = props || {};
    this.css = props.css || null,
    this.design = props.design || null,
    this.html = props.html || null,
    this.id = props.id || 0,
    this.posted = props.posted || 0,
    this.title = props.title || ""
  }
}