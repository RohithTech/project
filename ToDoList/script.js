let contenttoadd = document.querySelector("input");

contenttoadd.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
        functiontoadd();
    }
});
function functiontoadd() {
    let list = document.querySelector(".ordertos");
    console.log("hi");
    
    if (contenttoadd.value.trim() === "") {
        return;
    }

    let createnewlist = document.createElement("li");
    let checkbox = document.createElement("input");
    let edit = document.createElement("button");
    edit.innerText = "✏️"
    edit.addEventListener("click", () => {
        contenttoadd.value = createnewlist.innerText.slice(0, length - 2);
        createnewlist.replaceChildren(contenttoadd.value);
        createnewlist.remove();

    })
    checkbox.type = "checkbox";
    createnewlist.textContent = contenttoadd.value + " ";
    createnewlist.appendChild(edit);
    createnewlist.appendChild(checkbox);
    list.appendChild(createnewlist);

    contenttoadd.value = "";
}


function finishedtasks() {
    let checkboxes = document.querySelectorAll("input[type='checkbox']");

    checkboxes.forEach(cb => {
        if (cb.checked) {
            let listItem = cb.parentElement;
            listItem.remove();   // ✅ remove entire <li>
            console.log("Item removed");
        }
    });
}

