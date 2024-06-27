function fetchData() {
    var min = 150, max = 200, max1 = 500, max2 = 1000, max3 = 1500;
    //Uber
    var pg = Math.round(Math.random() * (max - min) + min);
    document.getElementById("price1").innerHTML += pg;
    var pg = Math.round(Math.random() * (max - min) + min);
    document.getElementById("price2").innerHTML += pg;
    var pg = Math.round(Math.random() * (max - max1) + max1);
    document.getElementById("price3").innerHTML += pg;
    var pg = Math.round(Math.random() * (max - max1) + max1);
    document.getElementById("price4").innerHTML += pg;
    var pg = Math.round(Math.random() * (max3 - max2) + max2);
    document.getElementById("price5").innerHTML += pg;

    //Ola
    var pg = Math.round(Math.random() * (max - min) + min);
    document.getElementById("price6").innerHTML += pg;
    var pg = Math.round(Math.random() * (max - min) + min);
    document.getElementById("price7").innerHTML += pg;
    var pg = Math.round(Math.random() * (max - max1) + max1);
    document.getElementById("price8").innerHTML += pg;
    var pg = Math.round(Math.random() * (max - max1) + max1);
    document.getElementById("price9").innerHTML += pg;
    var pg = Math.round(Math.random() * (max3 - max2) + max2);
    document.getElementById("price10").innerHTML += pg;
}