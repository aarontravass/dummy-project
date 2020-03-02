var arr = [];
var x = document.getElementById("requests");
var myjson = {location: "19.8776, 75.3442", images: "https://www.google.com/search?q=universe+images&safe=active&rlz=1C1CHBD_enIN846IN846&sxsrf=ACYBGNQfIhIt-hZdy_i34e1HnT9HmNmqXw:1580722184807&tbm=isch&source=iu&ictx=1&fir=aftCVNJtkTVp9M%253A%252CyHjR_fiSw_Mj5M%252C_&vet=1&usg=AI4_-kRQLnfVaEea9HxMgyKHUKI5hhmW4A&sa=X&ved=2ahUKEwjNlcGCibXnAhVm4HMBHXWfBUEQ9QEwBHoECAoQOA#imgrc=aftCVNJtkTVp9M:"};
function Queue() {
    this.arr = [];
}

function add(item){
    arr.push(item);
}

function get(){
    return arr.splice(0,1);
}

add(x);

console.log(arr);