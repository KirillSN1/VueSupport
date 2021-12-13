import _ from "lodash";

export default class Variables{
    constructor(){
        this.map = new Map();
    }
    set(key,value = 0,cssType){
        this.map.set(key, value);
        if(cssType!=undefined)
            document.documentElement.style.setProperty("--"+_.kebabCase(key),value+cssType);
    }
    get(key,css = false){
        return css?document.documentElement.style.getPropertyValue("--"+_.kebabCase(key)):this.map.get(key);
    }
}
