

function OnClickStar(nb) {
    var stars = document.getElementsByName("star");
    var input = document.getElementById("ratingStar");
    var count = 0
    stars.forEach(element => {
        count += 1;
        if (count <= nb) {
            element.setAttribute("class", "bi bi-star-fill");
        }
        else{
            element.setAttribute("class", "bi bi-star");
        }
    });
    input.setAttribute("value", nb)
}