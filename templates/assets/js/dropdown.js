
function openDropDown() {
    document.getElementById("myDropdown").style.display = "block";
    document.getElementById("caret_up").style.display ="none";
    document.getElementById("caret_down").style.display ="block";
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        document.getElementById("myDropdown").style.display = "none";
        document.getElementById("caret_up").style.display ="block";
        document.getElementById("caret_down").style.display ="none";
    }
}