const themeToggler = document.querySelector(".theme-toggler");
// const searchToggler = document.querySelector("button-search-changeable");
const body = document.querySelector('body');

submitForms = function () {
    document.getElementById("form1").submit();
    document.getElementById("form2").submit();
}

// window.addEventListener('hashchange', function() {
//     // console.log('Hash was changed!')

// },false);

// var tabContainer = document.getElementById("ChangeTab");
// const tabContainer = document.getElementById("ChangeTab");

// // Get all buttons with class="btn" inside the container
// var tablinks = tabContainer.getElementsByClassName("tablinks");

// // Loop through the buttons and add the active class to the current/clicked button
// for (var i = 0; i < tablinks.length; i++) {
//     tablinks[i].addEventListener("click", function () {
//         var current = document.getElementsByClassName("activeTab");
//         current[0].className = current[0].className.replace(" activeTab", "");
//         this.className += " activeTab";
//         AdminTableTab();
//     });
// }

// function AdminTableTab(clicked_id){
//     var url2 = window.location.href.split('?tab=')[1]
//     var url1 =''
//     var cl=event.target.className;
//     // alert(clicked_id);
//     if (url2 == 'apartment') {
//         url1 = window.location.href.replace('apartment' , 'account');
//         tabContainer.querySelector('li:nth-child(2)').classList.add('activeTab');
//         tabContainer.querySelector('li:nth-child(1)').classList.remove('activeTab');
//     }
//     else {
//         url1 = window.location.href.replace('account' , 'apartment');
//         tabContainer.querySelector('li:nth-child(1)').classList.add('activeTab');
//         tabContainer.querySelector('li:nth-child(2)').classList.remove('activeTab');
//     }
//     window.location.href = url1;
// }

// function AdminApartment(){
//     var url2 = window.location.href.split('?tab=')[1]
//     var url1 =''
//     var Tab = document.getElementById("TabApartment");
//     url1 = window.location.href.replace(url2 , 'apartment');
//     window.location.href = url1;
//     if (Tab.classList.contains("activeTab")) {
//         Tab.classList.remove('activeTab');
//     }
//     Tab.classList.add("activeTab");
// }



function toggleDark() {
    if (body.classList.contains('dark-theme-variables')) {
        body.classList.remove('dark-theme-variables');
        localStorage.setItem("theme", "light");
    } else {
        body.classList.add('dark-theme-variables');
        localStorage.setItem("theme", "dark");
    }
}
// themeToggler.addEventListener('click', toggleDark());
themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables');
    if (body.classList.contains('dark-theme-variables')) {
        themeToggler.querySelector('span:nth-child(2)').classList.add('active');
        themeToggler.querySelector('span:nth-child(1)').classList.remove('active');
        localStorage.setItem("theme", "dark");
    } else {
        themeToggler.querySelector('span:nth-child(1)').classList.add('active');
        themeToggler.querySelector('span:nth-child(2)').classList.remove('active');
        localStorage.setItem("theme", "light");
    }
    // themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
    // themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
})
if (localStorage.getItem("theme") === "dark") {
    body.classList.add('dark-theme-variables');
    themeToggler.querySelector('span:nth-child(2)').classList.add('active');
    themeToggler.querySelector('span:nth-child(1)').classList.remove('active');
}
// themeToggler.addEventListener('click', () => {
//     document.body.classList.toggle('dark-theme-variables');
//     themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
//     themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
// })

function openTab(evt, Tab) {
    // Declare all variables
    var i, tabcontent, tablinks;
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    // Get all elements with class="tablinks" and remove the class "activeTab"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" activeTab", "");
    }
    // Show the current tab, and add an "activeTab" class to the button that opened the tab
    document.getElementById(Tab).style.display = "block";
    evt.currentTarget.className += " activeTab";
}

function openTable(evt, Tab) {
    // Declare all variables
    var i, tabcontent, tablinks;
    
    // Get all elements with class="admin-form-table" and hide them
    tabcontent = document.getElementsByClassName("admin-form-table");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    // Get all elements with class="tablinks" and remove the class "activeTab"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" activeTab", "");
    }
    // Show the current tab, and add an "activeTab" class to the button that opened the tab
    document.getElementById(Tab).style.display = "block";
    evt.currentTarget.className += " activeTab";
}
function openTable2(evt, Tab) {
    // Declare all variables
    var i, tabcontent, tablinks;
    // Get all elements with class="admin-form-table" and hide them
    tabcontent = document.getElementsByClassName("admin-message-tab");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    // Get all elements with class="tablinks" and remove the class "activeTab"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" activeTab", "");
    }
    // Show the current tab, and add an "activeTab" class to the button that opened the tab
    document.getElementById(Tab).style.display = "block";
    evt.currentTarget.className += " activeTab";
}
// function hideMessage() {
//     document.getElementById("message-error").style.display = "none";
// };
// setTimeout(hideMessage, 2000);


function seacrhIntoTable() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}