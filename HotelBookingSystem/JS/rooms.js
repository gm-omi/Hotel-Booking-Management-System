

function loadRoomTypes()
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let response = JSON.parse(this.responseText);
            let data = response.data;
            let select = document.getElementById("roomTypeId");
            let current = select.value;

            select.innerHTML = "<option value=''>Select Type</option>";

            for(let i = 0; i < data.length; i++)
            {
                let opt = document.createElement("option");
                opt.value = data[i].id;
                opt.text = data[i].name;

                if(data[i].id == current)
                {
                    opt.selected = true;
                }

                select.appendChild(opt);
            }
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=getRoomTypes");
}



function loadRooms()
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let response = JSON.parse(this.responseText);
            let data = response.data;
            let rows = "";

            for(let i = 0; i < data.length; i++)
            {
                let room = data[i];

                // Color-coded badge based on OCCUPANCY STATUS
                let occupancyClass = "badge ";

                if(room.occupancy_status === "Available")
                {
                    occupancyClass += "badge-success";
                }
                else if(room.occupancy_status === "Booked")
                {
                    occupancyClass += "badge-warning";
                }
                else if(room.occupancy_status === "Maintenance")
                {
                    occupancyClass += "badge-danger";
                }

                // Status badge for toggle
                let statusClass = "badge ";
                let displayStatus = "";

                if(room.status === "available")
                {
                    statusClass += "badge-success";
                    displayStatus = "Available";
                }
                else
                {
                    statusClass += "badge-danger";
                    displayStatus = "Maintenance";
                }

                rows += "<tr>";
                rows += "<td style='text-align:center'>" + room.id + "</td>";
                rows += "<td style='text-align:center'>" + room.room_number + "</td>";
                rows += "<td style='text-align:center'>" + room.floor + "</td>";
                rows += "<td>" + room.room_type + "</td>";
                rows += "<td style='text-align:center'><span class='" + occupancyClass + "'>" + room.occupancy_status + "</span></td>";
                rows += "<td style='text-align:center'><span class='" + statusClass + " clickable' style='cursor:pointer;' onclick='toggleStatus(" + room.id + ")'>" + displayStatus + "</span></td>";
                rows += "<td style='text-align:center'><button class='btn btn-primary btn-sm' onclick='editRoom(" + room.id + ")'>Edit</button> <button class='btn btn-danger btn-sm' onclick='deleteRoom(" + room.id + ")'>Delete</button></td>";
                rows += "</tr>";
            }

            document.getElementById("roomsTable").innerHTML = rows;
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=load");
}



function toggleStatus(id)
{
    if(!confirm("Toggle maintenance status for this room?"))
    {
        return;
    }

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let response = JSON.parse(this.responseText);

            if(response.success)
            {
                showMessage("Status toggled successfully!", "success");
                loadRooms();
            }
            else
            {
                showMessage("Failed to toggle status!", "error");
            }
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=toggle_status&id=" + encodeURIComponent(id));
}



function addRoom()
{
    let room_number = document.getElementById("roomNumber");
    let floor = document.getElementById("floor");
    let room_type_id = document.getElementById("roomTypeId");
    let status = document.getElementById("status");

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let res = JSON.parse(this.responseText);

            showMessage(res.message, res.success ? "success" : "error");

            if(res.success)
            {
                loadRooms();
                clearForm();
            }
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.send(
        "action=add" +
        "&room_number=" + encodeURIComponent(room_number.value) +
        "&floor=" + encodeURIComponent(floor.value) +
        "&room_type_id=" + encodeURIComponent(room_type_id.value) +
        "&status=" + encodeURIComponent(status.value)
    );
}



function deleteRoom(id)
{
    if(!confirm("Delete this room?"))
    {
        return;
    }

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let res = JSON.parse(this.responseText);

            showMessage(res.message, res.success ? "success" : "error");

            if(res.success)
            {
                loadRooms();
            }
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=delete&id=" + encodeURIComponent(id));
}


function editRoom(id)
{
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let response = JSON.parse(this.responseText);
            let data = response.data;

            document.getElementById("roomId").value = data.id;
            document.getElementById("roomNumber").value = data.room_number;
            document.getElementById("floor").value = data.floor;
            document.getElementById("roomTypeId").value = data.room_type_id;
            document.getElementById("status").value = data.status;
            document.getElementById("formTitle").innerText = "Edit Room";
            document.getElementById("messageBox").innerHTML = "";
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=getRoom&id=" + encodeURIComponent(id));
}



function updateRoom()
{
    let room_id = document.getElementById("roomId");
    let room_number = document.getElementById("roomNumber");
    let floor = document.getElementById("floor");
    let room_type_id = document.getElementById("roomTypeId");
    let status = document.getElementById("status");

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let res = JSON.parse(this.responseText);

            showMessage(res.message, res.success ? "success" : "error");

            if(res.success)
            {
                loadRooms();
                clearForm();
            }
        }
    };

    xhttp.open("POST", "../Controller/AdminRoomController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.send(
        "action=update" +
        "&id=" + encodeURIComponent(room_id.value) +
        "&room_number=" + encodeURIComponent(room_number.value) +
        "&floor=" + encodeURIComponent(floor.value) +
        "&room_type_id=" + encodeURIComponent(room_type_id.value) +
        "&status=" + encodeURIComponent(status.value)
    );
}



function saveRoom()
{
    let id = document.getElementById("roomId").value;

    if(id !== "")
    {
        updateRoom();
    }
    else
    {
        addRoom();
    }
}



function clearForm()
{
    document.getElementById("roomId").value = "";
    document.getElementById("roomNumber").value = "";
    document.getElementById("floor").value = "";
    document.getElementById("roomTypeId").value = "";
    document.getElementById("status").value = "available";
    document.getElementById("formTitle").innerText = "Add Room";
}



function showMessage(msg, type)
{
    let color = type === 'success' ? 'green' : 'red';

    document.getElementById('messageBox').innerHTML = '<div style="color:' + color + ';padding:10px;">' + msg + '</div>';

    setTimeout(function()
    {
        document.getElementById('messageBox').innerHTML = '';
    }, 3000);
}

/* LOAD ROOM TYPES ON PAGE LOAD */

loadRoomTypes();
loadRooms();