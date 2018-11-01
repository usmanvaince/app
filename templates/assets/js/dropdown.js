
function openDropDown() {
    document.getElementById("myDropdown").style.display = "block";
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        document.getElementById("myDropdown").style.display = "none";
    }
}