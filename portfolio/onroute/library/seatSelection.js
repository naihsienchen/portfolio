window.onload = function(){
    //get button by id 
    var tableCells = document.getElementsByClassName("available");

    for(var i = 0; i<tableCells.length; i++){
        var iter = parseInt(i);
        var thisCell = tableCells[iter]; 
        thisCell.onclick = function(){
            /* remove selected class from all other cells */
            for(let cell of tableCells){
                cell.classList.remove("selected");
            }

            /* Select current cell*/
            this.classList.add("selected");
        };
    };
}
