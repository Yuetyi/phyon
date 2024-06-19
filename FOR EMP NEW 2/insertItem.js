function addData() { 
    // Get input values 
    let name = 
        document.getElementById("nameInput").value; 
    let email = 
        document.getElementById("NumberInput").value; 
    let mobile = 
        document.getElementById("Qty numberInput").value; 
    let address = 
        document.getElementById("DescriptionInput").value; 
    
    // Get the table and insert a new row at the end 
    let table = document.getElementById("outputTable"); 
    let newRow = table.insertRow(table.rows.length); 
    
    // Insert data into cells of the new row 
    newRow.insertCell(0).innerHTML = name; 
    newRow.insertCell(1).innerHTML = email; 
    newRow.insertCell(2).innerHTML = mobile; 
    newRow.insertCell(3).innerHTML = address; 
    newRow.insertCell(4).innerHTML = 
        '<button onclick="editData(this)">Edit</button>'+ 
        '<button onclick="deleteData(this)">Delete</button>'; 
    
    // Clear input fields 
    clearInputs(); 
} 

function editData(button) { 
    
    // Get the parent row of the clicked button 
    let row = button.parentNode.parentNode; 
    
    // Get the cells within the row 
    let nameCell = row.cells[0]; 
    let emailCell = row.cells[1]; 
    let mobileCell = row.cells[2]; 
    let addressCell = row.cells[3]; 

    
    // Prompt the user to enter updated values 
    let nameInput = 
        prompt("Enter the updated name:", 
            nameCell.innerHTML); 
    let NumberInput = 
        prompt("Enter the Number details:", 
            emailCell.innerHTML); 
    let QtynumberInput = 
        prompt("Enter the Qty details:", 
            mobileCell.innerHTML 
        ); 
    let DescriptionInput = 
        prompt("Description", 
            addressCell.innerHTML 
        ); 


    
    // Update the cell contents with the new values 
    nameCell.innerHTML = nameInput; 
    emailCell.innerHTML = NumberInput; 
    mobileCell.innerHTML = QtynumberInput; 
    addressCell.innerHTML = DescriptionInput;
    WightCell.innerHTML = WightInput; 
} 
function deleteData(button) { 
    
    // Get the parent row of the clicked button 
    let row = button.parentNode.parentNode; 

    // Remove the row from the table 
    row.parentNode.removeChild(row); 
} 
function clearInputs() { 
    
    // Clear input fields 
    document.getElementById("nameInput").value = ""; 
    document.getElementById("NumberInput").value = ""; 
    document.getElementById("Qty numberInput").value = ""; 
    document.getElementById("DescriptionInput").value = ""; 

} 



function handleFileUpload() {
    const fileInput = document.getElementById('sparePartImage');
    const file = fileInput.files[0];
  
    if (file) {
      const reader = new FileReader();
  
      reader.onload = function(event) {
        const image = new Image();
        image.src = event.target.result;

        const imageContainer = document.getElementById('imageContainer');
        imageContainer.appendChild(image);
      };
  
      reader.readAsDataURL(file);
    }
  }







//iD auto create 
  function generateItemId() {
    const timestamp = Date.now().toString(); // Get the current timestamp as a string
    const randomNum = Math.floor(Math.random() * 10000).toString().padStart(4, '0'); // Generate a random 4-digit number
  
    const itemId = timestamp + randomNum; // Concatenate the timestamp and random number
  
    return itemId;
  }
  
  // Usage example
  const itemId = generateItemId();
  console.log(itemId);