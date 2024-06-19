var infoArray = []; // Array to store added information

  function toggleInfoForm() {
    var form = document.getElementById("infoForm");
    if (form.style.display === "none") {
      form.style.display = "block";
    } else {
      form.style.display = "none";
    }
  }

 

  function updateInfoList(listElement) {
    listElement.innerHTML = ""; // Clear the information list

    for (var i = 0; i < infoArray.length; i++) {
      var infoItem = document.createElement("div");
      infoItem.innerHTML = `
        <p>${infoArray[i]}</p>
        <button onclick="deleteInfo(${i})">Delete</button>
      `;
      listElement.appendChild(infoItem);
    }
  }

  function deleteInfo(index) {
    infoArray.splice(index, 1); // Remove the information from the array
    var infoList = document.getElementById("infoList");
    updateInfoList(infoList); // Update the information list
  }

  function deleteInfo(index) {
    infoArray.splice(index, 1); // Remove the information from the array
    
    var infoList = document.getElementById("infoList");
    updateInfoList(infoList); // Update the information list
    
    window.location.href = "profile.html"; // Redirect back to the profile page
  }





  function addItem() {
    var itemName = document.getElementById("itemName").value;
    var itemDescription = document.getElementById("itemDescription").value;

    var item = document.createElement("li");
    item.textContent = itemName + " - " + itemDescription;

    var deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete";
    deleteButton.onclick = function() {
        item.parentNode.removeChild(item);
    };

    item.appendChild(deleteButton);
    document.getElementById("itemList").appendChild(item);

    document.getElementById("itemName").value = "";
    document.getElementById("itemDescription").value = "";
}

function saveItems() {
    var itemList = document.getElementById("itemList").getElementsByTagName("li");
    var items = [];

    for (var i = 0; i < itemList.length; i++) {
        var itemText = itemList[i].textContent.split(" - ");
        var itemName = itemText[0];
        var itemDescription = itemText[1];
        items.push({ name: itemName, description: itemDescription });
    }


    alert("Items saved successfully!");
}

function changeProfile() {
  var newProfileImage = prompt("Enter the URL(Image)：");

  var profileImageElement = document.querySelector(".profile_img");
  profileImageElement.setAttribute("src", newProfileImage);
}



function changeName() {
  var newName = prompt("Enter new name:");

  // Update the name
  var nameElement = document.querySelector(".card-header h3");
  nameElement.innerHTML = newName;
}
