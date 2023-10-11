//----Hiển thị và đổi màu label male và female của NOVELS
var list_show = document.querySelectorAll(".list_checked ul");
var list_label = document.querySelectorAll(".list_checked p label");

list_label.forEach((item, index) => {
  item.addEventListener("click", function () {
    if (index == 0) {
      list_show[index].classList.add("show");
      list_show[1].classList.remove("show");
      list_label[index].style.backgroundColor = "white";
      list_label[1].style.backgroundColor = "#eeeff9";
      list_label[index].style.color = "#3b66f5";
      list_label[1].style.color = "rgba(18,18,23,.9)";
    } else {
      list_show[index].classList.add("show");
      list_show[0].classList.remove("show");
      list_label[index].style.backgroundColor = "white";
      list_label[0].style.backgroundColor = "#eeeff9";
      list_label[index].style.color = "#3b66f5";
      list_label[0].style.color = "rgba(18,18,23,.9)";
    }
    adf(0)
    list_clicked = document.querySelectorAll(".list_checked ._on .show li a")
    clicked_func();
  });
});


//////////////////////////////////////////////////////////////////

// var list_clicked = document.querySelectorAll(".list_checked ._on .show li a")
// var tag_clicked = document.querySelector(".list_checked ._on .show li a.clicked").textContent

// export let clicked = 0
// function adf(n) {
//   if (list_clicked[clicked] != undefined && list_clicked[n] != undefined) {
//     list_clicked[clicked].classList.remove("clicked")
//     list_clicked[n].classList.add("clicked")
//     tag_clicked = list_clicked[n].textContent
//   }

//   //REMOVE CHILRD BEFORE ADD NEW CHILRD
//   while (list_comics.hasChildNodes()) {
//     list_comics.removeChild(list_comics.firstChild);
//   }

//   // change_comics(tag_clicked)

//   if (clicked != n)
//     clicked = n
// }

// export function clicked_func(m) {
//   list_clicked.forEach((e, n) => {
//     if (m != undefined) clicked = m;
//     e.addEventListener("click", () => {
//       if (clicked != n) {
//         console.log(clicked + " " + n)
//         adf(n)
//       }
//     })
//   })
// }

//Hiển thị và thu hồi các thuộc tính của con các GENRE
var list_genre = document.querySelectorAll(".list_checked .genre");
var list_title = document.querySelectorAll(".list_checked .title");
var list_angle = document.querySelectorAll(".list_checked .title i");

let n = 0;
list_title.forEach((item, index) => {
  item.addEventListener("click", function () {
    list_genre[index].classList.add("_on");
    list_genre[n].classList.remove("_on");
    list_clicked = document.querySelectorAll(".list_checked ._on .show li a")
    clicked_func();
    list_title[index].style.border = "none";
    list_title[n].style.borderBottom = "1px solid #eaebfb";
    list_angle[index].classList.add("up");
    list_angle[n].classList.remove("up");
    if (n != index) n = index;
    else n = 3;
  });
});

//////////////////////////////////////////////////////////
// var list_comics = document.querySelector(".list_comics")
// var list_load_comic = document.querySelector(".list_load_comic")

// add_load_comic()

// export function change_comics(tag_click, sort_click) {
//   add_load_comic()

//   //Cắt pointer để thực hiện việc load Ảnh. Tránh việc hiển thị 2 lần.
//   var ul_show = document.querySelector(".list_checked ._on")
//   if (ul_show != null)
//     ul_show.style.pointerEvents = "none"

//   list_title.forEach((item, m) => {
//     item.style.pointerEvents = "none"
//   })

//   setTimeout(() => {
//     let mockDataNew = mockData;
//     if (sort_click != "popular") {
//       if (sort_click == "rating")
//         mockDataNew.sort(dynamicSort("-star"));
//       else if (sort_click == "timeupdated") {
//         mockDataNew.sort((date1, date2) => {
//           date1 = date1.time.split('/').reverse().join('/');
//           date2 = date2.time.split('/').reverse().join('/');
//           if (date1 < date2) {
//             return -1;
//           } else if (date1 > date2) {
//             return 1;
//           } else {
//             return 0;
//           }
//         });
//         mockDataNew.reverse();
//       }
//     }

//     if ((tag_click == undefined ? "All" : tag_click) == "All") {
//       mockDataNew.forEach((item) => {
//         add_comics(item)
//       })
//     }
//     else {
//       mockDataNew.forEach((item => {
//         if (item.tag_1.includes(tag_click) || item.tag_2.includes(tag_click) || item.tag_3.includes(tag_click)) {
//           add_comics(item)
//         }
//       }))
//     }

//     list_title.forEach(item => {
//       item.style.pointerEvents = "all"
//     })
//     if (ul_show != null)
//       ul_show.style.pointerEvents = "all"
//   }, 870)
// }

//--------------------SORT RANKING DESC------------------------

// function dynamicSort(property) {
//   var sortOrder = 1;
//   if (property[0] === "-") {
//     sortOrder = -1;
//     property = property.substr(1);
//   }
//   return function (a, b) {
//     /* next line works with strings and numbers,
//      * and you may want to customize it to your needs
//      */
//     var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
//     return result * sortOrder;
//   }
// }
