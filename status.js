const view_in = document.querySelector("#view-in");
const inp = document.querySelector("#input");

const view_forw = document.querySelector("#view-forw");
const forw = document.querySelector("#forward");

const view_out = document.querySelector("#view-out");
const out = document.querySelector("#output");

view_in.addEventListener("click",function(){
    if(inp.style.display === 'grid'){
        inp.style.display = "none";
    }
    else{
        inp.style.display = 'grid';
    }
});
view_forw.addEventListener("click",function(){
    if(forw.style.display === 'grid'){
        forw.style.display = "none";
    }
    else{
        forw.style.display = 'grid';
    }
});
view_out.addEventListener("click",function(){
    if(out.style.display === 'grid'){
        out.style.display = "none";
    }
    else{
        out.style.display = 'grid';
    }
});