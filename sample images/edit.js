


$(document).ready(function(){
	$(".wish-icon i").click(function(){
		$(this).toggleClass("fa-heart fa-heart-o");
	});
});	



function confirmDelete(itemID) {
    var confirmation = confirm("delete？");
    if (confirmation) {
      deleteItem(itemID);
    }
  }
  function deleteItem(itemID) {
    document.getElementById('itemID').value = itemID;
    document.getElementById('deleteForm').submit();
  }



  function add() {
   
    var itemID = document.getElementById("itemID").value;
    var itemName = document.getElementById("itemName").value;
  
   
    var table = document.querySelector("table");
    var newRow = table.insertRow(-1);
  
 
    var cell1 = newRow.insertCell(0);
    cell1.innerHTML = itemID;
    var cell2 = newRow.insertCell(1);
    cell2.innerHTML = itemName;
    var cell3 = newRow.insertCell(2);
    cell3.innerHTML = '<button onclick="confirmDelete(this.parentNode.parentNode)">Delete</button>';

    document.getElementById("itemID").value = "";
    document.getElementById("itemName").value = "";
  }

  function confirmDelete(row) {
    if (confirm("Are you sure wnat to Delete?")) {
      row.parentNode.removeChild(row);
    }
  }



  function searchItem() {
    
    var itemID = document.getElementById("itemID").value;
  
    console.log("searching: " + itemID + " Item");
  }