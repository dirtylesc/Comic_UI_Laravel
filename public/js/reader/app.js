/////////////////Trả ra các thể loại của truyện khi hover vào Browse...
var list_hover_1 = document.querySelectorAll(".list-hover-1 .left a");
var list_items = document.querySelectorAll(".list-hover-1 .right .list li");
var list_hover_2 = document.querySelectorAll(".list-hover-2 a");

function mouseOver1() {
    list_hover_1.forEach((list, n) => {
        list.addEventListener("mouseover", function () {
            list.classList.add("hover");
            list_items[n].classList.add("block");
            for (let index = 0; index < list_hover_1.length; index++) {
                if (index != n) {
                    list_hover_1[index].classList.remove("hover");
                    list_items[index].classList.remove("block");
                }
            }
        });
    });
}
window.addEventListener("mouseover", mouseOver1);

function mouseOver2() {
    list_hover_2.forEach((list) => {
        list.addEventListener("mouseover", function () {
            list.style.backgroundColor = "#3b66f5";
        });
    });
}

function mouseOut2() {
    list_hover_2.forEach((list) => {
        list.addEventListener("mouseout", function () {
            list.style.backgroundColor = "#25262f";
        });
    });
}
window.addEventListener("mouseover", mouseOver2);
window.addEventListener("mouseout", mouseOut2);

// //--------------------SORT RANKING DESC------------------------
// var mockDataRanking = mockDataFeatures;

// // sortDESC()
// function dynamicSort(property) {
//     var sortOrder = 1;
//     if (property[0] === "-") {
//         sortOrder = -1;
//         property = property.substr(1);
//     }
//     return function (a, b) {
//         /* next line works with strings and numbers,
//          * and you may want to customize it to your needs
//          */
//         var result =
//             a[property] < b[property] ? -1 : a[property] > b[property] ? 1 : 0;
//         return result * sortOrder;
//     };
// }

// ------------------------NOTIFICATION------------------------------

const toasts = {
    success: {
        icon: '<i class="fas fa-check-circle"></i>',
        noti: "This is a success notification !",
    },
    error: {
        icon: '<i class="fas fa-exclamation-circle"></i>',
        noti: "This is a error notification !",
    },
    warning: {
        icon: '<i class="fas fa-exclamation-triangle"></i>',
        noti: "This is a warning notification !",
    },
    email_error: {
        icon: '<i class="fas fa-exclamation-triangle"></i>',
        noti: "Your Email's incorrect. Again!",
    },
    email_success: {
        icon: '<i class="fas fa-exclamation-triangle"></i>',
        noti: "Your Email's correct. Thanks!",
    },
    re_pass_error: {
        icon: '<i class="fas fa-exclamation-triangle"></i>',
        noti: "Password and Re-Password aren't match!",
    },
    gmail_error: {
        icon: '<i class="fas fa-exclamation-triangle"></i>',
        noti: "Please fill your Gmail. Thanks!",
    },
    username_error: {
        icon: '<i class="fas fa-exclamation-triangle"></i>',
        noti: "Username already exitst. Please try!",
    },
    sign_up_success: {
        icon: '<i class="fas fa-exclamation-triangle"></i>',
        noti: "Sign up account success. Thanks <3",
    },
    login_success: {
        icon: '<i class="fas fa-exclamation-triangle"></i>',
        noti: "Login account success. Thanks <3",
    },
    login_error: {
        icon: '<i class="fas fa-exclamation-triangle"></i>',
        noti: "Your username or password is incorrect!",
    },
};

function notification_f(status) {
    let toast = document.createElement("div");
    toast.className = `toast ${status}`;
    toast.classList.add('showing');

    toast.innerHTML = `
    ${toasts[status].icon}
    ${toasts[status].noti}
    <span class="timeline"></span>
    `;

    console.log(123);

    document.querySelector(".notification").appendChild(toast);
    setTimeout(() => {
        toast.style.animation = "slide_hide 2s ease forwards";
        setTimeout(() => {
            toast.remove();
        }, 2100);
    }, 4100);
}

// log_in_btn.onclick = () => {
//     document.getElementById("ul_login").style.display = "block";
//     document.getElementById("ul_signup").style.display = "none";
// };

///Check Account To Sign Up or Login
const rex_e = /^\w+([.]\w+)?@\w+\.\w+(\.\w+)?$/;
let vitri = 1;

// document.getElementById("submit_2").onclick = () => {
//     let check = true;
//     for (let i = 0; i < vitri; i++)
//         if (
//             document.querySelector("#username_signup input").value ===
//             listUser[i]
//         )
//             check = false;

//     if (check) {
//         if (
//             document.querySelector("#username_signup input").value.trim() != ""
//         ) {
//             if (document.querySelector("#gmail input").value.match(rex_e)) {
//                 if (
//                     document.querySelector("#password_signup input").value ===
//                     document.querySelector("#re_password input").value &&
//                     document
//                         .querySelector("#password_signup input")
//                         .value.trim() != "" &&
//                     document.querySelector("#re_password input").value.trim() !=
//                     ""
//                 ) {
//                     listUser[vitri] = document.querySelector(
//                         "#username_signup input"
//                     ).value;
//                     listPass[vitri] = document.querySelector(
//                         "#password_signup input"
//                     ).value;
//                     document.querySelector("#username_login input").value = "";
//                     document.querySelector("#password_login input").value = "";
//                     document.querySelector("#username_signup input").value = "";
//                     document.querySelector("#password_signup input").value = "";
//                     document.querySelector("#gmail input").value = "";
//                     document.querySelector("#re_password input").value = "";

//                     document.getElementById("ul_login").style.display = "block";
//                     document.getElementById("ul_register").style.display = "none";
//                     vitri++;

//                     notification_f("sign_up_success");
//                 } else notification_f("re_pass_error");
//             } else notification_f("gmail_error");
//         }
//     } else notification_f("username_error");
// };

// document.getElementById("submit_1").onclick = () => {
//     let i = 0;
//     if (vitri == 0) notification_f("login_error");
//     else {
//         for (; i < vitri; i++) {
//             if (
//                 document.querySelector("#username_login input").value ===
//                 listUser[i] &&
//                 document.querySelector("#password_login input").value ===
//                 listPass[i]
//             ) {
//                 notification_f("login_success");

//                 setInterval(function () {
//                     document
//                         .querySelector(".log_function")
//                         .classList.remove("hold_show");
//                     document.querySelector("#username_login input").value = "";
//                     document.querySelector("#password_login input").value = "";
//                     document.querySelector(".user_login").style.display =
//                         "block";
//                     document.querySelector(".log_in").style.display = "none";
//                 }, 4000);

//                 if (listUser[i].includes("admin"))
//                     document.getElementById(
//                         "my_profile"
//                     ).innerHTML += `<i class="fas fa-user"></i><a href="admin.html">My Profile</a>`;
//                 else
//                     document.getElementById(
//                         "my_profile"
//                     ).innerHTML += `<i class="fas fa-user"></i><a href="user_info.html?id=${listUser[i]}">My Profile</a>`;
//                 break;
//             }
//         }
//     }
// };
$(document).ready(function () {
    $("#close_box").click(function () {
        $("#contact-box").remove();
    });
});
