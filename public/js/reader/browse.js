document.onclick = (e) => {
    if (e.target.id == "nothing")
        document.getElementById("side-middle").classList.remove("hold_right")
}

document.querySelector("#side-middle h2").onclick = () => {
    document.getElementById("side-middle").classList.add("hold_right")
}