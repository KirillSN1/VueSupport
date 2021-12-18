export default function ulFrom(val,isArrayContent){
    if(Array.isArray(val))
        return (isArrayContent?"":"<ul>") + val.map((item)=>'<li>'+output(item)+'</li>').join("")+(isArrayContent?"":"<ul/>");
    else return val || "нет";
}