// 假設有一個包含所有訂單項目的陣列 orders
let orders = [
    {
       partNumber: "001",
       partName: "Part A",
       partImage: "part_a.jpg",
       quantity: 10,
       price: 20
    },
    {
       partNumber: "002",
       partName: "Part B",
       partImage: "part_b.jpg",
       quantity: 5,
       price: 15
    },
 ];



 
 const reportBody = document.getElementById("report-body");
 const addButton = document.getElementById("add-button");
 

 function generateReport() {
    
    reportBody.innerHTML = "";
 
    orders.forEach((order, index) => {
       const { partNumber, partName, partImage, quantity, price } = order;
 
   
       const totalSalesAmount = price * quantity;
 
      
       const row = document.createElement("tr");
       row.innerHTML = `
          <td>${partNumber}</td>
          <td>${partName}</td>
          <td><img src="${partImage}" alt="${partName}" width="50"></td>
          <td>${quantity}</td>
          <td>${totalSalesAmount}</td>
          <td>
             <button class="delete-button" data-index="${index}">Delete</button>
          </td>
       `;
 
       reportBody.appendChild(row);
    });
 
    const deleteButtons = document.getElementsByClassName("delete-button");
    Array.from(deleteButtons).forEach(button => {
       button.addEventListener("click", handleDelete);
    });
 }
 
 function handleDelete(event) {
    const index = event.target.dataset.index;
    orders.splice(index, 1);
    generateReport();
 }
 

 addButton.addEventListener("click", () => {
    const partNumber = prompt("Enter Spare Part Number:");
    const partName = prompt("Enter Spare Part Name:");
    const partImage = prompt("Enter Spare Part Image URL:");
    const quantity = parseInt(prompt("Enter Total Quantity:"));
    const price = parseFloat(prompt("Enter Price:"));
 
   
    const newOrder = {
       partNumber,
       partName,
       partImage,
       quantity,
       price
    };
 
    orders.push(newOrder);
 
   
    generateReport();
 });
 
 generateReport();