
function FillStar(nb) {
    var stars = document.getElementsByName("star");
    var star_fill = document.createElement("i");
    star_fill.setAttribute("class", "bi bi-star-fill")
    var count = 0
    stars.forEach(element => {
        count += 1;
        if (count <= nb) {
            element.replaceWith(star_fill);
        }
    });
    console.log("hello")
}