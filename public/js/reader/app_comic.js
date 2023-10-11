// for(let i = 0; i < 6; i++) {
//     var newCom = document.createElement("div")
//     newCom.classList.add("comic")

//     newCom.innerHTML = `
//         <a href=""><img src="${mockDataFeatures[indexCom].picture}" alt=""></a>
//         <h3 class="fs17 fw900 cl9">${mockDataFeatures[indexCom].name}</h3>
//         <p class="fs14 cl6">${mockDataFeatures[indexCom].text}</p>
//         <div class="rate">
//             <div class="star">
//                 <i class="fas fa-star s1 fs18"></i>
//                 <i class="fas fa-star s2"></i>
//                 <i class="fas fa-star s3"></i>
//                 <i class="fas fa-star s4"></i>
//                 <i class="fas fa-star s5"></i>
//             </div>
//             <span class="star_avg fs18 cl9">${mockDataFeatures[indexCom].star}</span>
//         </div>
//     `
//     console.log(indexCom)
//     indexCom++;
//     more_comics.appendChild(newCom)
// }

var list_hover_1 = document.querySelectorAll(".list-hover-1 .left a");
var list_items = document.querySelectorAll(".list-hover-1 .right .list li");

function mouseOver1() {
  list_hover_1.forEach((list, n) => {
    list.addEventListener("mouseover", function () {
      list.classList.toggle("hover");
      list_items[n].classList.toggle("block");
    });
  });
}

window.addEventListener("mouseover", mouseOver1);

/////////Change background:
var list_function = document.querySelectorAll(".mid_function .function i");
var bg_function_up = document.querySelector(".mid_function .bg_function");
var ch_function_up = document.querySelector(".mid_function .chapter_function");
var list_color_background = document.querySelectorAll(
  ".mid_function .bg_function .bg_color span"
);

list_function.forEach((e, n) => {
  e.addEventListener("click", () => {
    if (n == 1) {
      bg_function_up.classList.toggle("holdup");
      ch_function_up.classList.remove("holdup");
    }
    if (n == 0) {
      bg_function_up.classList.remove("holdup");
      ch_function_up.classList.toggle("holdup");
    }
  });
});

let n_1 = 0;
list_color_background.forEach((e, n) => {
  e.addEventListener("click", () => {
    list_color_background[n].classList.toggle("change");
    if (n_1 != n) {
      if (n == 1) {
        document.querySelector(".top").style.backgroundColor = "#1F2129";
        document.querySelector(".top").style.color = "#B1C2CC";
        document.querySelector(".top .logo h2").style.color = "white";
        document.querySelector(".library_forum").className = 'library_forum color';
        document.querySelector(".top .logo").style.border = "1px solid white"
        document.querySelector(
          ".middle .reading_detail"
        ).style.backgroundColor = "black";
      } else if (n == 0) {
        document.querySelector(".top").style.backgroundColor = "white";
        document.querySelector(".top").style.color = "black";
        document.querySelector(".top .logo h2").style.color = "black";
        document.querySelector(".top .logo").style.border = "1px solid black"
        document.querySelector(".library_forum").className = 'library_forum';
        document.querySelector(".middle .reading_detail").style.backgroundColor = "#F2F2F2";
      } else {
        document.querySelector(".top").style.backgroundColor = "#76848F";
        document.querySelector(".top").style.color = "#bfe7ff";
        document.querySelector(".top .logo h2").style.color = "whitesmoke";
        document.querySelector(".top .logo").style.border = "1px solid white"
        document.querySelector(".library_forum").className = 'library_forum color_3';
        document.querySelector(".middle .reading_detail").style.backgroundColor = "#F2F2F2";
      }
      n_1 = n;
    }
  });
});

